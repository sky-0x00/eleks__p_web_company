{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}

<script language="javascript" src="/admin/modules/archive/js/function.js"></script>

<div id="outer">

	<div id="block-left">
		{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
	</div>

	<div id="block-center">
		<h3>Резервное копирование</h3>
		
		<div class="block-content" style="height: auto; width: 90%;">		
			<form action="" method="post">
				<input type="hidden" name="type" value="site" />
				<button id="archive-button-site-copy">Создать копию сайта</button>
			</form>
			<form action="" method="post">
				<input type="hidden" name="type" value="db" />
				<button id="archive-button-db-copy">Создать копию базы</button>
			</form>
		</div>
		
	</div>

</div>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}