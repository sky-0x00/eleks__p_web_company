<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=structure">���������</a></li>
		<li><a href="{#$SESS_URL#}section=structure&action=create">�������� ������</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto; width: 90%;">

<h4>������ ��������</h4>

<table class="table" cellspacing="0" cellpadding="0">				
	<tr class="thead">
		<td>�������</td>
		<td style="text-align:center;">��������</td>
	</tr>
	<tr>
		<td class="tr1">
			<a id="structure-node" class="tree_arrow_close" onclick="StructureWindow(1, 'structure-sub-nodes')">������� ��������</a>
		</td>
		<td class="tr1" style="width: 360px;">
			<div class="list-menu">
				<input type="hidden" name="id_page" value="1" />
				<a href="{# $SESS_URL #}section=structure&action=setting&id=1">���������</a>
				<a class="under">������������� �������</a>
			</div>
		</td>
	</tr>
</table>
	<div id="structure-sub-nodes" class="subitems"></div>
</div>
