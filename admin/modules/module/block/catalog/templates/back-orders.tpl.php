<div class="chooser-panel">
	<ul>
		<!--<li class="current"><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">������</a></li>-->
		<li class="current">������</li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">������ ���������</a></li>
		
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">��������� ��������</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		{# /if #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">���������� �����������</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">
	
	<h4>������ �������</h4>
	
	<br>
	
	<div style="float: left; width: auto; margin-left: 10px;">
		
		<!--<div style="font-weight: bold; font-size: 13px; margin-bottom: 7px;">������</div>
				
		<div style="float: left; border: 1px solid #BBB5C4; padding: 20px;">										
			
			<form method="get" action=""> 
				
				<input type="hidden" name="sess_id" value="{# $smarty.get.sess_id #}" />
				<input type="hidden" name="section" value="{# $smarty.get.section #}" />
				<input type="hidden" name="type" value="{# $smarty.get.type #}" />
				
				<div class="left-auto">
					<span style="font-weight: normal; font-size: 10px;">����� �� ��������:</span>
					<br>
					<input type="text" name="filter_art" value="{# $smarty.get.filter_art #}" />
				</div>
				
				<div class="left-auto">
					<span style="font-weight: normal; font-size: 10px;">��������� �� ��������:</span>
					<br>
					<input type="text" name="c" value="{# $per_page #}" />
				</div>
				
				<div class="left-auto">
					<span style="font-weight: normal; font-size: 10px;">&nbsp;</span>
					<br>
					<input type="submit" value="��������" />
				</div>
				
			</form>
			
		</div>
		
		<br class="clear">
		<br><br><br>-->
		
		<div class="notation">
			<span>����� ������� <span class="bold">{# $total #}</span> �������</span>
		</div>
				
		<table class="data-table" cellpadding="5" cellspacing="0">
			<thead>
				<tr>
					<th class="align-left" style="width: 60px;">�����</th>
					<th class="align-left" style="width: 100px;">����</th>
					<th class="align-left" style="width: 200px;">�����������</th>
					<th class="align-left" style="width: 200px;">���������� ����</th>
					<th class="align-left" style="width: 100px;">�������</th>
					<th style="width: 80px;"></th>
				</tr>
			</thead>
			<tbody>
				{# foreach from=$Orders item=Item #}
				<tr class="order-row">
					<td style="width: 60px;">
						<span style="font-weight: bold;">�{# $Item.id_order #}</span>
					</td>
					<td style="width: 100px;">
						<span>{# $Item.datetime|date_format:"%d.%m.%Y %T" #}</span>
					</td>
					<td style="width: 200px;">
						<span>{# $Item.org #}</span>
					</td>
					<td style="width: 200px;">
						<span>{# $Item.name #}</span>
					</td>
					<td style="width: 100px;">
						<span>{# $Item.phone #}</span>
					</td>
					<td style="width: 80px;">
						<a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders&id={# $Item.id_order #}">���������</a>
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
			<a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}{# if isset($smarty.get.c) #}&c={# $smarty.get.c #}{# /if #}&p={# $smarty.section.pg.index #}">{# $smarty.section.pg.index #}</a>
			{# /if #}
			{# if not $smarty.section.pg.last #}|{# /if #}
		{# /section #}
		</div>
		{# /if #}
				
	</div>	
	
</div>