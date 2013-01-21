// JavaScript Document

function findPosX(obj) {
// X-координата слоя
  currleft = 0;
  if (obj.offsetParent)
    while (obj.offsetParent) {
      currleft += obj.offsetLeft;
      obj = obj.offsetParent;
    }
  else if (obj.x) currleft += obj.x;
  return currleft;
}

function findPosY(obj) {
// Y-координата слоя
  currtop = 0;
  if (obj.offsetParent)
    while (obj.offsetParent) {
      currtop += obj.offsetTop;
      obj = obj.offsetParent;
    }
  else if (obj.y) currtop += obj.y;
  return currtop;
}

function getDocumentHeight()
{
	return document.body.offsetHeight;
}

//Размер документа по горизонтали
function getDocumentWidth()
{
	return document.body.offsetWidth;
}

function setOuterHTML(ElementID, txt)
{
	someElement = document.getElementById(ElementID);
	if (someElement)
	{
		par = someElement.parentNode;
		par.removeChild(someElement);
	}
}

function ParseRequest(parsedcode)
{
	NewCode = {};
	q = new Date()
	timestamp = q.getTime();

	id = timestamp;
	html = parsedcode;
	NewCode["id"] = "hdw_"+id;
	NewCode["code"] = html;
	return NewCode;
}

GetCode = new Ajax.Request('',{});

//класс HTML - окна
//ServerProcessor - обработчик на стороне сервера
//ServerParameters - параметры, передаваемые на сервер
//ClientProcessors - обработчики для слоя HTML-окна
//parentlayer_id - слой-родитель
//onSuccess, onFailure, onLoading - обработчики на завершение загрузки окна, на облом загрузки и на процесс загрузки
function HTMLWindow(ServerProcessor, ServerParameters, ClientProcessors, parentlayer_id, onSuccess, onFailure, onLoading)
{
	this.ServerProcessor = ServerProcessor;
	this.ClientProcessors = ClientProcessors;
	this.ServerParameters = ServerParameters;
	this.parentlayer = document.getElementById(parentlayer_id);

	this.onAjaxSuccess = onSuccess;
	this.onAjaxFailure = onFailure;
	this.onAjaxLoading = onLoading;
	this.windowcode = {};
	this.windowcode["id"] = ParseRequest('')["id"];

//прибить слой окна
	this.CloseWindow = function()
	{
		setOuterHTML(this.windowcode["id"],"");
		this.windowcode = {};
	}
	
//отправить запрос на серв
	this.GetCode = function(getcodeurl, getcodeparameters, win)
	{
		NewCode = new Ajax.Request(getcodeurl, 
			{ 
				parameters:getcodeparameters,
				method:'post',  
				onSuccess: function(req)
				{
					wincode = ParseRequest(req.responseText);
					win.OpenWindow(wincode,win.windowcode["id"],win.parentlayer);
					//win.windowcode["id"] = wincode["id"];
					win.onAjaxSuccess();
				},
				onFailure: function(req)
				{
					win.onAjaxFailure();
				},
				onLoading: function(req)
				{
					win.onAjaxLoading();
				}
			});
	}
	
	this.Update = function(ServerParameters, win)
	{
		NewCode = new Ajax.Request(win.ServerProcessor, 
			{ 
				parameters:ServerParameters,
				method:'post',  
				onSuccess: function(req)
				{
					wincode = ParseRequest(req.responseText);
					win.UpdateWindow(wincode,win.windowcode["id"],win.parentlayer);
					win.onAjaxSuccess();
				},
				onFailure: function(req)
				{
					win.onAjaxFailure();
				},
				onLoading: function(req)
				{
					win.onAjaxLoading();
				}
			});	
	}

	this.UpdateWindow = function(req, id, win)
	{
		setOuterHTML(this.windowcode["id"],"");
		win.innerHTML += "<div id=\""+this.windowcode["id"]+"\" "+win.ClientProcessors+">"+req["code"]+"</div>";
	}
	
	this.OpenWindow = function(req, id, win)
	{
		if (document.getElementById(req["id"]))
		{
			setOuterHTML(req["id"],"");
			win.innerHTML += "<div id=\""+id+"\" "+win.ClientProcessors+">"+req["code"]+"</div>";
		}
		else
		{
			win.innerHTML += "<div id=\""+id+"\" "+win.ClientProcessors+">"+req["code"]+"</div>";		
		}
	}
	this.GetCode(this.ServerProcessor, this.ServerParameters, this);
	return this;
}

//собсна многооконность

//класс-контейнер окон
HDWS = function()
{
	this.current = "";
	this.wins = new Array();
	
	this.setcur = function(id)
	{
		found = false;
		j=0;
		while ((found != true)&&(j<this.wins.length))
		{
			if (this.wins[j].div.id == id)
			{
				found = true;
			}
			else
			{
				j++;
			}
		}
		if (found)
		{
			savefound = this.wins[j];
			for (i=j;i<this.wins.length;i++)
			{
				this.wins[i] = this.wins[i+1];
			}
			this.wins[this.wins.length-1] = savefound;
			this.current = this.wins[this.wins.length-1].div.id;
		}
	}
	
	this.openwin = function(addme, sc_params)
	{
		newlayer = new HDW(this, addme, sc_params);
		
		this.wins.push(newlayer);
		this.current = this.wins[this.wins.length-1].div.id;
		return newlayer;
	}
	
	this.closewin = function(id)
	{
		this.setcur(id);
		this.wins[this.wins.length-1].closeHDW();
		this.wins.pop();
		if (this.wins[this.wins.length-1])
		{
			this.current = this.wins[this.wins.length-1].div.id;
		}
	}
	
	this.furl = function(id)
	{
		this.setcur(id);
		this.wins[this.wins.length-1].furl();
	}

	this.sweep = function(id)
	{
		this.setcur(id);
		this.wins[this.wins.length-1].sweep();
	}

	this.redrawall = function()
	{
		for (i=0;i<this.wins.length;i++)
		{
			this.wins[i].div.style.zIndex = i;
		}
	}
}

//класс конкретного окна
function HDW(hdws, content, sc_params)
{
	this.div = null;
	this.hdws = hdws;
	this.sc_params = sc_params;
	
	this.openHDW = function(DOMString)
	{
		newdiv = document.createElement("DIV");

		q = new Date();
		timestamp = q.getTime();
		newid = timestamp;

		newdiv.id = 'hdw_'+newid;
		newdiv.className = 'hdwslayer';
		newdiv.hdw = this;
		while(document.getElementById(newdiv.id))
		{
			q = new Date();
			timestamp = q.getTime();
			newid = timestamp;

			newdiv.id = 'hdw_'+newid;
		}
		
		newdivheader = document.createElement("DIV");
		newdivcloser = document.createElement("DIV");

		newdivfurler = document.createElement("DIV");
		newdivsweeper = document.createElement("DIV");
		
		newdivheadertextcontainer = document.createElement("DIV");
		newdivheadertext = document.createTextNode(DOMString);
		
		newdivcontent = document.createElement("DIV");
		newdivcontent.id = 'hdwc_'+newid;

		newdivcontent.className = "hdwscontent";
	
		newdivheader.className = "hdwsheader";
		newdivcloser.className = "hdwscloser";
		newdivfurler.className = "hdwsfurler";
		newdivsweeper.className = "hdwssweeper";
		newdivheadertextcontainer.className="hdwsheadertext";
		
		document.body.appendChild(newdiv);
		newdivheadertextcontainer.appendChild(newdivheadertext);

		newdivheader.appendChild(newdivcloser);
		
		newdivheader.appendChild(newdivsweeper);
		newdivheader.appendChild(newdivfurler);
		newdivheader.appendChild(newdivheadertextcontainer);
		
		newdiv.appendChild(newdivheader);
		newdiv.appendChild(newdivcontent);

		this.div = newdiv;
		newdiv.hd = new htmlDialog(this.div);	

		newdiv.hdw.sc_params['server_parameters']['hdwid'] = 'hdw_'+newid;

		GetCode = new Ajax.Request(newdiv.hdw.sc_params['server_processor'], 
									{
									'parameters':newdiv.hdw.sc_params['server_parameters'],
									'method':'post',
									'onSuccess': function(ireq)
										{
											cont = document.createElement('DIV');
											cont.className = "hdw_contents"
											cont.innerHTML = ireq.responseText;
											
											newdivcontent.appendChild(cont);
											newdiv.hdw.sc_params['onSuccess']();
										},
									'onFailure': function()
										{
											newdiv.hdw.sc_params['onFailure']();
										},
									'onLoading': function()
										{
											newdiv.hdw.sc_params['onLoading']();
										}
									});
		newdiv.hdws = this.hdws;

		this.div.firstChild.firstChild.onclick = function(){
			this.parentNode.parentNode.hdws.closewin(this.parentNode.parentNode.id);
			};

		this.div.firstChild.firstChild.nextSibling.nextSibling.onclick = function(){
			this.parentNode.parentNode.hdws.furl(this.parentNode.parentNode.id);
			}

		this.div.firstChild.firstChild.nextSibling.onclick = function(){
			this.parentNode.parentNode.hdws.sweep(this.parentNode.parentNode.id);
			}

		this.div.firstChild.onmousedown = function(){			
			hdwsme.setcur(this.parentNode.id);

			hdwsme.redrawall();
			this.parentNode.hd.startmove();
			document.body.onmousemove = function(e){
				document.getElementById(hdwsme.current).hd.setpos(e);
				document.getElementById(hdwsme.current).hd.setsize(e)};
				};
		this.div.firstChild.onmouseup = function(){
			this.parentNode.hd.stopmove();
			};
		this.div.onmousedown = function(e){
			if (window.event)
				{
					ix = window.event.clientX;
					iy = window.event.clientY;
				}
				else
				{
					ix = e.clientX;
					iy = e.clientY;
				}

			hdwsme.setcur(this.id);

			hdwsme.redrawall();
			if ((!this.hd.inmove))
			{
				if ((ix>(findPosX(this)+this.offsetWidth-20))&&(ix<(findPosX(this)+this.offsetWidth))&&(iy>(findPosY(this)+this.offsetHeight-20))&&(iy<(findPosY(this)+this.offsetHeight)))
				{
					this.hd.startresize();
					document.body.onmousemove = function(e){
						document.getElementById(hdwsme.current).hd.setpos(e);
						document.getElementById(hdwsme.current).hd.setsize(e);
						};
				}
			}
			};
		this.div.onmouseup = function(){
			this.hd.stopresize();
			};			
		this.div.onmousemove=function(e){
		//положение мышки 
			if (window.event)
				{
					ix = window.event.clientX;
					iy = window.event.clientY;
				}
				else
				{
					ix = e.clientX;
					iy = e.clientY;
				}

			if ((ix>(findPosX(this)+this.offsetWidth-20))&&(ix<(findPosX(this)+this.offsetWidth))&&(iy>(findPosY(this)+this.offsetHeight-20))&&(iy<(findPosY(this)+this.offsetHeight)))
			{
				this.style.cursor = "pointer";
			}
			else
			{
				this.style.cursor = "default";
			}
			this.hd.setsize(e);
			document.body.onmouseup=function(){
				if (document.getElementById(hdwsme.current))
				{
					document.getElementById(hdwsme.current).hd.stopresize();				
				}
				}
			}
	}
	
	this.closeHDW = function()
	{
		par = this.div.parentNode;
		par.removeChild(this.div);
		document.body.onmousemove=function(){};
	}

	this.furl = function() //свернуть как дочернее/развернуть
	{				
		if ((this.div.className=="hdwslayer")||(this.div.className=="hdwslayer_sweeped"))
		{

			if (this.div.className!='hdwslayer_sweeped')
			{
				this.div.savex = this.div.style.left;
				this.div.savey = this.div.style.top;
				this.div.saveh = this.div.style.height;
				this.div.savew = this.div.style.width;
			}
			
			this.div.className = "hdwslayer_furled";

			this.div.style.bottom = "0px";
			this.div.style.top = "";
			this.div.style.left = "0px";
			this.div.style.height = "20px";
			this.div.style.width = "200px";
		}
		else
		{
			this.div.className = "hdwslayer";

			this.div.style.bottom = "";
			this.div.style.top = this.div.savey;
			this.div.style.left = this.div.savex;
			this.div.style.height = this.div.saveh;
			this.div.style.width = this.div.savew;
		}
	}	

	this.sweep = function() //во весь экран/нормальный размер
	{
		if ((this.div.className=="hdwslayer")||(this.div.className=="hdwslayer_furled"))
		{
			if (this.div.className!='hdwslayer_furled')
			{
				this.div.savex = this.div.style.left;
				this.div.savey = this.div.style.top;
				this.div.saveh = this.div.style.height;
				this.div.savew = this.div.style.width;
			}
			
			this.div.className = "hdwslayer_sweeped";

			this.div.style.bottom = "";
			this.div.style.top = "0px";
			this.div.style.left = "0px";
			this.div.style.height = "100%";
			this.div.style.width = "100%";
		}
		else
		{
			this.div.className = "hdwslayer";

			this.div.style.bottom = "";
			this.div.style.top = this.div.savey;
			this.div.style.left = this.div.savex;
			this.div.style.height = this.div.saveh;
			this.div.style.width = this.div.savew;
		}
	}

	this.openHDW(content);
}

//класс диалога - реализует перетаскивание и изменение размера слоя
	htmlDialog = function( DOMobj )
	{
		this.DOMObj = DOMobj;

		this.DOMObj.style.left = 0;
		this.DOMObj.style.top = 0;

		this.x = findPosX(this.DOMObj);
		this.y = findPosY(this.DOMObj);

		this.width = this.DOMObj.offsetWidth;
		this.height = this.DOMObj.offsetHeight;

		this.displacementX = 0;
		this.displacementY = 0;
		this.lastDisplacementX = 0;
		this.lastDisplacementY = 0;

		this.inmove = false;
		this.inresize = false;
		
		this.startmove = function ()
		{
			this.inmove = true;
		}

		this.stopmove = function ()
		{
			this.inmove = false;

			this.lastDisplacementX=this.displacementX;
			this.lastDisplacementY=this.displacementY;

			this.displacementX=0;
			this.displacementY=0;
		}
		
		this.startresize = function()
		{
			this.inresize = true;	
		}

		this.stopresize = function()
		{
			this.inresize = false;
		}

		this.setpos = function(e)
		{
			if (this.inmove==true)
			{
				oldx = this.x;
				oldy = this.y;
				if (window.event)
				{
					this.x = window.event.clientX;
					this.y = window.event.clientY;
				}
				else
				{
					this.x = e.clientX;
					this.y = e.clientY;
				}

				if ((this.displacementX==0)&&(this.displacementY==0))
				{
					this.displacementX = findPosX(this.DOMObj) - this.x;
					this.displacementY = findPosY(this.DOMObj) - this.y;
				}
				
				if ((((this.x+this.displacementX)>0)&&((this.x+this.displacementX+this.DOMObj.offsetWidth)<getDocumentWidth()))||((this.x<oldx)&&((this.x+this.displacementX)>0)))
				{
					this.DOMObj.style.left = this.x + this.displacementX + "px";
				}
				else
				{
					this.x = oldx;
				}
				
				if ((((this.y+this.displacementY)>0)&&((this.y+this.displacementY+this.DOMObj.offsetHeight)<getDocumentHeight()))||((this.y<oldy)&&((this.y+this.displacementY)>0)))
				{
					this.DOMObj.style.top = this.y + this.displacementY + "px";
				}
				else
				{
					this.y = oldy;
				}
			}
		}

		this.setsize = function(e)
		{		
			if (this.inresize==true)
			{			
				if (window.event)
				{
					newwidth = window.event.clientX - this.DOMObj.style.left.substring(this.DOMObj.style.left.length-2,0)+5;
					newheight = window.event.clientY - this.DOMObj.style.top.substring(this.DOMObj.style.top.length-2,0)+5;
					
					oldwidth = this.width;
					oldheight = this.height;
					
					this.width = newwidth;
					this.height = newheight;
				}
				else
				{
					newwidth = e.clientX - this.DOMObj.style.left.substring(this.DOMObj.style.left.length-2,0)+5;
					newheight = e.clientY - this.DOMObj.style.top.substring(this.DOMObj.style.top.length-2,0)+5;

					oldwidth = this.width;
					oldheight = this.height;

					this.width = newwidth;
					this.height = newheight;
				}

				if (((findPosX(this.DOMObj)+newwidth)>0)&&((findPosX(this.DOMObj)+newwidth)<(getDocumentWidth()-2)))
				{
					this.DOMObj.style.width = this.width + "px";
				}
				else
				{
					this.width = oldwidth;
				}
				if (((findPosY(this.DOMObj)+newheight)>0)&&((findPosY(this.DOMObj)+newheight)<(getDocumentHeight()-2)))
				{		
					this.DOMObj.style.height = this.height + "px";
				}
				else
				{
					this.height = oldheight;
				}
			}
		}
	};

hdwsme = new HDWS();