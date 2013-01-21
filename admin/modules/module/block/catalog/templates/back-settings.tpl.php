<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">Заказы</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Список элементов</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">Структура каталога</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">Добавить элемент</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">Добавить элемент</a></li>
		<li><a id="add-new-parent-cat" class="under">Добавить корневую категорию</a></li>
		{# /if #}
                <!--<li class="current"><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">Управление параметрами</a></li>-->
		<li class="current">Управление параметрами</li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">
	
	<h4>Настройки</h4>
	
	<div style="float: left; width: 100%; margin-left: 10px;">
		
		<div style="float: left; width: 100%;">
			
			<br>			
			<br>
			<div class="span" style="font-weight: bold;">Количество выводимых<br>элементов на странице:</div>
			<div><input class="form-text" style="width: 90px;" type="text" id="per-page" value="{# $Settings.per_page #}" /></div>
			<br>
									
			<div class="action-panel" style="margin-left: 0px;">
				<button id="settings-submit" type="button">Сохранить</button> 
			</div>			
			
		</div>
	</div>

</div>