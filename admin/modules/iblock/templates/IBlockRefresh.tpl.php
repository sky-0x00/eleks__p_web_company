<table class="table" cellspacing="1" cellpadding="0">				
	<tr class="table-top-back">
		<td><div>��������</div></td>
		<td class="40%"><div>��������</div></td>
		<td style="width:320px;"><div>��������</div></td>				
	</tr>					
	{# foreach from = $IBlockArray item = Item key = id #}
	<tr >
	    <td class="td"><div style="margin-left: 15px;">{# $Item.name #}</div></td>
	    <td class="td"><div style="margin-left: 15px;">{# $Item.description #}</div></td>
	    <td class="td">
	    	<div class="stat-menu">
	    		<a class="under" href="{# $SESS_URL #}section=iblock&action=edit&id={# $Item.id #}">���������</a>
	    		<a class="under" onclick="">�������������</a>
	    		<a class="under" onclick="IBlockDelete({# $Item.id #})">�������</a>
	    	</div>
	    </td>
	</tr>
	{# /foreach #}						
</table>