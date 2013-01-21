<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>{# $DomainInfo[0].name #}</title>
<link rel="stylesheet" type="text/css" href="{# $PATH_SKIN_CSS #}style.css">
<link rel="stylesheet" type="text/css" href="{# $PATH_SKIN_CSS #}newstyle.css">
<link rel="stylesheet" type="text/css" href="{# $PATH_SKIN_CSS #}jquery.wysiwyg.css">
<link rel="stylesheet" type="text/css" href="{# $PATH_SKIN_CSS #}ui-lightness/jquery-ui-1.7.2.custom.css">

<script language="javascript" src="/admin/lib/jQuery/jquery.js"></script>
<script language="javascript" src="/admin/js/actions.js"></script>
<script></script>
<script language="javascript" src="/admin/lib/prototype/prototype.js"></script>
<script language="javascript" src="/admin/lib/jQuery/jquery.meerkat.js"></script>
<script language="javascript" src="/admin/lib/getHTML/getHTML.js"></script>
<script language="javascript" src="/admin/lib/jquery-ui/ui.core.js"></script>
<script language="javascript" src="/admin/lib/jquery-ui/ui.draggable.js"></script>
<script language="javascript" src="/admin/lib/jquery-ui/ui.resizable.js"></script>
<script language="javascript" src="/admin/lib/jQuery/jquery.wysiwyg.js"></script>
<script language="javascript" src="/admin/js/function.js"></script>
<script language="javascript" src="/admin/js/functions.js"></script>
<script>
	var sess 	= '{# $SESS_URL #}';
	var sess_id = '{# $smarty.get.sess_id #}';
</script>

<body>

<div id="meerkat" style="display: none;">
</div>

<div id="loading" class="loading-all">
	<div class="block">
		<div class="loading-image"><span><a class="under" onclick="CancelLoading();" title="Нажмите, если возникла ошибка при работе">обработка...</a></span></div>
	</div>	
</div>

<div id="fastredactor"></div>

<div class="header" id="header">
	<div class="header-auth">
		<div class="header-contact"><a href="">{# $UserInfo[0].name #}</a></div>	
		<div class="header-message"><div class="arrow-down"></div></div>
		<div class="header-exit" id="cms-logout">Выход</div>
	</div>
	<div class="header-info"></div>
	<div class="header-logo"></div>
</div><div><a class="under" id="header-hide">скрыть</a></div>

<br class="clear">

<div class="service-menu">
	{# if $smarty.get.section #}
	<a href="/admin/index.php?sess_id={# $smarty.get.sess_id #}">Главная страница</a>
	{# else #}
	<span>Главная страница</span>
	{# /if #}
	{# if $smarty.get.section=='module' #}
	{# if $smarty.get.type #}
	<a href="{# $SESS_URL #}section=module">Модули и данные</a>
	<span>{# $ModuleName #}</span>
	{# else #}
	<span>Модули и данные</span>
	{# /if #}
	{# elseif $smarty.get.section #}
	<span>{# $SectionName.title #}</span>	
	{# /if #}
</div>
