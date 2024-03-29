// ========================
var editor_js = true;
// ========================
//pMainObj - name of MAIN object which contains all editor's methods. Used for coordinashion between different components and objects
//	pEditorFrame - link to IFRAME for visual editing
//	pFrame - link to table with editor
//	pDocument - parent document
//	pEditorDocument - document of edited file

function BXHTMLEditor(name, start_func)
{
	GLOBAL_pMainObj[name] = this;
	name_cur_obj = name;
	this.start_func = (start_func) ? start_func : function(){};
	this.pMainObj = this;
	this.arBarHandlersCache = [];
	this.name = name;
	SETTINGS[this.name] = {};
	this.showTooltips4Components = true;
	this.visualEffects = true;
	this.arUndoBuffer = [];
	this.iUndoPos = -1;
	this.sOnChangeLastType = '';
	this.customToolbars = true;
	this.bDotNet = window.bDotNet || false;
	this.limit_php_access = limit_php_access; // Limit php access
	this.bLoadFinish = false;
	this.isSubmited = false;
	// *** Limit component access (LCA) ***
	if(window.lca)
	{
		_$lca_only = false;
		_$arComponents = window._$arComponents || false;
		_$lca_to_output = _$arComponents ? true : false;
	}
	// **** Remember settings ****
	this.RS_toolbars = true;
	this.RS_taskbars = true;
	this.RS_taskbarsets = true;
	this.RS_options = true;
	this.fullEdit = (this.name == 'CONTENT');
	this.sOnChangeLastSubType = '';
	this.sLastContent = '';
	this.bSkipChanges = false;
	this.sFirstContent = null;
	this.eventsSet = false;
	if(BXEditorLoaded)
		this.OnBeforeLoad();
	else
		BXEditorRegister(this);
}

BXHTMLEditor.prototype.CreateElement = BXCreateElement;

BXHTMLEditor.prototype.OnBeforeLoad = function()
{
	this.allowedTaskbars = window['ar_' + this.name + '_taskbars'];
	this.BXPreloader = new BXPreloader(
		[
			{func: BXGetConfiguration, params: ['get_all', this]},
			{obj: this, func: this.PreloadTaskbarsData}
		],
		{
			obj : this,
			func: this.OnLoad
		}
	);
	this.BXPreloader.LoadStep();
};


BXHTMLEditor.prototype.PreloadTaskbarsData = function(oCallBack)
{
	if (this.bDotNet)
		return oCallBack.func.apply(oCallBack.obj);

	try
	{
		var settings1 = false;
		var settings2 = false;
		if (SETTINGS[this.name].arTaskbarSettings)
		{
			settings2 =  SETTINGS[this.name].arTaskbarSettings['BXComponents2Taskbar'];
			settings1 =  SETTINGS[this.name].arTaskbarSettings['BXComponentsTaskbar'];
		}

		if (this.allowedTaskbars['BXComponents2Taskbar'] && (!settings2 || settings2.show))
			this.BXPreloader.AddStep({obj: this, func: this.LoadComponents2});
		if (this.allowedTaskbars['BXComponentsTaskbar'] && (!settings1 || settings1.show))
			this.BXPreloader.AddStep({obj: this, func: this.LoadComponents1});
	}
	catch(e){_alert(this.name+': ERROR:  pMainObj.PreloadTaskbarsData');}
	oCallBack.func.apply(oCallBack.obj);
};

BXHTMLEditor.prototype.OnLoad = function()
{
	try {
	var obj = this;
	this.bShowed = true;
	this.bDragging = false;
	this.bNotSaved = false;
	this.bFirstClick = false;
	var name = this.name;
	this.className = 'BXHTMLEditor';
	this.arEventHandlers = [];
	this.pDocument = document;
	this.bTableBorder = false;
	this.pWnd = this.pDocument.getElementById(name + '_object');
	this.pValue = this.pDocument.getElementById(name);
	this.arToolbarSet = [];
	this.toolArea = [];
	this.arTaskbarSet = [];
	this.pParser = new BXParser(this);
	this.bEditSource = false;
	this.arConfig = window['ar_'+this.name+'_config'];
	this.oBXWaitWindow = new BXWaitWindow(this.name);
	this.fullEditMode = window.fullEditMode || false;
	this.pParser.ClearHBF(); // Init HBF
	window.CACHE_DISPATCHER = []; // GLOBAL CACHE
	if (this.arConfig.sBackUrl)
		this.arConfig.sBackUrl = this.arConfig.sBackUrl.replace(/&amp;/gi, '&');
	if (this.OnLoad_ex)
		this.OnLoad_ex();
	// ******** List of entities to replace **********
	if (this.arConfig["ar_entities"].toString() == '')
		this.arConfig["ar_entities"] = [];
	else
		this.arConfig["ar_entities"] = this.arConfig["ar_entities"].toString().split(',');

	var arAllEntities = {};
	arAllEntities['umlya'] = ['&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&OElig;','&oelig;','&Scaron;','&scaron;','&Yuml;'];
	arAllEntities['greek'] = ['&Alpha;','&Beta;','&Gamma;','&Delta;','&Epsilon;','&Zeta;','&Eta;','&Theta;','&Iota;','&Kappa;','&Lambda;','&Mu;','&Nu;','&Xi;','&Omicron;','&Pi;','&Rho;','&Sigma;','&Tau;','&Upsilon;','&Phi;','&Chi;','&Psi;','&Omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;'];
	arAllEntities['other'] = ['&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&Dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;','&bull;','&hellip;','&prime;','&Prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&lArr;','&uArr;','&rArr;','&dArr;','&hArr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;'];

	this.arEntities = [];
	for(var k in this.arConfig["ar_entities"])
	{
		if(arAllEntities[this.arConfig["ar_entities"][k]])
			this.arEntities = this.arEntities.concat(arAllEntities[this.arConfig["ar_entities"][k]]);
	}

	var elEntities = document.createElement("span");
	elEntities.innerHTML = this.arEntities.join(',');
	sEntities = elEntities.innerHTML;
	this.arEntities_h = sEntities.split(',');

	arAllEntities = null;
	elEntities = null;
	sEntities = null;

	this.arConfig.undosize = this.arConfig.undosize || 25;
	this.arConfig.width = this.arConfig.width || "750";
	this.pWnd.style.width = parseInt(this.arConfig.width) + (this.arConfig.width.indexOf('%') == -1 ? "px" : '%');
	this.arConfig.height = this.arConfig.height || "500";
	this.pWnd.style.height = parseInt(this.arConfig.height) + (this.arConfig.height.indexOf('%') == -1 ? "px" : '%');

	this.arToolbars = this.arConfig.arToolbars || ["standart", "style", "formating", "source", "template"];

	if(this.arConfig["customToolbars"])
		this.customToolbars = this.arConfig["customToolbars"];

	this.pForm = BXFindParentByTagName(this.pWnd, "FORM");
	if(this.pForm)
		addAdvEvent(this.pForm, 'submit', window['OnSubmit_' + this.name]);

	//Table which makes structure of Toolbarsets, taskbarsets and editor area....
	var pFrame = this.pDocument.getElementById(this.name+'_pFrame');
	//Editor area
	var cEditor = document.getElementById(this.name+'_cEditor');
	window.IEplusDoctype = (lightMode && BXIsDoctype() && BXIsIE());
	if (IEplusDoctype)
	{
		this.pFrame = pFrame;
		cEditor.parentNode.parentNode.rows[0].cells[0].parentNode.style.display = "none";
	}
	//html-editor frame
	var ifrm = document.createElement("IFRAME");
	ifrm.id = "ed_"+name;
	ifrm.setAttribute("src", "javascript:void(0)");
	ifrm.style.width = ifrm.style.height = "100%";
	ifrm.style.borderWidth = '1px';
	this.pEditorFrame = cEditor.appendChild(ifrm);

	if(this.pEditorFrame.contentDocument)
		this.pEditorDocument = this.pEditorFrame.contentDocument;
	else
		this.pEditorDocument = this.pEditorFrame.contentWindow.document;
	ifrm = null;
	//Toolbarsets creation
	if(!lightMode)
	{
		this.arToolbarSet[0] = new BXToolbarSet(this.pDocument.getElementById(this.name+'_toolBarSet0'), this, false);
		this.arToolbarSet[1] = new BXToolbarSet(this.pDocument.getElementById(this.name+'_toolBarSet1'), this, true);
		this.arToolbarSet[2] = new BXToolbarSet(this.pDocument.getElementById(this.name+'_toolBarSet2'), this, true);
		this.arToolbarSet[3] = new BXToolbarSet(this.pDocument.getElementById(this.name+'_toolBarSet3'), this, false);
	}
	//Taskbarsets creation
	this.arTaskbarSet[0] = new BXTaskbarSet(cEditor.parentNode.parentNode.rows[0].cells[0], this, 0);
	this.arTaskbarSet[1] = new BXTaskbarSet(cEditor.parentNode.cells[0], this, 1);
	this.arTaskbarSet[2] = new BXTaskbarSet(cEditor.parentNode.cells[2], this, 2);
	this.arTaskbarSet[3] = new BXTaskbarSet(cEditor.parentNode.parentNode.rows[2].cells[0], this, 3);

	this.pTaskTabs = pFrame.rows[3].cells[0];
	this.pEditorWindow = this.pEditorFrame.contentWindow;
	this.pEditorDocument.className = "pEditorDocument";
	this.pEditorDocument.pMainObj = this;
	var ta = this.CreateElement("TEXTAREA", {}, {display: 'none', height: '100%', width: '100%', overflow: 'auto'});
	if (IEplusDoctype)
	{
		this.pSourceDiv = cEditor.appendChild(this.CreateElement("DIV", {}, {display: 'none', height: '100%', width: '100%', overflowX: 'hidden', overflowY: 'auto'}));
		this.pSourceFrame = this.pSourceDiv.appendChild(ta);
	}
	else
	{
		this.pSourceFrame = cEditor.appendChild(ta);
	}

	this.pSourceFrame.onkeydown = function (e)
	{
		var tabKeyCode = 9;
		var replaceWith = "  ";
		if(window.event)
		{
			if(event.keyCode == tabKeyCode)
			{
				this.selection = document.selection.createRange();
				this.selection.text = replaceWith;
				event.returnValue = false;
				return false;
			}
		}
		else
		{
			if(e.keyCode == tabKeyCode)
			{
				var selectionStart = this.selectionStart;
				var selectionEnd = this.selectionEnd;
				var scrollTop = this.scrollTop;
				var scrollLeft = this.scrollLeft;
				this.value = this.value.substring(0, selectionStart)+ replaceWith + this.value.substring(selectionEnd);
				this.focus();
				this.setSelectionRange(selectionStart + (selectionStart != selectionEnd?0:1), selectionStart + replaceWith.length);
				this.scrollTop = scrollTop;
				this.scrollLeft = scrollLeft;
				return false;
			}
		}
	}

	pBXEventDispatcher.__Add(this);
	if (this.bDotNet && this.pASPXParser && this.pASPXParser.OnLoadSystem)
		this.pASPXParser.OnLoadSystem();

	BXHTMLEditor.prototype.OnDragDrop = function (e)
	{
		if(this.nLastDragNDropElement && this.nLastDragNDropElement>0)
		{
			var obj = this;
			setTimeout(function ()
					{
						var pComponent = obj.pEditorDocument.getElementById(obj.nLastDragNDropElement);
						if (!pComponent)
							pComponent = document.getElementById(obj.nLastDragNDropElement);

						if(obj.pEditorWindow.getSelection)
						{
							obj.pEditorWindow.getSelection().selectAllChildren(pComponent);
						}

						if (obj.nLastDragNDropElementFire !== false)
							obj.nLastDragNDropElementFire(pComponent);

						obj.OnClick(e);
						obj.OnChange("addComponent", "");
					}, 10
				);
		}
	};

	BXHTMLEditor.prototype.__ShowTableBorder = function (pTable, bShow)
	{
		var arTableBorderStyles = ["border", "borderBottom", "borderBottomColor", "borderBottomStyle", "borderBottomWidth", "borderCollapse", "borderColor", "borderLeft", "borderLeftColor", "borderLeftStyle", "borderLeftWidth", "borderRight", "borderRightColor", "borderRightStyle", "borderRightWidth", "borderStyle", "borderTop", "borderTopColor", "borderTopStyle", "borderTopWidth", "borderWidth"];
		if(!pTable.border || pTable.border == "0")
		{
			try{
				if(bShow)
				{
					pTable.setAttribute("__bxborderCollapse", pTable.style.borderCollapse);
					pTable.style.borderCollapse = "collapse";
				}
				else
				{
					pTable.style.borderCollapse = pTable.getAttribute("__bxborderCollapse");
					pTable.removeAttribute("__bxborderCollapse");
				}
			}catch(e){}

			var pCell, arCells = pTable.getElementsByTagName("TD");
			for(var j=0; j<arCells.length; j++)
			{
				pCell = arCells[j];
				if(bShow)
				{
					if(!pCell.getAttribute("__bxborder"))
					{
						pCell.setAttribute("__bxborder", BXSerializeAttr(pCell.style, arTableBorderStyles));
						pCell.style.border = "1px #ACACAC dashed";
					}
				}
				else
				{
					if(pCell.getAttribute("__bxborder"))
					{
						pCell.style.borderWidth = "";
						pCell.style.borderColor = "";
						pCell.style.borderStyle = "";
						BXUnSerializeAttr(pCell.getAttribute("__bxborder"), pCell.style, arTableBorderStyles);
						pCell.removeAttribute("__bxborder");
					}
				}
			}
		}
	};

	BXHTMLEditor.prototype.Show = function (flag)
	{
		this.bShowed = flag;
		if(flag && this.pWnd.style.display=='none')
		{
			this.pWnd.style.display='block';
		}
		else if(!flag && this.pWnd.style.display!='none')
			this.pWnd.style.display='none';
	};

	BXHTMLEditor.prototype.ShowTableBorder = function (bShow)
	{
		if(this.bTableBorder == bShow)
			return false;

		this.bTableBorder = bShow;
		var arTables = this.pEditorDocument.getElementsByTagName("TABLE");
		for(var i=0; i<arTables.length; i++)
			this.__ShowTableBorder(arTables[i], bShow);

		return true;
	};

	BXHTMLEditor.prototype.OnClick = function (e)
	{
		if(this.pOnChangeSelectionTimer)
			clearTimeout(this.pOnChangeSelectionTimer);

		this.bFirstClick = true;
		var obj = this;
		this.pOnChangeSelectionTimer = setTimeout(function (){obj.OnEvent("OnSelectionChange");}, 200);
	};

	BXHTMLEditor.prototype.OnMouseUp = function (e)
	{
		this.bFirstClick = true;
		if(this.pOnChangeSelectionTimer)
			clearTimeout(this.pOnChangeSelectionTimer);
		var obj = this;
		this.pOnChangeSelectionTimer = setTimeout(function (){obj.OnEvent("OnSelectionChange");}, 100);
	};

	this.pSourceFrame.onblur = function (e){obj.pEditorFrame.onfocus(e);};

	this.pSourceFrame.onfocus = function (e)
	{
		if(obj.bEditSource)
			return;

		obj.bEditSource = true;
		if(obj.sEditorMode=='split')
		{
			obj.SaveContent();
			obj.OnEvent('ClearResourcesBeforeChangeView');
			obj.SetCodeEditorContent(obj.GetContent());
			//obj.SetCodeEditorContent(obj.GetEditorContent(true, true));
			obj.sEditorSplitMode = 'code';
			obj.OnEvent("OnChangeView", [this.sEditorMode, this.sEditorSplitMode]);
		}
	};

	this.pEditorFrame.onfocus = function (e)
	{
		if(!obj.bEditSource)
			return;

		obj.bEditSource = false;
		if(obj.sEditorMode=='split')
		{
			obj.SetEditorContent(obj.GetCodeEditorContent());
			obj.sEditorSplitMode = 'html';
			obj.OnEvent("OnChangeView", [this.sEditorMode, this.sEditorSplitMode]);
		}
	};
	this.value = this.pValue.value;

	BXStyleParser.Create();
	this.oStyles = new BXStyles(this);

	if(this.arConfig["TEMPLATE"])
		this.SetTemplate(this.arConfig["TEMPLATE"]["ID"], this.arConfig["TEMPLATE"], true);

	// ***********************************************************************************************
	// 	Adding all toolbars and buttons to them
	// ***********************************************************************************************
	var arAllowedToolbars = window['ar_' + this.name + '_toolbars'];
	var arSet;
	if (!SETTINGS[this.name].arToolbarSettings || !this.RS_toolbars)
		SETTINGS[this.name].arToolbarSettings = arToolbarSettings_default;
	var arToolbarSettings = SETTINGS[this.name].arToolbarSettings;
	if (lightMode)
	{
		var pGlobalToolbar = new BXGlobalToolbar(this);

		for(var i = 0, l = arGlobalToolbar.length; i < l ; i++)
		{
			var arButton = arGlobalToolbar[i];
			if(!arButton || (arButton[1] && arButton[1].hideCondition && arButton[1].hideCondition(this)))
				continue;

			if (typeof(arButton) == 'object')
				pGlobalToolbar.AddButton(this.CreateCustomElement(arButton[0], arButton[1]));
			else if(arButton == 'line_begin')
				pGlobalToolbar.LineBegin();
			else if(arButton == 'line_end')
				pGlobalToolbar.LineEnd();
			else if(arButton == 'separator')
				pGlobalToolbar.AddButton(this.CreateCustomElement('BXButtonSeparator'));
		}
	}
	else
	{
		for(var sToolBarId in arToolbars)
		{
			if (arAllowedToolbars !== false && !arAllowedToolbars[sToolBarId])
			{
				delete arToolbars[sToolBarId];
				continue;
			}
			//try{
				if (!arToolbarSettings[sToolBarId])
				{
					SETTINGS[this.name].arToolbarSettings[sToolBarId] = arToolbarSettings_default[sToolBarId];
					arSet = arToolbarSettings_default[sToolBarId];
				}
				else
					arSet = arToolbarSettings[sToolBarId];
				if(BXSearchInd(this.arToolbars, sToolBarId)<0 && this.customToolbars!==true)
					continue;
				var pToolbar = new BXToolbar(this, arToolbars[sToolBarId][0], sToolBarId);
				for(var i = 0, l = arToolbars[sToolBarId][1].length; i < l ; i++)
				{
					var arButton = arToolbars[sToolBarId][1][i];
					if(!arButton || (arButton[1] && arButton[1].hideCondition && arButton[1].hideCondition(this)))
						continue;
					if(arButton != 'separator')
						pToolbar.AddButton(this.CreateCustomElement(arButton[0], arButton[1]));
					else
						pToolbar.AddButton(this.CreateCustomElement('BXButtonSeparator'));
				}
				if (arSet.docked && arSet.position)
					arDefaultTBPositions[sToolBarId] = arSet.position;
				if(arDefaultTBPositions[sToolBarId])
					this.arToolbarSet[arDefaultTBPositions[sToolBarId][0]].AddToolbar(pToolbar, arDefaultTBPositions[sToolBarId][1], arDefaultTBPositions[sToolBarId][2]);
				else
					this.arToolbarSet[0].AddToolbar(pToolbar, 100, 0);
				if (!arSet.docked && arSet.position)
					pToolbar.SetPosition(arSet.position.x,arSet.position.y);
				if (!arSet.show)
				{
					pToolbar.Close();
					continue;
				}
				pToolbar = null;
			//}catch(e){_alert("Error: loading "+sToolBarId+" toolbar"); continue;}
		}
		arSet = null;
	}
	// Init event "OnCreate" : adding all taskbars
	setTimeout(function (){BXCreateTaskbars(obj, true);}, 50);
	this.SetView("html");
	if(this.arConfig["fullscreen"])
	{
		this.pDocument.body.style.display = 'block';
		this.SetFullscreen(true);
	}
	this.start_func(this);
	pFrame.style.display = ''; // Show Editor frame
	//this.bLoadFinish = true; return alert('!');
	setTimeout(function ()
		{
			var oDiv = document.getElementById("editor_wait_window_"+obj.name);
			if (oDiv)
				oDiv.parentNode.removeChild(oDiv);
			obj.bLoadFinish = true;
			obj.SetFocus();
			try{jsUtils.onCustomEvent('EditorLoadFinish_' + obj.name);}catch(e){}
		}, 10
	);
	//setTimeout(function (){obj.SetFocus();},500);
	//Table border = ON
	this.ShowTableBorder(true);
	oBXContextMenu = this.CreateCustomElement("BXContextMenu");
	oBXContextMenu.Create();
	window.oBXVM = new BXVisualMinimize();

	jsUtils.addCustomEvent('OnToggleTabs', this.ClearPosCache, [], this);
	ar_BXTaskbarS = [];
	BXPopupWindow.bCreated = false;
	}catch(e){_alert('ERROR: BXHTMLEditor.prototype.OnLoad');} //try
};

BXHTMLEditor.prototype.SetContent = function(sContent)
{
	this.OnEvent('SetContentBefore', [sContent]);
	this.pValue.value = this.value = sContent;
	this.OnEvent('SetContentAfter', [sContent]);
};

BXHTMLEditor.prototype.GetContent = function()
{
	this.OnEvent('GetContent');
	return this.value.toString();
};

BXHTMLEditor.prototype.LoadContent = function()
{
	this.OnEvent('LoadContentBefore');
	var sContent = this.GetContent();
	if(this.sFirstContent == null)
		this.sFirstContent = sContent;
	switch(this.sEditorMode)
	{
		case 'code':
			this.SetCodeEditorContent(sContent);
			break;
		case 'split':
			this.SetCodeEditorContent(sContent)
			this.SetEditorContent(sContent)
			break;
		case 'html':
			this.SetEditorContent(sContent);
	}
	this.OnEvent('LoadContentAfter');
};

BXHTMLEditor.prototype.SaveContent = function()
{
	this.OnEvent('SaveContentBefore');
	switch(this.sEditorMode)
	{
		case 'code':
			this.SetContent(this.GetCodeEditorContent());
			break;
		case 'split':
			if(this.sEditorSplitMode == 'code')
				this.SetContent(this.GetCodeEditorContent());
			else
				this.SetContent(this.GetEditorContent(true, true));
			break;
		case 'html':
			this.SetContent(this.GetEditorContent(true, true));
	}
	this.OnEvent('SaveContentAfter');
};


BXHTMLEditor.prototype.SetEditorContent = function(sContent)
{
	var obj = this;
	var _this = this;
	this.arFlashParams = {}; // Create new array of flash fragments
	sContent = this.pParser.SystemParse(sContent);
	try{this.pEditorDocument.designMode='off';}catch(e){_alert('pMainObj.SetEditorContent: designMode=\'off\'');}
	this.OnEvent('SetEditorContentBefore', [sContent]);
	//Writing content
	this.pEditorDocument.open();
	this.pEditorDocument.write('<html><head></head><body>'+sContent+'</body></html>');
	this.pEditorDocument.close();
	//Handling DOM
	this.pParser.DOMHandle();
	if(this.bTableBorder)
	{
		this.bTableBorder = false;
		this.ShowTableBorder(true);
	}
	if(BXIsIE())
	{
		this.pEditorDocument.body.contentEditable = true;
		addAdvEvent(this.pEditorDocument, 'focus', window['onClick_'+this.name]);
	}
	else
	{
		this.pEditorWindow.__bxedname = this.name;
		this.pEditorWindow.addEventListener("focus", this.FFOnFocus, false);
	}

	this.oStyles.SetToDocument(this.pEditorDocument);
	this.pEditorDocument.className = 'pEditorDocument';
	this.pEditorDocument.pMainObj = this;
	pBXEventDispatcher.SetEvents(this.pEditorDocument);
	addAdvEvent(this.pEditorDocument, 'contextmenu', window['onContextMenu_'+this.name]);
	addAdvEvent(this.pEditorDocument, 'click', window['onClick_'+this.name]);
	addAdvEvent(this.pEditorDocument, 'mouseup', window['onMouseUp_'+this.name]);
	addAdvEvent(this.pEditorDocument, 'dragdrop', window['onDragDrop_'+this.name]);
	addAdvEvent(this.pEditorDocument, 'keypress', window['onKeyPress_'+this.name]);
	addAdvEvent(this.pDocument, "keypress", PreventEnterClosing);
	if(BXIsIE())
		addAdvEvent(this.pEditorDocument.body, 'paste', window['onPaste_'+this.name]);
	else
		addAdvEvent(this.pEditorDocument, 'keydown', window['onKeyDown_'+this.name]);
	addEvent(this.pEditorDocument, 'mouseup', function (e){_this.OnClick(e);});
	addEvent(this.pEditorDocument, 'keyup', function (e){_this.OnClick(e); _this.OnChange("keyup", "");});
	pBXEventDispatcher.OnEditorEvent("OnSetEditorContent", this);
	this.OnEvent('SetEditorContentAfter');
};

BXHTMLEditor.prototype.GetEditorContent = function()
{
	this.OnEvent('GetEditorContentBefore');

	var bBorders = this.bTableBorder;
	if(bBorders) this.ShowTableBorder(false);
	this.pParser.Parse();
	if(bBorders) this.ShowTableBorder(true);

	var sContent = this.pParser.GetHTML(true);
	sContent = this.pParser.ClearFromHBF(sContent);
	sContent = this.pParser.SystemUnParse(sContent);

	if (this.fullEditMode)
		sContent = this.pParser.AppendHBF(sContent, true);

	this.OnEvent('GetEditorContentAfter', [sContent]);
	return sContent;
};


BXHTMLEditor.prototype.SetCodeEditorContent = function(sContent)
{
	this.pSourceFrame.value = sContent;
};

BXHTMLEditor.prototype.GetCodeEditorContent = function()
{
	return this.PreparseHeaders(this.pSourceFrame.value);
};

BXHTMLEditor.prototype.PreparseHeaders = function(sContent)
{
	if (!this.fullEditMode)
		return sContent;
	return this.pParser.GetHBF(sContent, true);
};

BXHTMLEditor.prototype.SetView = function(sType)
{
	if (this.sEditorMode == sType)
		return;
	this.SaveContent();
	switch(sType)
	{
		case 'code':
			this.pSourceFrame.style.height = "99%";
			this.pEditorFrame.style.display = "none";
			this.pSourceFrame.style.display = "inline";
			if (IEplusDoctype)
			{
				this.pSourceFrame.rows = "50";
				this.pSourceDiv.style.height = "99%";
				this.pSourceDiv.style.display = "block";
			}
			this.SetCodeEditorContent(this.GetContent());
			break;
		case 'split':
			this.pEditorFrame.style.height = "50%";
			if (IEplusDoctype)
			{
				this.pSourceFrame.rows = "40";
				this.pSourceDiv.style.height = "49%";
				this.pSourceDiv.style.display = "block";
			}
			else
			{
				this.pSourceFrame.style.height = "49%";
			}
			this.pSourceFrame.style.display = "inline";
			this.pEditorFrame.style.display = "block";
			if(this.sEditorMode == 'code')
				this.SetEditorContent(this.GetContent());
			else if(this.sEditorMode == 'html')
				this.SetCodeEditorContent(this.GetContent());
			break;
		default:
			this.pEditorFrame.style.height = "100%";
			this.pSourceFrame.style.display = "none";
			this.pEditorFrame.style.display = "block";
			if (IEplusDoctype)
				this.pSourceDiv.style.display = "none";
			this.SetEditorContent(this.GetContent());
			sType = "html";
	}
	this.sEditorMode = sType;
	this.OnEvent("OnChangeView", [this.sEditorMode, this.sEditorSplitMode]);
};

BXHTMLEditor.prototype.PasteAsText = function(text)
{
	text = bxhtmlspecialchars(text);
	text = text.replace(/\r/g, '');
	text = text.replace(/\n/g, '<br/>');
	this.insertHTML(text);
};

BXHTMLEditor.prototype.CleanWordText = function(text, arParams)
{
	var removeFonts = arParams[0];
	var removeStyles = arParams[1];
	var removeIndents = arParams[2];

	text = text.replace(/<!--\[.*?\]-->/g, ""); //<!--[.....]-->	-	<!--[if gte mso 9]>...<![endif]-->
	text = text.replace(/<!\[.*?\]>/g, "");		//	<! [if !vml]>
	text = text.replace(/<\\?\?xml[^>]*>/gi, "");	//<xml...>, </xml...>

	text = text.replace(/<o:p>\s*<\/o:p>/g, "");
	text = text.replace(/<o:p>.*?<\/o:p>/g, "&nbsp;");

	text = text.replace(/<\/?[a-z1-9]+:[^>]*>/gi, "");	//<o:p...>, </o:p>
	text = text.replace(/<([a-z1-9]+[^>]*) class=([^ |>]*)(.*?>)/gi, "<$1$3");
	text = text.replace(/<([a-z1-9]+[^>]*) [a-z]+:[a-z]+=([^ |>]*)(.*?>)/gi, "<$1$3"); //	xmlns:v="urn:schemas-microsoft-com:vml"

	// Remove mso-xxx styles.
	text = text.replace(/\s*mso-[^:]+:[^;"]+;?/gi, "");

	// Remove margin styles.
	text = text.replace(/\s*margin: 0cm 0cm 0pt\s*;/gi, "");
	text = text.replace(/\s*margin: 0cm 0cm 0pt\s*"/gi, "\"");

	if (removeIndents)
	{
		text = text.replace(/\s*TEXT-INDENT: 0cm\s*;/gi, "");
		text = text.replace(/\s*TEXT-INDENT: 0cm\s*"/gi, "\"");
	}

	text = text.replace(/\s*TEXT-ALIGN: [^\s;]+;?"/gi, "\"");
	text = text.replace(/\s*PAGE-BREAK-BEFORE: [^\s;]+;?"/gi, "\"");
	text = text.replace(/\s*FONT-VARIANT: [^\s;]+;?"/gi, "\"");
	text = text.replace(/\s*tab-stops:[^;"]*;?/gi, "");
	text = text.replace(/\s*tab-stops:[^"]*/gi, "");

	// Remove FONTS
	if (removeFonts)
	{
		text = text.replace(/<FONT[^>]*>(.*?)<\/FONT>/gi, '$1');
		text = text.replace(/\s*face="[^"]*"/gi, "");
		text = text.replace(/\s*face=[^ >]*/gi, "");
		text = text.replace(/\s*FONT-FAMILY:[^;"]*;?/gi, "");
	}

	// Remove Class attributes
	text = text.replace(/<(\w[^>]*) class=([^ |>]*)([^>]*)/gi, "<$1$3");

	// Remove styles.
	if (removeStyles)
		text = text.replace(/<(\w[^>]*) style="([^\"]*)"([^>]*)/gi, "<$1$3");

	// Remove empty styles.
	text = text.replace(/\s*style="\s*"/gi, '');

	text = text.replace(/<SPAN\s*[^>]*>\s*&nbsp;\s*<\/SPAN>/gi, '&nbsp;');
	text = text.replace(/<SPAN\s*[^>]*><\/SPAN>/gi, '');

	// Remove Lang attributes
	text = text.replace(/<(\w[^>]*) lang=([^ |>]*)([^>]*)/gi, "<$1$3");

	// Remove empty tags
	text = text.replace(/<SPAN[^>]*>(.*?)<\/SPAN>/gi, '$1');
	text = text.replace(/<([^\s>]+)[^>]*>\s*<\/\1>/g, '');
	text = text.replace(/<([^\s>]+)[^>]*>\s*<\/\1>/g, '');
	text = text.replace(/<([^\s>]+)[^>]*>\s*<\/\1>/g, '');

	text = text.replace(/<(U|I|STRIKE)>&nbsp;<\/\1>/g, '&nbsp;');

	return text;
};


BXHTMLEditor.prototype.PasteWord = function(text, arParams)
{
	text = this.CleanWordText(text, arParams);
	this.insertHTML(text);
};


BXHTMLEditor.prototype.LoadTemplateParams = function(templateID)
{
	var sURL = get_xml_page_path + '?op=sitetemplateparams&lang='+BXLang+'&site='+BXSite+'&templateID='+templateID;
	var ob = this.GetData(sURL);
	this.SetTemplate(ob["ID"], ob, false);
};

BXHTMLEditor.prototype.SetTemplate = function (templateID, arTemplateParams, bReload)
{
	try{
	if(this.templateID && this.templateID == templateID || arTemplateParams === false)
		return;

	if(!arTemplateParams)
		return this.LoadTemplateParams(templateID);

	this.templateID = arTemplateParams["ID"];

	if(this.pTemplateListbox)
		this.pTemplateListbox.SelectByVal(this.templateID);

	this.arTemplateParams = arTemplateParams;

	if(this.pComponent1Taskbar)
		this.pComponent1Taskbar.FetchArray(true);

	if (bReload) // Reload contents
	{
		this.SaveContent();
		if (this.bDotNet) this.SetTemplate_ex();
		this.LoadContent();
	}

	// Change styles
	var template_path = BX_PERSONAL_ROOT + "/templates/" + this.arTemplateParams.ID;
	this.oStyles.Parse(this.arTemplateParams["STYLES"], template_path);

	// Set styles
	this.oStyles.SetToDocument(this.pEditorDocument);
	this.OnEvent("OnTemplateChanged");
	}catch(e){_alert('ERROR: BXHTMLEditor.prototype.SetTemplate');}
};


BXHTMLEditor.prototype.FindComponentByPath = function (path)
{
	if (!window['BXComponentsTaskbar'])
		return false;

	var v = window.arComp1Elements["COMPONENTS"];
	for(var i = 0; i < v.length; i++)
		if(v[i]["PATH"] && v[i]["PATH"] == path)
			return v[i];
	return false;
};

BXHTMLEditor.prototype.SetFocus = function ()
{
	if(!this.bEditSource)
	{
		try{
			if(this.pEditorWindow.focus)
				this.pEditorWindow.focus();
			else
				this.pEditorDocument.body.focus();

			//if(this.pEditorWindow.focus && !BXIsIE())
			//	return this.pEditorWindow.focus(); // For FF
			//if(this.pEditorDocument.body) // For IE
			//{
				//if (!this.input_for_ie_focus)
				//	this.input_for_ie_focus = this.pEditorDocument.createElement('INPUT');
				//this.pEditorDocument.body.appendChild(this.input_for_ie_focus);
				//this.input_for_ie_focus.focus();
				//this.pEditorDocument.body.removeChild(this.input_for_ie_focus);
			//}
		}catch(e){_alert("Error: BXHTMLEditor.prototype.SetFocus");}
	}
};

BXHTMLEditor.prototype.insertHTML = function(sValue)
{
	this.SetFocus();

	if(BXIsIE())
	{
		try
		{
			var oRng = this.pEditorDocument.selection.createRange();
			oRng.pasteHTML(sValue);
			oRng.collapse(false);
			oRng.select();
		}
		catch(e){}
	}
	else
	{
		try{
			this.pEditorWindow.document.execCommand('insertHTML', false, sValue);
		}catch(e){_alert("ERROR: BXHTMLEditor.prototype.insertHTML");};
	}

	this.OnChange("insertHTML", "");
};


BXHTMLEditor.prototype.OnContextMenu = function (e, pElement, bNotFrame, arParams)
{
	var obj = this, arFramePos;
	obj.OnEvent("OnSelectionChange");
	if(obj.pEditorWindow.event)
		e = obj.pEditorWindow.event;

	if(!e) e = window.event;
	if(e.pageX || e.pageY)
	{
		e.realX = e.pageX;
		e.realY = e.pageY;
		if (!bNotFrame)
		{
			e.realX -= obj.pEditorDocument.body.scrollLeft;
			e.realY -= obj.pEditorDocument.body.scrollTop;
		}
	}
	else if(e.clientX || e.clientY)
	{
		e.realX = e.clientX;
		e.realY = e.clientY;
		if (bNotFrame)
		{
			e.realX += document.body.scrollLeft;
			e.realY += document.body.scrollTop;
		}
	}

	if(!bNotFrame)
	{
		if (!(arFramePos = CACHE_DISPATCHER['pEditorFrame_'+this.name]))
			CACHE_DISPATCHER['pEditorFrame_'+this.name] = arFramePos = GetRealPos(obj.pEditorFrame);

		e.realX += arFramePos["left"];
		e.realY += arFramePos["top"];
	}
	oBXContextMenu.Show(2500, 0, {left : e.realX, top : e.realY}, pElement, arParams, this);

	return BXPreventDefault(e);
};

BXHTMLEditor.prototype.executeCommand = function(commandName, sValue)
{
	this.SetFocus();
	try{
		var res = this.pEditorWindow.document.execCommand(commandName, false, sValue);
	}catch(e){};
	this.SetFocus();
	this.OnEvent("OnSelectionChange");
	this.OnChange("executeCommand", commandName);
	return res;
};

BXHTMLEditor.prototype.queryCommand = function(commandName)
{
	var sValue = '';
	try{
		if(!this.pEditorDocument.queryCommandEnabled(commandName))
			return null;
	}catch(e){return null;}

	try{
		return this.pEditorDocument.queryCommandValue(commandName);
	}catch(e) {}

	return null;
};


BXHTMLEditor.prototype.queryCommandState = function(commandName)
{
	var sValue = '';
	try
	{
		if(!this.pEditorDocument.queryCommandEnabled(commandName))
			return 'DISABLED';
	}
	catch(e){return 'DISABLED';}

	try
	{
		return (this.pEditorDocument.queryCommandState(commandName)?'CHECKED':'ENABLED');
	}
	catch(e) {return 'ENABLED';}

	return 'DISABLED';
};


BXHTMLEditor.prototype.updateBody = function()
{
	this.extractBodyParams(this._body);
};

BXHTMLEditor.prototype.extractBodyParams = function(_body)
{
	var sParams = _body.replace(/<body(.*?)>/i, "$1");
	var arBodyParams_src = sParams.match(/\w+\s*=".*?"/ig);
	var arBodyParams = [];
	var _val;

	for (var i in arBodyParams_src)
	{
		if (parseInt(i).toString()=="NaN") continue;
		var arBodyParams_src = sParams.match(/(\w+)\s*=".*?"/ig);
		_val = arBodyParams_src[i].replace(/(\w+)\s*="(.*?)"/ig,"$2");
		arBodyParams[RegExp.$1] = _val;
	}
};

BXHTMLEditor.prototype.FFOnFocus = function(e)
{
	try{
		var pMainObj = GLOBAL_pMainObj[this.__bxedname];
		if (pMainObj.pEditorDocument.designMode == 'on')
			return;

		pMainObj.pEditorDocument.designMode = "on";
		pMainObj.pEditorDocument.execCommand("useCSS", false, true);
		pMainObj.pEditorDocument.execCommand("styleWithCSS", false, false); // new moz call
		this.document.execCommand("insertBrOnReturn", false, false); // new moz call
	}catch(e){/*_alert('Eror: pMainObj.FFOnFocus');*/}
};


BXHTMLEditor.prototype.onSubmit = function(e)
{
	this.isSubmited = true;
	oBXEditorUtils.BXRemoveAllChild(this.oPropertiesTaskbar.pCellProps);

	if (!this.sEditorMode)
		this.sEditorMode = 'html';

	this.OnEvent('OnSubmit');

	if(this.bShowed)
		this.SaveContent();
};


BXHTMLEditor.prototype.OnKeyDown = function (e)
{
	if (e.ctrlKey && !e.shiftKey && !e.altKey)
	{
		if (!BXIsIE())
		{
			switch (e.which)
			{
				case 66 :	// B
				case 98 :	// b
					//bold
					break;
				case 105 :	// i
				case 73 :	// I
					//italic
					break;
				case 117 :	// u
				case 85 :	// U
					//underline
					break;
				case 86 :	// V
				case 118 :	// v
					//this.OnPaste();
					//e.preventDefault();
					//e.stopPropagation();
					break;
			}
		}
	}
};

BXHTMLEditor.prototype.OnPaste = function (e)
{
	var clipboardHTML = this.GetClipboardHTML();
	var AutoDetectWordContent = true;
	if (AutoDetectWordContent)
	{
		var RE_MS_WORD = /<\w[^>]*(( class="?MsoNormal"?)|(="mso-))/gi;
		if (RE_MS_WORD.test(clipboardHTML))
		{
			if (confirm(BX_MESS.MaybeTextFromWord))
			{
				this.bNotFocus = true;
				this.pMainObj.OpenEditorDialog("pasteword", false, 450);
				e.returnValue = false;
				e.cancelBubble = true;
			}
			else
				return;
		}
	}
};


BXHTMLEditor.prototype.GetClipboardHTML = function()
{
	var oDiv = document.createElement('DIV');
	oDiv.style.visibility = 'hidden';
	oDiv.style.overflow = 'hidden';
	oDiv.style.position = 'absolute';
	oDiv.style.width = 1;
	oDiv.style.height = 1;

	document.body.appendChild(oDiv);
	oDiv.innerHTML = '';

	var oRange = document.body.createTextRange();
	oRange.moveToElementText(oDiv);
	oRange.execCommand("Paste");

	var sData = oDiv.innerHTML;
	oDiv.innerHTML = '';

	return sData;
};


BXHTMLEditor.prototype.OnKeyPress = function (e)
{
	var useBR = false;
	var useBR = true;
	this.bFirstClick = true;
	//Enter handling
	if(e.keyCode == 13)
	{
		return;
		if (useBR && BXIsIE())
		{
			try
			{
				if (e.shiftKey)
					this.insertHTML('<p>');
				else
					this.insertHTML('<br>');
			}
			catch (e){}
			finally
			{
				e.returnValue = false;
				e.cancelBubble = true;
			}
		}

		if (!BXIsIE())
		{
			if ((useBR && e.shiftKey) || (!useBR && !e.shiftKey))
			{
				try
				{
					//Remember cursor position
					var oSel = this.pEditorWindow.getSelection();
					var oRange = oSel.getRangeAt(0);
					var offset = oRange.endOffset;
					var oNode = oRange.endContainer;

					//If it's simple text
					if (oNode.nodeType == 3 && oNode.parentNode.nodeName == 'BODY')
					{
						oSel.removeAllRanges();
						oRange.selectNode(oNode);
						oRange.setStart(oNode,offset);
						var oP = this.pEditorDocument.createElement('p');

						//Wrap node with <P>
						oRange.surroundContents(oP);

						//Restore cursor
						oRange.selectNode(oP.firstChild);
						oSel.addRange(oRange);
						oSel.collapseToStart();
					}
					else
					{
						this.insertHTML("<p id='BX_garbage_node'><br _moz_editor_bogus_node='on'></p>");
						var BX_garbage_node = this.pEditorDocument.getElementById('BX_garbage_node');

						oP = BX_garbage_node.nextSibling;
						BX_garbage_node.parentNode.removeChild(BX_garbage_node);

						oRange.selectNodeContents(oP);
						var oSel_p = this.pEditorWindow.getSelection();
						oSel_p.removeAllRanges();
						oSel_p.addRange(oRange);
						oSel_p.collapseToStart();
					}
				}
				catch (e){}
				finally
				{
					e.preventDefault();
					e.stopPropagation();
				}
			}
		}
	}
	else if (e.keyCode == 27) //Esc handling
	{
		try
		{
			if (oBXContextMenu && oBXContextMenu.menu && oBXContextMenu.menu.IsVisible())
				oBXContextMenu.menu.PopupHide();
		}
		catch(e){}

	}
};

BXHTMLEditor.prototype.WrapNodeWith = function (node)
{
	if(node.nodeType == 1)
		alert('element:'+node.innerHTML);
	else
		alert('text:'+node.nodeValue);
};

BXHTMLEditor.prototype.RemoveElements = function (arParentElement, tagName, arAttributes, oRange)
{
	var arChildren;
	arChildren = arParentElement.children;
	if(arChildren)
	{
		for(var i=0; i<arChildren.length; i++)
		{
			var elChild = arChildren[i];

			this.RemoveElements(elChild, tagName, arAttributes);

			if(elChild.tagName.toLowerCase() != tagName.toLowerCase())
				continue;


			var bEqual = true;
			for(var attrName in arAttributes)
			{
				attrValue = arAttributes[attrName];
				switch(attrName.toLowerCase())
				{
					case 'style':
						var styleValue = attrValue.toLowerCase();
						var re = /([^:]+):[^;]+/g;
						var arr;
						while((arr = re.exec(styleValue)) != null)
						{
							var styleName = RegExp.$1;
							if(elChild.style.cssText.toLowerCase().indexOf(styleName.toLowerCase())==-1)
							{
								bEqual = false;
								break;
							}
						}
						break;
					case 'class' :
						if(elChild.getAttribute('className', 0) != attrValue)
							bEqual = false;
						break;
					default:
						if(elChild.getAttribute(attrNalue, 0) != attrValue)
							bEqual = false;
				}
			}

			if(bEqual)
			{
				elChild.insertAdjacentHTML('beforeBegin', elChild.innerHTML);
				elChild.parentElement.removeChild(elChild);
			}
		}
	}
};

BXHTMLEditor.prototype.WrapSelectionWith = function (tagName, arAttributes)
{
	this.SetFocus();
	var oRange, oSelection;

	if(this.pEditorDocument.selection)
	{
		var arB, pEl, arNodes, j;
		arB = this.pEditorDocument.getElementsByTagName("FONT");
		for(var i=arB.length-1; i>=0; i--)
		{
			if(arB[i].face)
			{
				arB[i].setAttribute("__bxtemp", arB[i].face);
				arB[i].removeAttribute('face');
			}
		}

		this.executeCommand("FontName", "bitrixtemp");

	 	arB = this.pEditorDocument.getElementsByTagName("FONT");
		for(i=arB.length-1; i>=0; i--)
		{
			if(arB[i].face && arB[i].face=='bitrixtemp')
			{
				pEl = this.pEditorDocument.createElement(tagName);
				for(var attr in arAttributes)
				{
					switch(attr.toLowerCase())
					{
						case 'style' :
							pEl.style.cssText = arAttributes[attr];
							break;
						case 'class':
							SAttr(pEl, 'className', arAttributes[attr]);
							break;
						default:
							pEl.setAttribute(attr, arAttributes[attr]);
					}
				}
				arNodes = arB[i].childNodes;
				while(arNodes.length>0)
					pEl.appendChild(arNodes[0]);
				arB[i].parentNode.insertBefore(pEl, arB[i]);
				arB[i].parentNode.removeChild(arB[i]);
			}
		}
		arB = this.pEditorDocument.getElementsByTagName('FONT');
		for(i=arB.length-1; i>=0; i--)
		{
			if(!arB[i].getAttribute("__bxtemp"))
				continue;
			arB[i].face = arB[i].getAttribute("__bxtemp");
			arB[i].removeAttribute('__bxtemp');
		}
	}
	else
	{
		var arB, pEl, arNodes, j, sBoldTag = 'B';
		arB = this.pEditorDocument.getElementsByTagName(sBoldTag);
		for(var i=arB.length-1; i>=0; i--)
		{
			pEl = this.pEditorDocument.createElement("FONT");
			pEl.setAttribute("__bxtemp", "yes");
			arNodes = arB[i].childNodes;
			while(arNodes.length>0)
				pEl.appendChild(arNodes[0]);

			arB[i].parentNode.insertBefore(pEl, arB[i]);
			arB[i].parentNode.removeChild(arB[i]);
		}

		try{this.pEditorDocument.execCommand("styleWithCSS", false, false);}catch(e){_alert('Error: styleWithCSS');}
		this.executeCommand("Bold", true);
		try{this.pEditorDocument.execCommand("styleWithCSS", false, true);}catch(e){}

	 	arB = this.pEditorDocument.getElementsByTagName(sBoldTag);
		for(i=arB.length-1; i>=0; i--)
		{
			pEl = this.pEditorDocument.createElement(tagName);
			for(var attr in arAttributes)
			{
				switch(attr.toLowerCase())
				{
					case 'style' :
						pEl.style.cssText = arAttributes[attr];
						break;
					case 'class':
						SAttr(pEl, 'className', arAttributes[attr]);
						break;
					default:
						pEl.setAttribute(attr, arAttributes[attr]);
				}
			}
			arNodes = arB[i].childNodes;
			while(arNodes.length>0)
				pEl.appendChild(arNodes[0]);
			arB[i].parentNode.insertBefore(pEl, arB[i]);
			arB[i].parentNode.removeChild(arB[i]);
		}

		arB = this.pEditorDocument.getElementsByTagName('FONT');
		for(i=arB.length-1; i>=0; i--)
		{
			if(!arB[i].getAttribute("__bxtemp") || arB[i].getAttribute("__bxtemp", 2) != "yes")
				continue;

			pEl = this.pEditorDocument.createElement(sBoldTag);
			arNodes = arB[i].childNodes;
			while(arNodes.length>0)
				pEl.appendChild(arNodes[0]);
			arB[i].parentNode.insertBefore(pEl, arB[i]);
			arB[i].parentNode.removeChild(arB[i]);
		}
	}
};

BXHTMLEditor.prototype.GetToolbarSet = function ()
{
	return this.arToolbarSet;
};

BXHTMLEditor.prototype.GetTaskbarSet = function ()
{
	return this.arTaskbarSet;
};

BXHTMLEditor.prototype.SelectElement = function (pElement)
{
	if(this.pEditorWindow.getSelection)
	{
		var oSel = this.pEditorWindow.getSelection();
		oSel.selectAllChildren(pElement);
		oRange = oSel.getRangeAt(0);
	}
	else
	{
		this.pEditorDocument.selection.empty();
		var oRange = this.pEditorDocument.selection.createRange();
		oRange.moveToElementText(pElement);
		oRange.select();
	}
	return oRange;
};

BXHTMLEditor.prototype.GetSelectedNode = function ()
{
	var oSelection;
	if(this.pEditorDocument.selection)
	{
		oSelection = this.pEditorDocument.selection;
		var s = oSelection.createRange();
		if(oSelection.type=="Control")
			return s.commonParentElement();

		if(s.parentElement() && s.text==s.parentElement().innerText)
			return s.parentElement();
		return s;
	}
	else
	{
		oSelection = this.pEditorWindow.getSelection();
		if(!oSelection || oSelection.rangeCount!=1) return false;
		var oRange, container;
		oRange = oSelection.getRangeAt(0);
		container = oRange.startContainer;
		if(container.nodeType!=3)
		{
			if(container.nodeType==1 && container.childNodes.length<=0)
				return container;
			else if(oRange.endOffset - oRange.startOffset == container.childNodes.length)
				return container
			else if(oRange.endOffset - oRange.startOffset < 2)
				return container.childNodes[oRange.startOffset];
			else
				return false;
		}

		return container;
	}
};


BXHTMLEditor.prototype.GetSelectionObjects = function ()
{
	var oSelection;
	if(this.pEditorDocument.selection) // IE
	{
		oSelection = this.pEditorDocument.selection;
		var s = oSelection.createRange();

		if(oSelection.type=="Control")
			return s.commonParentElement();

		return s.parentElement();
	}
	else // FF
	{
		oSelection = this.pEditorWindow.getSelection();
		if(!oSelection)
			return false;
		var oRange;
		var container, temp;
		var res = [];
		for(var i = 0; i < oSelection.rangeCount; i++)
		{
			oRange = oSelection.getRangeAt(i);
			container = oRange.startContainer;
			if(container.nodeType != 3)
			{
				if(container.nodeType == 1 && container.childNodes.length <= 0)
					res[res.length] = container;
				else
					res[res.length] = container.childNodes[oRange.startOffset];
			}
			else
			{
				temp = oRange.commonAncestorContainer;
				while(temp && temp.nodeType == 3)
					temp = temp.parentNode;
				res[res.length] = temp;
			}
		}
		if(res.length > 1)
			return res;
		return res[0];
	}
};

BXHTMLEditor.prototype.OptimizeHTML = function (str)
{
	var arTags = ['b', 'em', 'font', 'h\\d', 'i', 'li', 'ol', 'p', 'small', 'span', 'strong', 'u', 'ul'];
	var replaceEmptyTags = function(str, b1, b2, b3, b4)
	{
		i--; // if we find empty tag and clear it - we decrease i and try to find the same tag again.
		return ' ';
	}
	var re, tagName;

	for (var i = 0, l = arTags.length; i < l; i++)
	{
		tagName = arTags[i];
		re = new RegExp('<'+tagName+'[^>]*?>\\s*?</'+tagName+'>',"ig");
		str = str.replace(re, replaceEmptyTags);
	}

	return str;
};


BXHTMLEditor.prototype.GetSelectionObject = function ()
{
	var res = this.GetSelectionObjects();
	if (this.bDotNet && res) res = this.OnEvent_ex('SelectionObjectCheck', [res]);
	if(res && res.constructor == Array)
	{
		var root = res[0];
		for(var i = 1; i < res.length; i++)
			root = BXFindParentElement(root, res[i]);

		return root;
	}
	return res;
};


function BXContextMenuOnclick(e)
{
	removeEvent(this.pMainObj.pEditorDocument, "click", BXContextMenuOnclick);
	oBXContextMenu.menu.PopupHide();
};


BXHTMLEditor.prototype.createEditorElement = function (sTagname, arParams, arStyles)
{
	return BXCreateElement(sTagname, arParams, arStyles, this.pEditorDocument);
};


BXHTMLEditor.prototype.CreateCustomElement = function(sTagName, arParams)
{
	var ob = new window[sTagName]();
	ar_CustomElementS.push(ob);
	ob.pMainObj = this;
	ob.pDocument = this.pDocument;
	ob.CreateElement = BXCreateElement;

	if(arParams)
	{
		var sParamName;
		for(sParamName in arParams)

			if(sParamName.toLowerCase() == '_oncreate')
				arParams[sParamName].apply(ob);
			else
				ob[sParamName] = arParams[sParamName];
	}
	if (ob._Create)
		ob._Create();
	return ob;
};


BXHTMLEditor.prototype.AddEventHandler = function (eventName, pEventHandler, pObject)
{
	if(!this.arEventHandlers[eventName])
		this.arEventHandlers[eventName] = [];
	this.arEventHandlers[eventName].push([pEventHandler, pObject]);
};

BXHTMLEditor.prototype.OnEvent = function (eventName, arParams)
{
	if(!this.arEventHandlers[eventName])
		return true;

	var res = true;
	for(var i=0; i < this.arEventHandlers[eventName].length; i++)
	{
		if(this.arEventHandlers[eventName][i][1])
		{
			if(!arParams)
				arParams = [];
			if(!this.arEventHandlers[eventName][i][0].apply(this.arEventHandlers[eventName][i][1], arParams))
				res = false;
		}
		else
		{
			if(!this.arEventHandlers[eventName][i][0](arParams))
				res = false;
		}
	}
	return res;
};

BXHTMLEditor.prototype.GetData = function (sUrl, arParams, pCallback)
{
	var pObj = this;
	if(!this.pXML)
	{
		this.pXML = new BXXML();
		this.pXML.pMainObj = this;
	}
	this.pXML.Load(sUrl, arParams);
	return this.pXML.Unserialize();
};

BXHTMLEditor.prototype.FullResize = function()
{
	var ws = jsUtils.GetWindowInnerSize();
	window.__fswindow.style.width = parseInt(ws.innerWidth) + "px";
	window.__fswindow.style.height = parseInt(ws.innerHeight) + "px";

	this.OnEvent('OnFullResize', []);
};

BXHTMLEditor.prototype.ClearPosCache = function ()
{
	CACHE_DISPATCHER['BXTaskbarset_VPos_' + this.name] = null;
	CACHE_DISPATCHER['BXTasktab_VPos_' + this.name] = null;
	CACHE_DISPATCHER['pEditorFrame_' + this.name] = null;
	CACHE_DISPATCHER['BXToolbarSet_pos_0'] = null;
	CACHE_DISPATCHER['BXToolbarSet_pos_1'] = null;
	CACHE_DISPATCHER['BXToolbarSet_pos_2'] = null;
	CACHE_DISPATCHER['BXToolbarSet_pos_3'] = null;
};

BXHTMLEditor.prototype.SetFullscreen = function (bFull)
{
	this.ClearPosCache();

	if(BXIsIE() && !this.pUnderFrame)
	{
		this.pUnderFrame = this.pDocument.createElement("IFRAME");
		this.pUnderFrame.setAttribute("src", "javascript:void(0)");
		this.pUnderFrame.frameBorder = "0";
		this.pUnderFrame.scrolling = "no";
		this.pUnderFrame.style.position = "absolute";
		this.pUnderFrame.unselectable = "on";
		this.pUnderFrame.style.display = "none";
		this.pUnderFrame.style.left = 0;
		this.pUnderFrame.style.top = 0;
		this.pDocument.body.appendChild(this.pUnderFrame);
	}

	var _this = this;
	var _FullResize = function() {_this.FullResize();};

	if(bFull)
	{
		var ws = jsUtils.GetWindowInnerSize();
		this.pWnd.style.position = "absolute";
		this.pWnd.style.top = "0px";
		this.pWnd.style.left = "0px";
		this.pDocument.body.style.overflow = "hidden";
		this.__oldSize = [this.pWnd.style.width, this.pWnd.style.height];

		var innerWidth = parseInt(ws.innerWidth);
		var innerHeight = parseInt(ws.innerHeight);

		if(BXIsIE())
		{
			this.pUnderFrame.style.display = "block";
			this.pUnderFrame.style.width = innerWidth;
			this.pUnderFrame.style.height = innerHeight;
			this.pUnderFrame.style.zIndex = 1000;
			var ss = jsUtils.GetWindowScrollSize();

			if (!IEplusDoctype)
				innerWidth += 18;
		}

		this.pWnd.style.zIndex = 2000;

		this.pWnd.style.width = innerWidth + "px";
		this.pWnd.style.height = innerHeight + "px";
		window.scrollTo(0, 0);

		window.__fswindow = this.pWnd;
		window._bxonresize = window.onresize || null;
		window.onresize = _FullResize;
	}
	else
	{
		if(BXIsIE())
			this.pUnderFrame.style.display = "none";

		this.pWnd.style.zIndex = 0;
		this.pWnd.style.position = "static";
		this.pDocument.body.style.overflow = "auto";
		if (!this.__oldSize)
			return;
		this.pWnd.style.width = this.__oldSize[0];
		this.pWnd.style.height = this.__oldSize[1];
		window.__fswindow = null;
		window.onresize = window._bxonresize || null;

		var pWnd = this.arTaskbarSet[3].pWnd;
		if (parseInt(pWnd.offsetHeight) >= 245)
		{
			pWnd.style.height = '245px';
			var pParWnd = this.arTaskbarSet[2].pParentWnd;
			var display = pParWnd.style.display;
			pParWnd.style.display = 'none';
			var _this = this;
			setTimeout(function() {pParWnd.style.display = display; _this.IEplusDoctypePatchSizes();}, 10);
		}
	}

	this.bFullscreen = bFull;
	if(this.pDocument.getElementById('fullscreen'))
		this.pDocument.getElementById('fullscreen').value = (bFull ? 'Y' : 'N');

	if (IEplusDoctype)
	{
		this.IEplusDoctypePatchSizes();
		// IE in standart mode needs to refresh DOM tree
		var pWnd = this.arTaskbarSet[3].arTaskbars[0].pWnd;
		pWnd.parentNode.appendChild(pWnd);
	}
	this.OnEvent('OnFullscreen', [bFull]);
};


BXHTMLEditor.prototype.ParseStyles = function ()
{
	this.arStyles = [];
};


BXHTMLEditor.prototype._FuncOnChange = function(obj, type, subtype)
{
	return function(){obj._OnChange(type, subtype);}
};

BXHTMLEditor.prototype.OnChange = function(type, subtype)
{
	if(this.bSkipChanges == true)
		return;

	if(!subtype)
		subtype = "";


	if(this.sOnChangeLastType != type || this.sOnChangeLastSubType != subtype)
	{
		this._OnChange(type, subtype);
		return;
	}

	if(this.pOnChangeTimer)
		clearTimeout(this.pOnChangeTimer);

	this.pOnChangeTimer = setTimeout(this._FuncOnChange(this, type, subtype), 1000);
};

BXHTMLEditor.prototype.IsChanged = function()
{
	if (!this.bFirstClick)
		return false;
	if(this.bNotSaved)
		return true;
	this.SaveContent();

	var firstContent = this.sFirstContent.trim();
	var curContent = this.GetContent().trim();
	if(firstContent.length == curContent.length && firstContent == curContent)
		return false;

	return true;
};


BXHTMLEditor.prototype._OnChange = function(type, subtype)
{
	this.sOnChangeLastType = type;
	this.sOnChangeLastSubType = subtype;

	var curContent = this.pEditorDocument.body.innerHTML;
	if(this.sLastContent.length==curContent.length && this.sLastContent == curContent)
		return;

	var xx = this.sLastContent;
	this.sLastContent = curContent;

	if(BXIsIE())
	{
		if(type!='Undo' && type!='Redo')
		{
			var lastUndoItem = this.arUndoBuffer.length;
			if(this.iUndoPos + 1 < lastUndoItem)
			{
				this.arUndoBuffer.length = this.iUndoPos + 1;
				lastUndoItem = this.iUndoPos + 1;
			}

			var pos = false;
			if(this.pEditorDocument.selection)
			{
				if(this.pEditorDocument.selection.type == 'Text')
					pos = this.pEditorDocument.selection.createRange().getBookmark();
			}

			this.arUndoBuffer.push({'type': type, 'subtype': subtype, 'content': curContent, 'pos': pos});
			var cnt = lastUndoItem - this.arConfig["undosize"];
			if(cnt>0)
			{
				this.arUndoBuffer.reverse();
				this.arUndoBuffer.length = this.arUndoBuffer.length - cnt;
				this.arUndoBuffer.reverse();
			}

			this.iUndoPos = this.arUndoBuffer.length - 1;
		}
		this.bNotSaved = (this.iUndoPos > 0);
	}
	else
	{
		if(this.iUndoPos < 0)
			this.iUndoPos = 0;
		else
			this.bNotSaved = true;
	}

	this.OnEvent("OnChange");
};

BXHTMLEditor.prototype.SetXXdo = function(type)
{
	var arUndoInfo = this.arUndoBuffer[this.iUndoPos];
	this.pEditorDocument.body.innerHTML = arUndoInfo['content'];
	this._OnChange(type);
	this.sLastContent = this.pEditorDocument.body.innerHTML;

	if(arUndoInfo['pos'])
	{
		if(this.pEditorDocument.selection)
		{
			var oRange = this.pEditorDocument.selection.createRange();
			oRange.moveToBookmark(arUndoInfo['pos']);
			oRange.select();
		}
	}
};

BXHTMLEditor.prototype.UndoStatus = function()
{
	return !(this.iUndoPos < 1 || this.arUndoBuffer.length <= 0);
};

BXHTMLEditor.prototype.Undo = function(pos)
{
	if(!this.UndoStatus())
		return;

	if(this.iUndoPos<pos)
		this.iUndoPos = 0;
	else
		this.iUndoPos = this.iUndoPos - pos;

	this.SetXXdo("Undo");
};

BXHTMLEditor.prototype.RedoStatus = function(pos)
{
	return !(this.iUndoPos + 1 >= this.arUndoBuffer.length || this.arUndoBuffer.length<=0);
};

BXHTMLEditor.prototype.Redo = function(pos)
{
	if(!this.RedoStatus())
		return;

	if(this.iUndoPos + pos >= this.arUndoBuffer.length)
		this.iUndoPos = this.arUndoBuffer.length-1;
	else
		this.iUndoPos = this.iUndoPos + pos;

	this.SetXXdo("Redo");
};

BXHTMLEditor.prototype.Clean = function(pos)
{
	this.pFrame = null;
	this.pWnd.pMainObj = null;
	this.pWnd = null;
	this.pForm = null;
	this.pComponent1Taskbar = null;
	this.pComponent2Taskbar = null;
	this.pLoaderFrame = null;
	this.pUnderFrame = null;

	for (var evname in this.arEventHandlers)
		this.arEventHandlers[evname] = null;
	this.arEventHandlers = null;

	var l = this.arToolbarSet.length;
	for (var i=0;i<l;i++)
		this.arToolbarSet[i] = null;

	var l = this.arTaskbarSet.length;
	for (var i=0;i<l;i++)
		this.arTaskbarSet[i] = null;

	this.lineNumCont = null;
	this.pSourceFrame.onkeydown = null;
	this.pSourceFrame = null;
	this.pEditorWindow = null;
	this.pEditorFrame = null;
	this.pEditorDocument.pMainObj = null;
	this.pEditorDocument = null;
	this.pDocument = null;
	this.pParser = null;

};

BXHTMLEditor.prototype.IEplusDoctypePatchSizes = function(value)
{
	if (!IEplusDoctype) return;
	var tbs2 = this.arTaskbarSet[2];
	var tbs3 = this.arTaskbarSet[3];
	if (isNaN(value))
	{
		if (tbs3.pWnd.style.display != 'none')
		{
			value = parseInt(tbs3.pWnd.style.height);
		}
		else
			value = 0;
	}
	else
		value = value - 35;

	if (value == 0) // padding-bottom when hide bottom taskbarset
		value = - 33;

	var edHeight = parseInt((this.bFullscreen) ? jsUtils.GetWindowInnerSize().innerHeight : this.arConfig["height"]);
	var centerRowH = edHeight - value - 114;

	if (isNaN(centerRowH))
		return;
	this.pFrame.rows[1].style.height = centerRowH + "px";
	//alert("edHeight = "+edHeight+"\n"+"centerRowH ="+centerRowH + "\n value  = " + value);
	if (tbs2.bShowing)
	{
		var tb, titleCell, dataCell;
		var l = tbs2.arTaskbars.length;

		var bH, tH = 25;
		if (l > 1)
		{
			bH = 25;
			tbs2.pWnd.style.height = (centerRowH - 45) + "px";
			tbs2.pBottomColumn.style.height = bH + "px";
		}
		else
			bH = 0;

		var dH = centerRowH - tH - bH - 6;
		for(var i = 0; i < l; i++)
		{
			tb = tbs2.arTaskbars[i].pWnd;
			tb.rows[0].cells[0].style.height = tH + "px"; // title cell
			tb.rows[1].cells[0].style.height = dH + "px"; // data cell
		}
	}


	var o, btt;
};

BXHTMLEditor.prototype.OnSpellCheck = function()
{
	this.oBXWaitWindow.Hide();
	var alreadyCheck = false;
	if (this.pMainObj.arConfig["spellCheckFirstClient"] == "Y")
		alreadyCheck = SpellCheck_MS(this.pMainObj.pEditorDocument.body);

	var usePspell = this.pMainObj.arConfig["usePspell"];
	//var useCustomSpell = this.pMainObj.arConfig["useCustomSpell"];
	var useCustomSpell = "N";

	if (!alreadyCheck)
	{
		if (usePspell == "Y" || useCustomSpell == "Y")
		{
			this.bNotFocus = true;
			this.pMainObj.OpenEditorDialog("spellcheck", false, 400, {BXLang: BXLang, usePspell: usePspell, useCustomSpell: useCustomSpell}, true);
		}
		else
		{
			alert(BX_MESS.SpellCheckNotInstalled);
		}
	}
};


function GarbageCollector()
{
	try{
		for (var el in ar_PROP_ELEMENTS)
		{
			for (var prop in ar_PROP_ELEMENTS[el].arElements)
				ar_PROP_ELEMENTS[el].arElements[prop] = null;

			try
			{
				ar_PROP_ELEMENTS[el].pCellProps = null;
				//ar_PROP_ELEMENTS[el].pCellProps = null;
				ar_PROP_ELEMENTS[el].pCellPath = null;
				ar_PROP_ELEMENTS[el].parentCell = null;
				ar_PROP_ELEMENTS[el].oOldSelected = null;
				ar_PROP_ELEMENTS[el].parentCell = null;
				ar_PROP_ELEMENTS[el].pTaskbarSet = null;
				ar_PROP_ELEMENTS[el].oOldPropertyPanelElement = null;
				ar_PROP_ELEMENTS[el].pWnd = null;
				ar_PROP_ELEMENTS[el].pDataCell = null;
				ar_PROP_ELEMENTS[el].pTitleRow = null;
				ar_PROP_ELEMENTS[el].pMainObj = null;
				if (ar_PROP_ELEMENTS[el].pHtmlElement)
					ar_PROP_ELEMENTS[el].pHtmlElement = null;
			}
			catch (e) {}
		}

		ar_PROP_ELEMENTS = null;

		//Clean pMainObj
		this.Clean();

		for (var el in ar_BXButtonS)
		{
			ar_BXButtonS[el].pWnd = null;
			ar_BXButtonS[el].pMainObj = null;
		}
		ar_BXButtonS = null;

		for (var el in ar_BXListS)
		{
			ar_BXListS[el].pWnd = null;
			ar_BXListS[el].pTitle = null;
			ar_BXListS[el].pTitleCell = null;
			ar_BXListS[el].pPopupNode = null;
			ar_BXListS[el].pDropDownList = null;
			ar_BXListS[el].pMainObj = null;
			ar_BXListS[el] = null;
		}
		ar_BXListS = null;

		for (var el in ar_BXStyleListS)
		{
			ar_BXStyleListS[el].pWnd = null;
			ar_BXStyleListS[el].pDropDownList = null;
			ar_BXStyleListS[el].pMainObj = null;
		}
		ar_BXStyleListS = null;

		for (var el in ar_BXColorPickerS)
		{
			ar_BXColorPickerS[el].pWnd = null;
			ar_BXColorPickerS[el].pIcon = null;
			if (ar_BXColorPickerS[el].pInput)
				ar_BXColorPickerS[el].pInput = null;
			ar_BXColorPickerS[el].pPopupNode = null;
		}
		ar_BXColorPickerS = null;

		for (var el in ar_BXTaskbarS)
		{
			ar_BXTaskbarS[el].pWnd = null;
			ar_BXTaskbarS[el].pMainObj = null;
			ar_BXTaskbarS[el].pDataCell = null;
			ar_BXTaskbarS[el].pTitleRow = null;
		}
		ar_BXTaskbarS = null;


		for (var el in ar_BXTaskbarSetS)
		{
			ar_BXTaskbarSetS[el].pWnd = null;
			ar_BXTaskbarSetS[el].pMainObj = null;
			if (ar_BXTaskbarSetS[el].pParent)
				ar_BXTaskbarSetS[el].pParent = null;

			ar_BXTaskbarSetS[el].pMainCell = null;
			ar_BXTaskbarSetS[el].pMoveColumn = null;

			ar_BXTaskbarSetS[el].pTaskbarsTable = null;
			ar_BXTaskbarSetS[el].pBottomColumn = null;
			ar_BXTaskbarSetS[el].pDataColumn = null;

			ar_BXTaskbarSetS[el].pMoveImg = null;
		}
		ar_BXTaskbarSetS = null;

		for (var el in ar_BXToolbarSetS)
		{
			ar_BXToolbarSetS[el].pWnd = null;
			ar_BXToolbarSetS[el].pMainObj = null;
			if (ar_BXToolbarSetS[el].pParent)
				ar_BXToolbarSetS[el].pParent = null;
			ar_BXToolbarSetS[el].pMoveImg = null;
			ar_BXToolbarSetS[el].pMoveColumn = null;
		}
		ar_BXToolbarSetS = null;

		for (var el in ar_BXToolbarS)
		{
			ar_BXToolbarS[el].pWnd.pObj = null;
			ar_BXToolbarS[el].pWnd = null;
			ar_BXToolbarS[el].pMainObj.pWnd = null;
			ar_BXToolbarS[el].pIconsTable.pObj = null;
			ar_BXToolbarS[el].pIconsTable = null;
			ar_BXToolbarS[el].pTitleRow = null;
			ar_BXToolbarS[el].pMainObj = null;
			ar_BXToolbarS[el].arButtons = null;
			ar_BXToolbarS[el].pToolbarSet = null;
		}
		ar_BXToolbarS = null;


		for (var el in ar_BXComponentsTaskbarS)
		{
			ar_BXComponentsTaskbarS[el].pDataCell = null;
			ar_BXComponentsTaskbarS[el].pCellList = null;
			ar_BXComponentsTaskbarS[el].pModulesList = null;
			ar_BXComponentsTaskbarS[el].pCellComp = null;
			ar_BXComponentsTaskbarS[el].pWnd = null;
			ar_BXComponentsTaskbarS[el]._tableBlock = null;
			ar_BXComponentsTaskbarS[el]._tableCompList = null;
			ar_BXComponentsTaskbarS[el].pCellComp = null;
			ar_BXComponentsTaskbarS[el].im_r = null;
			ar_BXComponentsTaskbarS[el].im_l = null;
		}
		ar_BXComponentsTaskbarS = null;


		for (var el in ar_BXPropertiesTaskbarS)
		{
			ar_BXPropertiesTaskbarS[el].pDataCell = null;
			ar_BXPropertiesTaskbarS[el].pCellPath = null;
			ar_BXPropertiesTaskbarS[el].pCellProps = null;
			ar_BXPropertiesTaskbarS[el].pMainObj = null;
		}
		ar_BXComponentsTaskbarS = null;

		for (var el in ar_CustomElementS)
		{
			ar_CustomElementS[el].pDocument = null;
			ar_CustomElementS[el].pMainObj = null;
			ar_CustomElementS[el].pFrame = null;
			ar_CustomElementS[el].pDiv = null;
		}
		ar_CustomElementS = null;


		for (var el in ar_BXPopupWindowS)
		{
			ar_BXPopupWindowS[el].pDocument = null;
			ar_BXPopupWindowS[el].pMainObj = null;
			ar_BXPopupWindowS[el].pFrame = null;
			ar_BXPopupWindowS[el].pDiv = null;
		}
		ar_BXPopupWindowS = null;

		//Cleaning events
		for (var i=ar_EVENTS.length-1; i>=0; i--)
		{
			var el = ar_EVENTS[i][0];
			var evname = ar_EVENTS[i][1];
			var func = ar_EVENTS[i][2];

			el["on"+evname] = null;
			el = null;
		}
		ar_EVENTS = null;

		var floatDiv = document.getElementById("BX_editor_dialog");
		if(floatDiv)
			floatDiv.parentNode.removeChild(floatDiv);

		pDocument = null;
		pMainObj = null;

		for (var el in GLOBAL_pMainObj)
			GLOBAL_pMainObj[el] = null;

		GLOBAL_pMainObj = null;
	}
	catch (e){}
}


function BXStyles(pMainObj)
{
	this.pMainObj = pMainObj;
	this.arStyles = [];
	this.sStyles = '';

	BXStyles.prototype.Parse = function (styles, template_path)
	{
		this.templatePath = template_path || '';
		this.sStyles = styles;
		this.arStyles = BXStyleParser.Parse(styles);
	};

	BXStyles.prototype.GetStyles = function (sFilter)
	{
		if(this.arStyles[sFilter.toUpperCase()])
			return this.arStyles[sFilter.toUpperCase()];
		return [];
	};

	BXStyles.prototype.SetToDocument = function(pDocument)
	{
		var pHeads = pDocument.getElementsByTagName("HEAD");
		if(pHeads.length != 1)
			return;

		if (this.templatePath && false)
		{
			var cur = pDocument.getElementsByTagName("LINK");
			for(var i = 0; i < cur.length; i++)
				cur[i].parentNode.removeChild(cur[i]);

			var xLink = pDocument.createElement("LINK");
			xLink.rel = "stylesheet";
			xLink.type="text/css";
			xLink.href= this.templatePath + "/styles.css";
			pHeads[0].appendChild(xLink);
			return;
		}
		var cur = pDocument.getElementsByTagName("STYLE");
		for(var i=0; i<cur.length; i++)
			cur[i].parentNode.removeChild(cur[i]);
		var xStyle = pDocument.createElement("STYLE");
		pHeads[0].appendChild(xStyle);
		var styles = this.sStyles;
		//this.templatePath = '/bitrix/templates/web20';
		//if (this.templatePath && styles.indexOf('url') != -1)
		//	styles = styles.replace(/url\(([^\/]{1}(?:\S|\s)*?)\)/gi, "url(" + this.templatePath + "/$1)");
		try{
		if(BXIsIE())
			pDocument.styleSheets[0].cssText = styles;
		else
			xStyle.appendChild(pDocument.createTextNode(styles));
		}catch(e){}
	};
}

function OnUnload(e)
{
	try{
		for (var ind in pBXEventDispatcher.arEditors)
			GarbageCollector.apply(pBXEventDispatcher.arEditors[ind]);
	} catch(e){}
}
window.onload = BXEditorLoad;
window.onunload = OnUnload;
