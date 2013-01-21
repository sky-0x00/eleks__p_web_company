<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=template&action=create">�������� ������</a></li>
		<li><a class="under" id="template-group-create-link">�������� ������</a></li>
	</ul>
</div>
<br class="clear">

<div id="template-group-create-div" style="float: left; margin: 0 0 20px 20px; display: none;">
	<div class="left-auto"><input type="text" class="form-text" value="" id="template-group-name"></div>
	<div class="left-auto"><button id="template-group-button-create">��������</button></div>
</div>

<div class="block-content" style="height: auto; width: 90%;">

	<h4>�������</h4>
	<br>
	
	<div style="float: left; width: 100%;">
						
		<div class="left" style="width: 60%; margin-right: 0;"><span>��� �������</span></div>
		<div class="left" style="width: 30%; margin-right: 0;"><span>��� �����</span></div>
		<div class="left" style="width: 10%; margin-right: 0;"><span>��������</span></div>
						
		<br class="clear">
	</div>
	<br class="clear">
	
	<div class="my-tree" style="margin: 10px 0px 15px 0px;"></div>
	
	<div class="template-group-list-item" style="float: left; width: 100%; display: none;">
		<input type="hidden" name="id_group" value="0" />
		<div class="template-group-details" style="padding: 10px 0 10px 0;">
			<div class="left" style="width: 90%; margin-right: 0;">
				<div class="tree_arrow_close">
					<a class="under" style="font-size: 9pt; color: #333333; font-weight: bold;"></a>
				</div>
				<div class="template-group-rename-div" style="display: none;">
					<div class="left-auto"><input type="text" class="form-text" value="" class="template-group-name"></div>
					<div class="left-auto"><button class="template-group-button-rename">���������</button></div>
					<div class="left-auto"><button class="template-group-button-cancel">��������</button></div>
				</div>
			</div>
			<div class="left" style="width: 10%; margin-right: 0;">
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
			</div>
		</div>
	</div>
	
	{# foreach from=$GInfo item=Item key=Key #}
	<div class="template-group-list-item" style="float: left; width: 100%;">
	
		<input type="hidden" name="id_group" value="{# $Item.id #}" />
		<div class="template-group-details" style="padding: 10px 0 10px 0;">
			<div class="left" style="width: 90%; margin-right: 0;">
				<div class="tree_arrow_close">
					<a class="under" style="font-size: 9pt; color: #333333; font-weight: bold;">{# $Item.name #}</a>
				</div>
				<div class="template-group-rename-div" style="display: none;">
					<div class="left-auto"><input type="text" class="form-text" value="{# $Item.name #}" name="group_name"></div>
					<div class="left-auto"><button class="template-group-button-rename">���������</button></div>
					<div class="left-auto"><button class="template-group-button-cancel">��������</button></div>
				</div>
			</div>
			<div class="left" style="width: 10%; margin-right: 0;">
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
			</div>
		</div>
		
		<div class="group-template-list" style="float: left; width: 100%; height: auto; margin: 0;display: none;">
			{# foreach from = $Templates[$Key] item = Item_ key = id #}
			<div style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0;" class="module-template-list-item">
				<input type="hidden" name="id_template" value="{# $Item_.template_id #}" />
				
				<div class="left" style="width: 60%; margin-right: 0;">
					<span class="template-list-item-name" style="margin-left: 25px;">{# $Item_.name #}</span>
				</div>
				
				<div class="template-list-file-name" style="float: left; width: 30%; margin-right: 0;">
					<a class="under">{# $Item_.filename #}</a>
				</div>
				
				<div class="left" style="width: 10%; margin-right: 0;">
					<div class="action-menu" style="margin: 0;">
						<div class="icon" style="margin: 0;">
							<div class="block" style="display: none;">
								<div class="drop-menu">
									<span class="drop-menu-edit-template">�������������</span>
									<span class="drop-menu-delete-template">������� ������</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			{# /foreach #}
		</div>
	</div>
	{# /foreach #}
	
</div>

<!--<div class="block-description" style="margin-top: 30px;">
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
</div>-->