
function $_id(name) {

	return document.getElementById(name);
}

function ShowDiv (name) {

	if ($_id(name).style.display == 'block') $_id(name).style.display = 'none';
	else if ($_id(name).style.display == 'none') $_id(name).style.display = 'block';

}

function Tab(id, element, count) {

	for (i = 1; i <= count; i++) {

		if (i == element ) {
			$_id('tab'+i+'').style.display = 'block';
		} else {
			$_id('tab'+i+'').style.display = 'none';
		}
	}

}

function CancelLoading() {

	$_id('loading').style.display = 'none';
}


function ShowLayer(layer) {

	$_id(layer).style.display = 'block';
}

function HideLayer(layer){

	$_id(layer).style.display = 'none';
}

function ReadAsText (FieldId) {

	NewCode = new Ajax.Request('/admin/modules/structure/handler/ReadAsText.handler.php',
	{
		parameters:
		{
			id : $_id(FieldId)
		},
		onSuccess: function(req){
			document.getElementById("optionsDiv"+g).innerHTML = req.responseText;
			showOptions(g);
		},
		onFailure: function(req){},
		onLoading: function(req){}
	});
}

/*
function EventStructure(g) {

	NewCode = new Ajax.Request('/admin/modules/structure/handler/getStructureList.handler.php',
	{
		parameters:
		{

		},
		onSuccess: function(req){
			document.getElementById("optionsDiv"+g).innerHTML = req.responseText;
			showOptions(g);
		},
		onFailure: function(req){},
		onLoading: function(req){}
	});

}

function EventOption(g) {

	NewCode = new Ajax.Request('/admin/modules/structure/handler/getTemplateList.handler.php',
	{
		parameters:
		{

		},
		onSuccess: function(req){
			document.getElementById("optionsDiv"+g).innerHTML = req.responseText;
			showOptions(g);
		},
		onFailure: function(req){},
		onLoading: function(req){}
	});

}


function showOptions(g) {

	elem = document.getElementById("optionsDiv"+g);

	if(elem.className=="optionsDivInvisible") {elem.className = "optionsDivVisible";}

	else if(elem.className=="optionsDivVisible") {elem.className = "optionsDivInvisible";}

	elem.onmouseout = hideOptions;

}

function hideOptions(e) {

	if (!e) var e = window.event;

	var reltg = (e.relatedTarget) ? e.relatedTarget : e.toElement;

	if(((reltg.nodeName != 'A') && (reltg.nodeName != 'DIV')) || ((reltg.nodeName == 'A') && (reltg.className=="selectButton") && (reltg.nodeName != 'DIV'))) {this.className = "optionsDivInvisible";};

	e.cancelBubble = true;

	if (e.stopPropagation) e.stopPropagation();
}

function selectMe(selectFieldId,linkNo,selectNo) {

	selectField = document.getElementById(selectFieldId);

	for(var k = 0; k < selectField.options.length; k++) {

		if(k==linkNo) {selectField.options[k].selected = "selected";}

		else {selectField.options[k].selected = "";}
	}

	textVar = document.getElementById("mySelectText"+selectNo);

	var newText = document.createTextNode(selectField.options[linkNo].text);

	textVar.replaceChild(newText, textVar.childNodes[0]);
}
*/
/*AUTH FUNCTION*/

function doChallengeResponse() {

	if ((document.auth_form.auth_login.value == "") || (document.auth_form.auth_password.value == "")) {

		$("#ErrorMessage").html("{# $AUTH_EMPTY #}");

	} else {

		str = document.auth_form.auth_login.value + ":" + MD5(document.auth_form.auth_password.value) + ":" + document.auth_form.auth_challenge.value;

		document.auth_form_submit.auth_login.value = document.auth_form.auth_login.value;
		document.auth_form_submit.auth_response.value = MD5(str);
		document.auth_form.auth_login.value = "";
		document.auth_form.auth_password.value = "";

		document.auth_form_submit.submit();

	}

	return false;

}

/*
function logout() {

	NewCode = new Ajax.Request('/admin/modules/cms/handler/logout.handler.php',
	{
		parameters:
		{
			'sessid':sess
		},
		method:'post',
		onSuccess: function(req){location.href='/admin/'},
		onFailure: function(req){},
		onLoading: function(req){}
	});

}
*/
function Loading (status) {

	if (status  == 1) 
		$_id('loading').style.display = 'block'; 
	else 
		$_id('loading').style.display = 'none';

}

function Process (status) {

	if (status  == 1) 
		$_id('loading-block').style.display = 'block'; 
	else 
		$_id('loading-block').style.display = 'none';
}

/* WINDOW FUNCTION */

function OpenEditWindow(parentid)
{
	hdwsme.openwin('Редактирование контента',
	{
		'server_processor': '/admin/modules/filemanager/handler/getRedactor.handler.php',
		'server_parameters':
		{
			'htmlwindow': 'getContent.tpl.php',
			'htmlwindowprocessor': '/filemanager/handler/Redact.php',
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

function SaveEditWindow(parentid, hdwprefix)
{
	NewCode = new Ajax.Request('/admin/modules/filemanager/handler/getRedactor.handler.php',
	{
		parameters:
		{
			'htmlwindow':'getContent.tpl.php',
			'htmlwindowprocessor': '/filemanager/handler/Redact.php',
			'parentlayerid': parentid,
			'sessid': sess,
			'newcontent': document.getElementById(hdwprefix+'_form[content]').value
		},
		method:'post',
		onSuccess: function(req){ Loading(0); },
		onFailure: function(req){},
		onLoading: function(req){ Loading(1); }
	});

}




/*  FUNCTION STATISTIC */

function Traffic() {

	NewCode = new Ajax.Request('/admin/modules/statistic/handler/Traffic.handler.php',
	{
		parameters:
		{
			'htmlwindow': 'getContent.tpl.php',
			'htmlwindowprocessor': '/statistic/handler/StatAttendance.php',
			'sessid': sess,
			'period_1': $_id('period_1').value,
			'period_2': $_id('period_2').value

		},
		method:'post',
		onSuccess: function(req){ document.getElementById('stat-attendance').innerHTML = req.responseText; },
		onFailure: function(req){},
		onLoading: function(req){}
	});

}


/* FUNCTION STRUCTURE */

/*
function PageUpdate (parentid) {

	var module = '';

	if ($_id('module-count').value > 0) {

		for (i = 0; i <= $_id('module-count').value; i++) {

			if ($_id('module['+i+']').checked) {

				module += $_id('module['+i+']').value +'|';

			}
		}
	}

	NewCode = new Ajax.Request('/admin/modules/structure/handler/PageUpdate.handler.php',
	{
		parameters:
		{
			'parentid'		: parentid,
			'active'		: $_id('active').checked,
			'type_id'		: $_id('type_id').checked,
			'title_upply' 	: $_id('title_upply').checked,
			'name'			: $_id('name_').value,
			'priority'		: $_id('priority').value,
			'template_id' 	: $_id('template_id').value,
			'url'			: $_id('url').value,
			'title'			: $_id('title').value,
			'description' 	: $_id('description').value,
			'keywords' 		: $_id('keywords').value,
			'module'		: module
		},
		method:'post',
		onSuccess: function(req){ Loading(0) },
		onFailure: function(req){},
		onLoading: function(req){ Loading(1); }
	});

}

function PageCreate () {

	NewCode = new Ajax.Request('/admin/modules/structure/handler/PageCreate.handler.php',
	{
		parameters:
		{
			'parentid'	: $_id('parentid').value,
			'active'	: $_id('active').checked,
			'type_id'	: $_id('type_id').checked,
			'title_upply' : $_id('title_upply').checked,
			'name'		: $_id('name_').value,
			'priority'	: $_id('priority').value,
			'template_id'	: $_id('template_id').value,
			'url'		: $_id('url').value,
			'title'		: $_id('title').value,
			'description' : $_id('description').value,
			'keywords' 	: $_id('keywords').value
		},
		method:'post',
		onSuccess: function(req){},
		onFailure: function(req){},
		onLoading: function(req){}
	});

}
*/

function PageCount (parentid) {

	NewCode = new Ajax.Request('/admin/modules/structure/handler/PageCnt.handler.php',
	{
		parameters:
		{
			'parentid'	: parentid
		},
		method:'post',
		onSuccess: function(req){ return req.responseText},
		onFailure: function(req){},
		onLoading: function(req){}
	});


}

/* DOMAIN FUNCTION */
/*
function DomainUpdate() {

NewCode = new Ajax.Request('/admin/modules/domain/handler/DomainUpdate.handler.php',
{
parameters:
{
'active'	: $_id('active').checked,
'name'		: $_id('name_').value,
'url'		: $_id('url').value,
'403'		: $_id('select-403').value,
'404'		: $_id('select-404').value,
'charset'	: $_id('charset').value

},
method:'post',
onSuccess: function(req){Loading(0);},
onFailure: function(req){},
onLoading: function(req){Loading(1);}
});
}
*/

/* TEMPLATE FUNCTION */

function TemplateRefreshList(){

	NewCode = new Ajax.Request('/admin/modules/template/handler/TemplateRefreshList.handler.php',
	{
		parameters:
		{
		},
		method:'post',
		onSuccess: function(req){Loading(0); $_id('TemplateList').innerHTML = req.responseText;},
		onFailure: function(req){},
		onLoading: function(req){Loading(1);}
	});

}

function TemplateGroupCreate () {

	if ($_id('template-group').value != "") {

		NewCode = new Ajax.Request('/admin/modules/template/handler/TemplateGroupCreate.handler.php',
		{
			parameters:
			{
				'group' : $_id('template-group').value

			},
			method:'post',
			onSuccess: function(req){Loading(0); TemplateRefreshList();},
			onFailure: function(req){},
			onLoading: function(req){Loading(1);}
		});
	} else {

		alert('');
	}
}

function TemplateCreate () {

	NewCode = new Ajax.Request('/admin/modules/template/handler/TemplateCreate.handler.php',
	{
		parameters:
		{
			'group' : $_id('select-template-group').value,
			'name' 	: $_id('template-name').value,
			'file' 	: $_id('template-file').value

		},
		method:'post',
		onSuccess: function(req){Loading(0); TemplateRefreshList();},
		onFailure: function(req){},
		onLoading: function(req){Loading(1);}
	});


}

function TemplateDelete (id) {

	if (confirm ('Уверены?')) {

		NewCode = new Ajax.Request('/admin/modules/template/handler/TemplateDelete.handler.php',
		{
			parameters:
			{
				'id' : id

			},
			method:'post',
			onSuccess: function(req){Loading(0); TemplateRefreshList(); },
			onFailure: function(req){},
			onLoading: function(req){Loading(1);}
		});
	}

}

function PageErrorCreate () {


	NewCode = new Ajax.Request('/admin/modules/page_error/handler/PageErrorCreate.handler.php',
	{
		parameters:
		{
			'name' 	: $_id('template-name').value

		},
		method:'post',
		onSuccess: function(req){Loading(0);},
		onFailure: function(req){},
		onLoading: function(req){Loading(1);}
	});
}

function PageErrorDelete (id) {

	alert(id);
}

// USERS FUNCTION

function UsersCreate () {

	NewCode = new Ajax.Request('/admin/modules/users/handler/UsersCreate.handler.php',
	{
		parameters:
		{
			'active': $_id('active').checked,
			'name' 	: $_id('UserName').value,
			'login'	: $_id('UserLogin').value,
			'mail'	: $_id('UserMail').value,
			'pwd'	: $_id('UserPwd').value

		},
		method:'post',
		onSuccess: function(req){Loading(0);},
		onFailure: function(req){alert('');},
		onLoading: function(req){Loading(1);}
	});
}

function UsersCheckLogin () {

	NewCode = new Ajax.Request('/admin/modules/users/handler/UsersCheckLogin.handler.php',
	{
		parameters:
		{
			'login'	: $_id('UserLogin').value
		},
		method:'post',
		onSuccess: function(req){

			if (req.responseText == 1) $_id('UserLogin').style.border = '1px solid red'; else $_id('UserLogin').style.border = '';
		},
		onFailure: function(req){},
		onLoading: function(req){}
	});
}

function UsersCheckPwd () {

	var pwd 	= $_id ("UserPwd").value;
	var repwd 	= $_id ("UserRePwd").value;

	if (pwd != repwd) $_id("UserRePwd").style.border = '1px solid red'; else $_id("UserRePwd").style.border = '';

}

function UsersUpdate (id) {

	NewCode = new Ajax.Request('/admin/modules/users/handler/UsersUpdate.handler.php',
	{
		parameters:
		{
			'id'	: id,
			'active': $_id('active').checked,
			'name' 	: $_id('UserName').value,
			'login'	: $_id('UserLogin').value,
			'mail'	: $_id('UserMail').value,
			'pwd'	: $_id('UserPwd').value,
			'newpwd': $_id('NewPwd').checked
		},
		method:'post',
		onSuccess: function(req){Loading(0);},
		onFailure: function(req){},
		onLoading: function(req){Loading(1);}
	});

}

function UsersDelete (id) {

	if (confirm('Уверены?')) {

		alert(id);
	}
}

//////////////////////BLOCK FUNCTION//////////////////////////

function IBlockRefresh () {

	NewCode = new Ajax.Request('/admin/modules/iblock/handler/IBlockRefresh.handler.php',
	{
		parameters:
		{
		},
		method:'post',
		onSuccess: function(req){$_id("IBlockTemplate").innerHTML = req.responseText},
		onFailure: function(req){},
		onLoading: function(req){}
	});
}

function IBlockCreate () {

	NewCode = new Ajax.Request('/admin/modules/iblock/handler/IBlockCreate.handler.php',
	{
		parameters:
		{
			alias	: $_id('IBlockAlias').value,
			name	: $_id('IBlockName').value,
			desc	: $_id('IBlockDesc').value,
			template: $_id('IBlockTemplate').value,
			css		: $_id('IBlockCSS').value,
			use_content	: $_id('UseContent').checked,
			content	: $_id('IBlockContent').value
		},
		method:'post',
		onSuccess: function(req){Loading(0);},
		onFailure: function(req){alert('');},
		onLoading: function(req){Loading(1);}
	});
}

function IBlockUpdate (id) {

	NewCode = new Ajax.Request('/admin/modules/iblock/handler/IBlockUpdate.handler.php',
	{
		parameters:
		{
			id		: id,
			alias	: $_id('IBlockAlias').value,
			name	: $_id('IBlockName').value,
			desc	: $_id('IBlockDesc').value,
			template: $_id('IBlockTemplate').value,
			css		: $_id('IBlockCSS').value,
			use_content	: $_id('UseContent').checked,
			content	: $_id('IBlockContent').value
		},
		method:'post',
		onSuccess: function(req){Loading(0);},
		onFailure: function(req){alert('');},
		onLoading: function(req){Loading(1);}
	});
}

function IBlockDelete (id) {

	if (confirm('Уверены?')) {

		NewCode = new Ajax.Request('/admin/modules/iblock/handler/IBlockDelete.handler.php',
		{
			parameters:
			{
				id : id
			},
			method:'post',
			onSuccess: function(req){Loading(0);  IBlockRefresh();},
			onFailure: function(req){},
			onLoading: function(req){Loading(1);}
		});
	}
}

