<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=iblock&action=create">�������� ����</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">

	<h4>�������������� �����</h4>

	<div id="IBlockTemplate">
	<table class="table" cellspacing="0" cellpadding="0">				
		<tr class="thead">
			<td><a class="under">���</a></td>
			<td width="40%">�����</td>
			<td width="10%">��������</td>				
		</tr>					
		{# foreach from = $iblock_array item = Item key = id #}
		<tr class="tbody">
		    <td><div style="margin-left: 25px;"><a href="{# $SESS_URL #}section=iblock&action=edit&id={# $Item.id #}">{# $Item.description #}</a></div></td>
		    <td>
				<input type="hidden" name="id_block" value="{# $Item.id #}" />
				<a class="under iblock-quick-edit">{# $Item.name #}</a>
			</td>
		    <td>
				<div class="action-menu" style="margin: 0;">
					<div class="icon" style="margin: 0;">
						<div class="block" style="display: none;">
							<div class="drop-menu">
								<span class="drop-menu-rename-group">�������������</span>
								<span class="drop-menu-delete-group">������� ������</span>
							</div>
						</div>
					</div>
				</div>			
			</td>
		</tr>
		{# /foreach #}						
	</table>
	</div>
</div>

<!-- <div class="block-description" style="margin-top: 30px;">
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
</div> -->