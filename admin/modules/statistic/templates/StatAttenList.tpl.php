<table class="table" cellspacing="1" cellpadding="">				
	<tr class="table-top-back">
		<td width="80%"><div>Дата</div></td>
		<td width="10%"><div>Хиты</div></td>
		<td width="10%"><div>Хосты</div></td>

	</tr>
	{# foreach from = $SInfo item = item key = id #}
	<tr>
        <td class="td"><div>{# $SInfo[$id].created|date_format:"%d/%m/%Y" #}</div></td>
        <td class="td"><div>{# $SInfo[$id].hits #}</div></td>
        <td class="td"><div>{# $SInfo[$id].hosts #}</div></td>
    </tr>
    {# /foreach #}
</table>