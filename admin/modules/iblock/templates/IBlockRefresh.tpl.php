<table class="table" cellspacing="1" cellpadding="0">				
	<tr class="table-top-back">
		<td><div>Название</div></td>
		<td class="40%"><div>Описание</div></td>
		<td style="width:320px;"><div>Действие</div></td>				
	</tr>					
	{# foreach from = $IBlockArray item = Item key = id #}
	<tr >
	    <td class="td"><div style="margin-left: 15px;">{# $Item.name #}</div></td>
	    <td class="td"><div style="margin-left: 15px;">{# $Item.description #}</div></td>
	    <td class="td">
	    	<div class="stat-menu">
	    		<a class="under" href="{# $SESS_URL #}section=iblock&action=edit&id={# $Item.id #}">настройки</a>
	    		<a class="under" onclick="">редактировать</a>
	    		<a class="under" onclick="IBlockDelete({# $Item.id #})">удалить</a>
	    	</div>
	    </td>
	</tr>
	{# /foreach #}						
</table>