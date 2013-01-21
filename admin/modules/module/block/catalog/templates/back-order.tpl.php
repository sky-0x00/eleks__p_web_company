<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">������</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">������ ���������</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">��������� ��������</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		{# /if #}
                <li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">���������� �����������</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">
	
	<h4>����� �{# $smarty.get.id #}</h4>
	
	<br><br>	
	
	<div style="border: 1px 1px 0px 1px solid #BBB5C4; width: auto; margin-left: 10px;">
		
		<table class="data-table" cellpadding="5" cellspacing="0">
			<tbody>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">����/�����:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.datetime|date_format:"%d.%m.%Y %T" #}</div>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">�����������:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.org #}</div>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">��������� ����:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.name #}</div>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">�����/���. �����:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.town #}</div>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">�������:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.phone #}</div>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">����������� �����:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.email #}</div>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" align="right">
						<div class="span" style="font-weight: bold;">�����������:</div>
					</td>
					<td style="width: 463px;" align="left">
						<div class="span">{# $Order.comment #}</div>
					</td>
				</tr>
			</tbody>
		</table>
		
	</div>
	
	<br><br>
	
	<h5>����������� ������</h5>
	
	<br><br>
	
	<div style="float: left; width: auto; margin-left: 10px;">
										
		<table class="data-table" cellpadding="5" cellspacing="0">
			<thead>
				<tr>
					<th class="align-center" style="width: 100px;">����</th>
					<th class="align-left" style="width: 200px;">������������</th>
					<th class="align-left" style="width: 100px;">�������</th>
					<th class="align-left" style="width: 50px;">���</th>
					<th class="align-left" style="width: 100px;">����������</th>
				</tr>
			</thead>
			<tbody>
				{# foreach from=$Items item=Item #}
				<tr class="order-row">
					<td style="width: 100px; height: 40px;" valign="center" align="center">
						<img src="{# $Item.thumb #}" alt="" style="width: auto; height: 30px;" />
					</td>
					<td style="width: 200px;">
						<span>{# $Item.name #}</span>
					</td>
					<td style="width: 100px;">
						<span>{# $Item.art #}</span>
					</td>
					<td style="width: 50px;">
						<span>{# $Item.weight|string_format:"%.3f" #}</span>
					</td>
					<td style="width: 100px;">
						<span>{# $Item.amount #}</span>
					</td>
				</tr>
				{# /foreach #}
				<tr class="total-row">
					<td style="width: 100px; background: #F0EEED none repeat scroll 0 0;">&nbsp;</td>
					<td style="width: 200px; background: #F0EEED none repeat scroll 0 0;">&nbsp;</td>
					<td style="width: 100px; background: #F0EEED none repeat scroll 0 0;" align="right">
						<span style="font-size: 12px; font-weight: bold;">�����:</span>
					</td>
					<td style="width: 50px; background: #F0EEED none repeat scroll 0 0;">
						<span>{# $Order.weight|string_format:"%.3f" #}</span>
					</td>
					<td style="width: 100px; background: #F0EEED none repeat scroll 0 0;">
						<span>{# $Order.amount #}</span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<br><br>		
				
	</div>	
	
</div>
