{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}

<script language="javascript" src="{#$m_path#}/js/structure.js"></script>

<div id="outer">

	<div id="block-left">
		{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
	</div>
	
	<div id="block-center">
		<h3>Модули</h3>
		{# if !$smarty.get.type #} {# include file = "$root/admin/modules/module/templates/$Template.tpl.php" #} {# else #} {# $Template #} {# /if #}

	</div>

</div>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}