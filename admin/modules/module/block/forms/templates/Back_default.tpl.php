<h4>Список веб-форм</h4>

<div class="menu">
	<a href="">Список веб-форм</a>
	<a href="">Добавить новую веб-форму</a>
</div>
	<br>
	<table class="table" cellspacing="1" cellpadding="0">				
		<tr class="table-top-back">
		<td width="5%"><div>ID</div></td>
		<td width="7%"><div>Активный</div></td>
		<td><div>Название</div></td>
		<td width="10%"><div>Поля</div></td>
		<td width="10%"><div>Результаты</div></td>
		<td style="width: 200px;"><div>Действия</div></td>
					
	</tr>
	{# foreach from=$FormsList item=Item #}	
	<tr>	
		<td class="td"><div>{# $Item.id #}</div></td>
		<td class="td"><div>{# $Item.active #}</div></td>
		<td class="td"><div>{# $Item.name #}</div></td>
		<td class="td"><div><a href="{# $SESS_URL #}section=module&type={#$smarty.get.type#}&acion=setting&id={#$Item.id#}"">{# $Item.fields #}</a></div></td>
		<td class="td"><div></div></td>
		<td class="td">
			<div class="stat-menu">
				<a href="{# $SESS_URL #}section=module&type={#$smarty.get.type#}&action=setting&id={#$Item.id#}">Настройки</a>
				<a href="">Удалить</a>
			</div></td>
	</tr>
	{# /foreach #}
	</table>