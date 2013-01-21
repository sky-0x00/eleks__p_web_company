{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}

<script language="javascript" src="{#$m_path#}/js/users.js"></script>

<div id="outer">
	<div id="block-left">
		{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
	</div>
	
	<div id="block-center">
		<h3>”правление пользовател€ми</h3>
		{# include file = "$root/admin/modules/users/templates/$Template.tpl.php" #}	
	</div>
</div>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}