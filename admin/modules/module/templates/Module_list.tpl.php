<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}">���������� �������</a></li>
		<li><a href="{#$SESS_URL#}">�������� ������ ������</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">

<h4>������ �������</h4>

	<table class="table" cellspacing="0" cellpadding="0">
		<tr class="thead">
			<td>��������</td>
			<td width="10%">��������</td>	
		</tr>
		{# foreach from = $ModuleArray item = Item key = id #}
		<tr class="tbody">
			<td><a href="{# $SESS_URL #}section=module&type={# $Item.id #}">{#$Item.name#}</a></td>
			<td>
			<div class="action-menu">
	    		<div class="icon">
	    				<div class="block">
	    					<div class="drop-menu">
	    					
	    					</div>
	    				</div>
	    		</div>
	    	</div>
			</td>
		</tr>
		{# /foreach #}
	</table>

</div>
<!--
<div class="block-description" style="margin-top: 30px;">
	<div>
		<span class="title">��������� ���������</span>
		<span class="text">29.06.2009 16:50</span>
		<span class="title">������</span>
		<span class="text">������� �.�.</span>
		<span class="title">������������</span>
		<span class="text">������� �.�.</span>
		<span class="title">�����������</span>
		<span class="text"></span>
	</div>
</div>
-->