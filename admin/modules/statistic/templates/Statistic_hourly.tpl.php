<h4>������������ �� ������� �����</h4>

<table class="stat-filter-select">
	<tr>
		<td>�������� ������ � </td>
		<td>
			<INPUT type="text" id="period_1" size="8" name="period_1" value="{# $date_e #}" readonly>
		</td>
		<td>	<button name="img_from" id="img_from"><img src="/admin/images/ico/dayselect.gif"></button>
			<script type="text/javascript">Calendar.setup({inputField: "period_1", button: "img_from", ifFormat: "%d.%m.%Y"});</script>
		</td>
		<td>�� </td>
		<td>
			<INPUT type="text" id="period_2" size="8" name="period_2" value="{# $date_s #}" readonly> 
		</td>
		<td>
			<button name="img_to" id="img_to"><img src="/admin/images/ico/dayselect.gif"></button> 
			<script type="text/javascript">Calendar.setup({inputField: "period_2", button: "img_to", ifFormat: "%d.%m.%Y"});</script>
		</td>
		<td><button onclick="Traffic();">��������</button></td>
	</tr>
	<tr>
		<td colspan="7" >
			<div class="fast-filter">
				<span>������� �����: </span>
				<a href="{# $SESS_URL #}section=statistic&filter=day&action={# $smarty.get.action #}">�������</a>
				<a href="{# $SESS_URL #}section=statistic&filter=week&action={# $smarty.get.action #}">������</a>
				<a href="{# $SESS_URL #}section=statistic&filter=month&action={# $smarty.get.action #}">�����</a>
				<a href="{# $SESS_URL #}section=statistic&filter=quarter&action={# $smarty.get.action #}">�������</a>
				<a href="{# $SESS_URL #}section=statistic&filter=year&action={# $smarty.get.action #}">���</a>
			</div>
		</td>
	</tr>
</table>

<div id="stat-attendance">
<table class="table" cellspacing="0" cellpadding="">				
	<tr class="thead">
		<td width="5%"><div></div></td>
		<td width="10%"><div>�����</div></td>
		<td width="10%"><div>������</div></td>
		<td width="10%"><div>������</div></td>
		<td width="10%"><div>������� ���������</div></td>
	</tr>
	{# foreach from = $SInfo item = item key = id #}
	{# if $id % 2 #} {# assign var=style value="tr1" #} {# else #} {# assign var=style value="tr2" #} {# /if #}
	<tr>
        <td class="{# $style #}"><div>{# $id+1 #}.</div></td>
        <td class="{# $style #}"><div>{# $item.date #}:00</div></td>
        <td class="{# $style #}"><div>{# $item.hits #}</div></td>
        <td class="{# $style #}"><div></div></td>
        <td class="{# $style #}"><div></div></td>
    </tr> 
    {# /foreach #}
</table>