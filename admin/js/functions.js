var minH=20;
var startH=0;
var startY=0;
var textarea=null;
var oldMouseMove=null;
var oldMouseUp=null;

function textareaResizer(e){
	if (e == null) { e = window.event }
	if (e.preventDefault) {
		e.preventDefault();
	};
	resizer = (e.target != null) ? e.target : e.srcElement;
	textarea = document.getElementById(
	resizer.id.substr(0,resizer.id.length-8)
	);
	startY=e.clientY;
	startH=textarea.offsetHeight;
	oldMouseMove=document.onmousemove;
	oldMouseUp=document.onmouseup;
	document.onmousemove=textareaResizer_moveHandler;
	document.onmouseup=textareaResizer_cleanup;
	return false;
}

function textareaResizer_moveHandler(e){
	if (e == null) { e = window.event }
	if (e.button<=1){
		curH=(startH+(e.clientY-startY));
		if (curH<minH) curH=minH;
		textarea.style.height=curH+'px';
		return false;
	}
}

function textareaResizer_cleanup(e) {
	document.onmousemove=oldMouseMove;
	document.onmouseup=oldMouseUp;
}

/*----------------------------------------------------------------*/
/* windows */

function StructureWindow(parentid,parentdivid)
{
	parentdiv = document.getElementById(parentdivid);
	if ((!parentdiv.puppy)||(parentdiv.puppy==null))
	{
		parentdiv.puppy = new HTMLWindow ('/admin/modules/structure/handler/getStructure.handler.php', 
		{
			'htmlwindow'			: 'getContent.tpl.php',
			'htmlwindowprocessor'	: '/structure/handler/getSubStructure.php',
			'parentlayerid'			: parentid,
			'parentdivid'			: parentdivid,
			'sessid'				: sess
		},
		'',
		parentdivid,
		function(){},
		function(){},
		function(){}
		);
	}
	else {
		parentdiv.puppy.CloseWindow();
		parentdiv.puppy = null;
	}
}

function OpenFileWin(parentid)
{

	hdwsme.openwin('Редактирование файла',
	{
		'server_processor': '/admin/modules/filemanager/handler/getRedactor.handler.php',
		'server_parameters':
		{
			'htmlwindow': 'getContent.tpl.php',
			'htmlwindowprocessor': 'filemanager/handler/RedactFile.php',
			'parentlayerid': parentid,
			'sessid': sess
		},
		'client_processors':'',
		'onSuccess':function(){},
		'onFailure':function(){},
		'onLoading':function(){}
	}
	);
}

function OpenImageWin(parentid)
{
	hdwsme.openwin('Просмотр изображений',
	{
		'server_processor': '/admin/modules/filemanager/handler/getRedactor.handler.php',
		'server_parameters':
		{
			'htmlwindow': 'getContent.tpl.php',
			'htmlwindowprocessor': '/filemanager/handler/ViewImage.php',
			'parentlayerid':parentid,
			'sessid': sess
		},
		'client_processors':'',
		'onSuccess':function(){},
		'onFailure':function(){},
		'onLoading':function(){}
	}
	);
}

function SaveFileContent(parentid, hdwprefix)
{
	NewCode = new Ajax.Request('/admin/modules/filemanager/handler/getRedactor.handler.php',
	{
		parameters:
		{
			'htmlwindow':'getContent.tpl.php',
			'htmlwindowprocessor': '/filemanager/handler/RedactFile.php',
			'parentlayerid': parentid,
			'sessid': sess,
			'newcontent': document.getElementById(hdwprefix+'_form[content]').value,
			'filename': document.getElementById(hdwprefix+'_form[filename]').value
		},
		method: 'post',
		onSuccess: function(req){},
		onFailure: function(req){},
		onLoading: function(req){}
	});
}

function chdir(newdir)
{
	NewCode = new Ajax.Request('/admin/modules/filemanager/handler/getFileList.handler.php',
	{
		parameters:
		{
			'htmlwindow': 'getContent.tpl.php',
			'htmlwindowprocessor': '/filemanager/handler/ChDir.php',
			'parentlayerid': '',
			'subpath': newdir,
			'sessid': sess
		},
		method: 'post',
		onSuccess: function(req){ $_id('globalparent').innerHTML = req.responseText; },
		onFailure: function(req){},
		onLoading: function(req){}
	});
}

function SaveNewFile(parentid, hdwprefix)
{
	if (document.getElementById('fm_filename').value != "") {


		NewCode = new Ajax.Request('/admin/modules/filemanager/handler/getFileList.handler.php',
		{
			parameters:
			{
				'htmlwindow': '',
				'htmlwindowprocessor': '/filemanager/handler/NewFile.php',
				'parentlayerid': parentid,
				'sessid': sess,
				'filename': document.getElementById('fm_filename').value + '.' + document.getElementById('fm_fileext').value
			},
			method: 'post',
			onSuccess: function(req){refreshlist();},
			onFailure: function(req){},
			onLoading: function(req){}
		});

	} else { alert('Введите имя файла'); }
}

function SaveNewFolder(parentid, hdwprefix)
{
	if (document.getElementById('fm_dirname').value != "") {

		NewCode = new Ajax.Request('/admin/modules/filemanager/handler/getFileList.handler.php',
		{
			parameters:
			{
				'htmlwindow': '',
				'htmlwindowprocessor': '/filemanager/handler/folder-create.handler.php',
				'parentlayerid': parentid,
				'sessid': sess,
				'foldername': document.getElementById('fm_dirname').value
			},
			method:'post',
			onSuccess: function(req){refreshlist();},
			onFailure: function(req){},
			onLoading: function(req){}
		});

		document.getElementById('fm_dirname').value = "";

	} else { alert('Введите имя директории'); }
}

function refreshlist()
{
	NewCode = new Ajax.Request('/admin/modules/filemanager/handler/getFileList.handler.php',
	{
		parameters:
		{
			'htmlwindow': 'getContent.tpl.php',
			'htmlwindowprocessor': '/filemanager/handler/ChDir.php',
			'parentlayerid': '',
			'sessid': sess
		},
		method: 'post',
		onSuccess: function(req){ document.getElementById('globalparent').innerHTML = req.responseText; },
		onFailure: function(req){},
		onLoading: function(req){}
	});
}

function getArgs() {
	var
		args=new Object(),
		query=location.search.substring(1),
		pairs=query.split("&"),
		pos,
		argname,
		value;

	for(var i=0; i<pairs.length; ++i)
	{
		pos=pairs[i].indexOf("=");
		if(pos==-1)
			continue;
		argname=pairs[i].substring(0,pos);
		value=pairs[i].substring(pos+1);
		args[argname.toLowerCase()]=unescape(value);
		//args[argname]=decodeURIComponent(value);
	}

	return(args);
}
/*----------------------------------------------------------------*/