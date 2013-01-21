<div class="chooser-panel">
	<ul>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">������</a></li>-->
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">������ ���������</a></li>		
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">��������� ��������</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		{# /if #}
		{# if $smarty.get.action=='add' #}
		<li class="current">�������� �������</li>
		{# /if #}
        <!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">���������� �����������</a></li>-->
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">
	
	{# if $smarty.get.action=='edit' #}
	<h4>�������������� �������� &laquo;<span>{# $Itm.name #}<span>&raquo;</h4>
	{# else #}
	<h4>���������� ������ ��������</h4>
	{# /if #}

	<div style="float: left; width: 100%; margin-left: 10px;">
		<div style="float: left; width: 100%;">
			
			<br>
			<br>
			
			{# if $smarty.get.action=='add' #}
			<div class="span" style="font-weight: bold;">���������:</div>
			<div>
				<select style="width: 500px;" id="item-cat">
					{# foreach from=$CatList item=Item #}
					<option value="{# $Item.value #}">{# $Item.caption #}</option>
					{# /foreach #}
				</select>
			</div>
			<br>
			{# else #}
			<input type="hidden" id="item-cat" value="{# $Itm.id_cat #}" />
			<input type="hidden" id="item-id" value="{# $smarty.get.id #}" />
			{# /if #}
			
			<br>
			<div class="span" style="font-weight: bold;">������������<span class="red">*</span>:</div>
			<div><input class="form-text" style="width: 490px;" type="text" id="item-name" value="{# $Itm.name #}" /></div>
			<br>
							
			<br>
			<div class="span">					
				<input type="checkbox" class="form-checkbox"  id="item-active" {# if $Itm.active>0 #}checked{# /if #} />
				<span style="font-weight: bold;">�������</span>
			</div>
			<br>
			
			<br>
			<div class="span" style="font-weight: bold;">��������:</div>
			<div>
				<textarea class="form-textarea" style="width: 630px; height: 300px;" id="item-description">{# $Itm.description #}</textarea>
				<br>
				<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
				<label style="width: 100px;" class="form-label">��������</label>
			</div>
			<br>
			
			<div>
				<div class="span" style="font-weight: bold;">����������� ��������</div>
			</div>
			<br>
			
			<div id="item-img-div">
				<input type="hidden" value="" id="item-photo" />
				<img style="width: auto; height: 300px;" id="item-image" src="{# $Itm.image #}" alt="" />
			</div>
			
			<br>
					
			<div>
				<form method="post" enctype="multipart/form-data">	
					<br>
					<div class="span-bold">����:</div>
								
					<div>
						<div class="left-auto" style="width: auto;">
							<input type="text" value="" id="item-photo-new-file" style="width: 150px;">
						</div>
						<div class="left-auto" style="width: auto;">
							<button id="item-photo-button-browse">�����</button>
						</div>
						<div class="left-auto">
							<button id="item-photo-button-add">���������</button>
						</div>
					</div>
							
					<br class="clear">
				</form>
			</div>
			
			<br>
			
			{# if $smarty.get.action=='edit' #}
			<br><br><br><br>
			<div class="span" style="font-weight: bold; font-size: 15px;">��������:</div>
			
			<div id="item-properties">
				{# foreach from=$FieldsArray item=Item #}
				<br>
					
				<div>
					<div class="span" style="font-weight: bold;">{# $Item.title #}{# if $Item.empty==0 #}<span class="red">*</span>{# /if #}:</div>
					{# if $Item.type == 'textarea' #}
					<textarea class="field" style="width: 400px; height: 100px;" name="{# $Item.name #}">{# $Item.value #}</textarea>
					{# elseif $Item.type == 'text' #}
					<input class="field" style="width: 400px;" type="text" name="{# $Item.name #}" value="{# $Item.value #}" />
					{# elseif $Item.type == 'select' #}
					<select class="field" style="width: 405px;" name="{# $Item.name #}">
						{# foreach from=$Item.options item=item #}
						<option value="{# $item #}"{# if $Item.value == $item #} selected{# /if #}>{# $item #}</option>
						{# /foreach #}
					</select>
					{# else #}
					<input class="field" type="{# $Item.type #}" name="{# $Item.name #}" value="{# $Item.value #}" />
					{# /if #}			
				</div>
				
				{# /foreach #}
			</div>
			{# /if #}
			
			
			
			<br>
			<div class="span"><a class="under" id="item-fields-empty">��������</a></div>
				
			<br class="clear">
			
			<div class="action-panel" style="margin-left: 0px;">
				{# if $smarty.get.action=='edit' #}
				<button id="item-button-submit" type="button">���������</button> 
				{# else #}
				<button id="item-button-create" type="button">��������</button>
				{# /if #}
			</div>
			
			{# if $smarty.get.action=='edit' #}
			<div style="width: 100%; float: left; height: auto; margin-bottom: 30px;" >
					
				<div>
					<form method="post" enctype="multipart/form-data">	
						<br>
						<div class="span">�������� ����������:</div>
								
						<div>
							<div class="left-auto" style="width: auto;"><input class="form-text" type="text" value="" id="object-photo-new-file" style="width: 150px;"></div>
							<div class="left-auto" style="width: auto;"><button type="button" id="object-photo-button-browse">�����</button></div>
							<div class="left-auto"><button type="button" id="object-photo-button-add">���������</button></div>
						</div>
							
						<br class="clear">
					</form>
				</div>
				<br>
				
				<br>
					
				<div style="width: 100%; float: left; height: auto;">
						
					<div class="object-photo-div" style="float: left; display: none; width: 170px; height: 220px; margin-right: 10px;">
							
						<div align="center" style="border: 2px solid #EADEE0; width: 160px; height: 120px; margin: 3px;"><img src="" alt="" style="width: 160px; height: 120px;" /></div>
						<div><input type="hidden" name="id_photo" value="0" /></div>
						<div style="width: 100%; margin: 3px;"><button type="button" class="object-photo-button-delete">�������</button></div>
						
					</div>
					
					{# foreach from=$Photos item=Item #}
					<div class="object-photo-div" style="float: left; width: 170px; height: 220px; margin-right: 10px;">
							
						<div align="center" style="border: 2px solid #EADEE0; width: 160px; height: 120px; margin: 3px;">
							<img src="{# $Item.photo #}" alt="" style="width: 160px; height: 120px;" />
						</div>
						<div><input type="hidden" name="id_photo" value="{# $Item.id_photo #}" /></div>
						<div style="width: 100%; margin: 3px;"><button type="button" class="object-photo-button-delete">�������</button></div>
						
					</div>
					{# /foreach #}
					
				</div>
			</div>
			{# /if #}
				
			<br class="clear">
			
		</div>
	</div>

</div>