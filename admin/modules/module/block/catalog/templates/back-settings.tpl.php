<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">������</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">������ ���������</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">��������� ��������</a></li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		<li><a id="add-new-parent-cat" class="under">�������� �������� ���������</a></li>
		{# /if #}
                <!--<li class="current"><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">���������� �����������</a></li>-->
		<li class="current">���������� �����������</li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">
	
	<h4>���������</h4>
	
	<div style="float: left; width: 100%; margin-left: 10px;">
		
		<div style="float: left; width: 100%;">
			
			<br>			
			<br>
			<div class="span" style="font-weight: bold;">���������� ���������<br>��������� �� ��������:</div>
			<div><input class="form-text" style="width: 90px;" type="text" id="per-page" value="{# $Settings.per_page #}" /></div>
			<br>
									
			<div class="action-panel" style="margin-left: 0px;">
				<button id="settings-submit" type="button">���������</button> 
			</div>			
			
		</div>
	</div>

</div>