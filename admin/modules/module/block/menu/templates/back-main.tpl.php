<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=module">��������� � ������ �������</a></li>
		<li><a class="under" id="add-new-parent-cat">�������� ����� ���������</a></li>
	</ul>
</div>
<br class="clear">

<div id="catalog-new-parent-div" style="width: 100%; height: auto; margin-bottom: 30px; padding-left: 15px; display: none;">
	<input type="hidden" value="{# $smarty.get.type #}" id="module-type" />
	<div class="span">�������� ����� ���������</div>
	<div class="left-auto"><input type="text" class="form-text" value="" name="cat_name"></div>
	<div class="left-auto"><button id="parent-cat-button-submit">��������</button></div>
	<div class="left-auto"><button id="parent-cat-button-cancel">��������</button></div>
	<br class="clear">
</div>

<div class="block-content" style="height: auto; width: 90%; padding-bottom: 50px;">

	<h4>������ �������� ��������� ����</h4>
	<br>
	
	<div style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0; clear: left; display: none;" class="cat-list-item">
		<input type="hidden" name="id_cat" value="0" />
		
		<div class="left" style="width: 90%; margin-right: 0;">
			<a class="cat-name" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&cat=" style="margin-left: 25px;"></a>
		</div>
				
		<div class="left" style="width: 10%; margin-right: 0;">
			<div class="action-menu" style="margin: 0;">
				<div class="icon" style="margin: 0;">
					<div class="block" style="display: none;">
						<div class="drop-menu">
							<span class="drop-menu-edit-cat">�������������</span>
							<span class="drop-menu-delete-cat">�������</span>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
	
	{# foreach from=$CatList item=Item #}
	<div style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0; clear: left;" class="cat-list-item">
		<input type="hidden" name="id_cat" value="{# $Item.value #}" />
		
		<div class="left" style="width: 90%; margin-right: 0;">
			<a class="cat-name" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&cat={# $Item.value #}" style="margin-left: 25px;">{# $Item.caption #}</a>
		</div>
				
		<div class="left" style="width: 10%; margin-right: 0;">
			<div class="action-menu" style="margin: 0;">
				<div class="icon" style="margin: 0;">
					<div class="block" style="display: none;">
						<div class="drop-menu">
							<span class="drop-menu-edit-cat">�������������</span>
							<span class="drop-menu-delete-cat">�������</span>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
	{# /foreach #}
	
	<br class="clear">
	<br><br>
	
	<div style="margin-left: 20px;">
		<form method="post" enctype="multipart/form-data" action="">
				
			<br>
			<div class="span">��������� �� �����:</div>
			<div>
				<input type="file" name="menu" style="width: 200px;" />
				<input type="submit" style="margin-left: 20px;" value="���������" />
			</div>
			<div style="font-size: 6;">{# $Message #}<div>
			<br>
		</form>
	</div>
	
</div>