{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}

<script language="javascript" src="/admin/modules/filemanager/js/file-editor.js"></script>
<script language="javascript" src="/admin/modules/page_error/js/function.js"></script>

<div id="outer">

	<div id="block-left">
		{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
	</div>

	{# include file = "$root/admin/modules/filemanager/templates/redactor-window.tpl.php" #}

	<div id="block-center">
		<h3>Обработка ошибок</h3>
		{# include file = "$root/admin/modules/page_error/templates/$Template.tpl.php" #}
	</div>

</div>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}