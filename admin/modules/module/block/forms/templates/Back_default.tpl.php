<h4>������ ���-����</h4>

<div class="menu">
	<a href="">������ ���-����</a>
	<a href="">�������� ����� ���-�����</a>
</div>
	<br>
	<table class="table" cellspacing="1" cellpadding="0">				
		<tr class="table-top-back">
		<td width="5%"><div>ID</div></td>
		<td width="7%"><div>��������</div></td>
		<td><div>��������</div></td>
		<td width="10%"><div>����</div></td>
		<td width="10%"><div>����������</div></td>
		<td style="width: 200px;"><div>��������</div></td>
					
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
				<a href="{# $SESS_URL #}section=module&type={#$smarty.get.type#}&action=setting&id={#$Item.id#}">���������</a>
				<a href="">�������</a>
			</div></td>
	</tr>
	{# /foreach #}
	</table>