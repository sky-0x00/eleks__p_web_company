<div class="stat-filter">
	<div class="top">�������� ����������</div>
	
		<div class="string">
		<strong>������</strong> <INPUT type="text" id="period_1" size="8" name="period_1">
		<button class="button-date" name="img_from" id="img_from"></button>
		<script type="text/javascript">Calendar.setup({inputField: "period_1", button: "img_from", ifFormat: "%Y-%m-%d"});</script>
		</div>
		
		<div class="string">
		<strong>...</strong><INPUT type="text" id="period_2" size="8" name="period_2">
		<button class="button-date" name="img_to" id="img_to"></button>
		<script type="text/javascript">Calendar.setup({inputField: "period_2", button: "img_to", ifFormat: "%Y-%m-%d"});</script>
		</div>
		<div class="string"><button onclick="StatPages();">�����</button></div>
		<br class="clear">
		<div class="hr" style="width: 100%"></div>
		
		<div class="string"><a href="">�������</a></div>							
		<div class="string"><a href="">�����</a></div>
		<div class="string"><a href="">�� 7 ����</a></div>
		<div class="string"><a href="">�� 30 ����</a></div>		
		
		<br class="clear">
		<div class="hr" style="width: 100%"></div>
		<div class="string"><strong>�������:</strong></div>
		<div class="string"><a href="">������ ��� ������</a></div>
		<div class="string"><a href="">Excel</a></div>
</div>

<div id="stat-pages">
<table class="table" cellspacing="1" cellpadding="">				
<tr class="table-top-back">
		<td width="5%"><div>�</div></td>
		<td width="35%"><div>URL</div></td>
		<td width="25%"><div>��������</div></td>
		<td width="10%"><div>����</div></td>
		<td width="10%"><div>�����</div></td>
		<td width="10%"><div>%</div></td>

	</tr>
	{# foreach from = $SInfo item = item key = id #}
	<tr>
        <td class="td"><div>{# $id+1 #}</div></td>
        <td class="td"><div>{# $DomainInfo[0].url #}{# $SInfo[$id].request_uri #}</div></td>
        <td class="td"><div>{# $SInfo[$id].name #}</div></td>
        <td class="td"><div>{# $SInfo[$id].hits #}</div></td>
        <td class="td"><div>{# $SInfo[$id].hosts #}</div></td>
        <td class="td"><div></div></td>
  
    </tr>
    {# /foreach #}
</table>
</div>