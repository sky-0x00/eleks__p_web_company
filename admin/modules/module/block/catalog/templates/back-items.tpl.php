<div class="chooser-panel">
	<ul>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">Заказы</a></li>-->
		<!--<li class="current"><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Список элементов</a></li> -->
		<li class="current">Список элементов</li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">Структура каталога</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">Добавить элемент</a></li>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">Управление параметрами</a></li>-->
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">
	
	<h4>Список элементов</h4>
	
	<br>
	
	<div style="float: left; width: auto; margin-left: 10px;">
		
		<div style="font-weight: bold; font-size: 13px; margin-bottom: 7px;">Фильтр</div>
				
		<div style="float: left; border: 1px solid #BBB5C4; padding: 20px;">										
			
			<form method="get" action=""> 
				
				<input type="hidden" name="sess_id" value="{# $smarty.get.sess_id #}" />
				<input type="hidden" name="section" value="{# $smarty.get.section #}" />
				<input type="hidden" name="type" value="{# $smarty.get.type #}" />
				
				<div class="left-auto">
					<span style="font-weight: normal; font-size: 10px;">Поиск по названию:</span>
					<br>
					<input type="text" name="filter_name" value="{# $smarty.get.filter_name #}" />
				</div>
				
				<div class="left-auto">
					<span style="font-weight: normal; font-size: 10px;">Элементов на странице:</span>
					<br>
					<input type="text" name="c" value="{# $per_page #}" />
				</div>
				
				<div class="left-auto">
					<span style="font-weight: normal; font-size: 10px;">&nbsp;</span>
					<br>
					<input type="submit" value="Показать" />
				</div>
				
			</form>
			
		</div>
		
		<br class="clear">
		<br><br><br>
		
		<div class="notation">
			<span>Всего найдено <span class="bold">{# $total #}</span> записей</span>
		</div>
				
		<table class="data-table" cellpadding="5" cellspacing="0">
			<thead>
				<tr>
					<th class="align-center" style="width: 50px;">Фото</th>
					<th class="align-left" style="width: 400px;">Наименование</th>
					<th class="align-left" style="width: 200px;">Категория</th>
					<th>Операции</th>
				</tr>
			</thead>
			<tbody>
				{# foreach name=items from=$Items item=Item #}
				<tr class="user-row">
					<td style="width: 50px; height: 40px;" valign="center" align="center">
						<img src="{# $Item.thumb #}" alt="" style="width: auto; height: 30px;" />
					</td>
					<td style="width: 400px;">
						<span>{# $Item.name #}</span>
					</td>
					<td style="width: 200px;">
						<span>{# if $Item.id_cat != $Item.root #}{# $Item.root_name #} ({# $Item.cat_name #}){# else #}{# $Item.cat_name #}{# /if #}</span>
					</td>
					<td>
						<input type="hidden" name="id_item" value="{# $Item.id_item #}" />
						<div class="left" style="width: auto; margin: 0px;" title="Редактировать">
							<button class="picture-button-edit item-edit" style="margin-left: 10px;"></button>
						</div>
						<div class="left" style="width: auto; margin: 0px;" title="Удалить">
							<button class="picture-button-delete item-delete"></button>
						</div>
						
						<br class="clear">
					</td>
				</tr>
				{# /foreach #}
			</tbody>
		</table>
		
		<br><br>
		
		{# if $pages > 2 #}
		<div class="paginator">
		{# section name=pg start=1 step=1 loop=$pages #}
			{# if ($smarty.get.p==$smarty.section.pg.index) or (!isset($smarty.get.p) and $smarty.section.pg.first) #}
			<span style="font-size:10pt; font-family:Tahoma;">{# $smarty.section.pg.index #}</span>
			{# else #}
			<a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}{# if isset($smarty.get.filter_art) #}&filter_art={# $smarty.get.filter_art #}{# /if #}{# if isset($smarty.get.c) #}&c={# $smarty.get.c #}{# /if #}&p={# $smarty.section.pg.index #}">{# $smarty.section.pg.index #}</a>
			{# /if #}
			{# if not $smarty.section.pg.last #}|{# /if #}
		{# /section #}
		</div>
		{# /if #}
				
	</div>	
	
</div>