<div class="chooser-panel">
	<ul>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">Заказы</a></li>-->
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Список элементов</a></li>		
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">Структура каталога</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">Добавить элемент</a></li>
		{# /if #}
		{# if $smarty.get.action=='add' #}
		<li class="current">Добавить элемент</li>
		{# /if #}
        <!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">Управление параметрами</a></li>-->
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">
	
	{# if $smarty.get.action=='edit' #}
	<h4>Редактирование элемента &laquo;<span>{# $Itm.name #}<span>&raquo;</h4>
	{# else #}
	<h4>Добавление нового элемента</h4>
	{# /if #}

	<div style="float: left; width: 100%; margin-left: 10px;">
		<div style="float: left; width: 100%;">
			
			<br>
			<br>
			
			{# if $smarty.get.action=='add' #}
			<div class="span" style="font-weight: bold;">Категория:</div>
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
			<div class="span" style="font-weight: bold;">Наименование<span class="red">*</span>:</div>
			<div><input class="form-text" style="width: 490px;" type="text" id="item-name" value="{# $Itm.name #}" /></div>
			<br>
							
			<br>
			<div class="span">					
				<input type="checkbox" class="form-checkbox"  id="item-active" {# if $Itm.active>0 #}checked{# /if #} />
				<span style="font-weight: bold;">видимый</span>
			</div>
			<br>
			
			<br>
			<div class="span" style="font-weight: bold;">Описание:</div>
			<div>
				<textarea class="form-textarea" style="width: 630px; height: 300px;" id="item-description">{# $Itm.description #}</textarea>
				<br>
				<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
				<label style="width: 100px;" class="form-label">редактор</label>
			</div>
			<br>
			
			<div>
				<div class="span" style="font-weight: bold;">Изображение элемента</div>
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
					<div class="span-bold">Файл:</div>
								
					<div>
						<div class="left-auto" style="width: auto;">
							<input type="text" value="" id="item-photo-new-file" style="width: 150px;">
						</div>
						<div class="left-auto" style="width: auto;">
							<button id="item-photo-button-browse">Обзор</button>
						</div>
						<div class="left-auto">
							<button id="item-photo-button-add">Загрузить</button>
						</div>
					</div>
							
					<br class="clear">
				</form>
			</div>
			
			<br>
			
			{# if $smarty.get.action=='edit' #}
			<br><br><br><br>
			<div class="span" style="font-weight: bold; font-size: 15px;">Атрибуты:</div>
			
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
			<div class="span"><a class="under" id="item-fields-empty">Очистить</a></div>
				
			<br class="clear">
			
			<div class="action-panel" style="margin-left: 0px;">
				{# if $smarty.get.action=='edit' #}
				<button id="item-button-submit" type="button">Сохранить</button> 
				{# else #}
				<button id="item-button-create" type="button">Добавить</button>
				{# /if #}
			</div>
			
			{# if $smarty.get.action=='edit' #}
			<div style="width: 100%; float: left; height: auto; margin-bottom: 30px;" >
					
				<div>
					<form method="post" enctype="multipart/form-data">	
						<br>
						<div class="span">Добавить фотографию:</div>
								
						<div>
							<div class="left-auto" style="width: auto;"><input class="form-text" type="text" value="" id="object-photo-new-file" style="width: 150px;"></div>
							<div class="left-auto" style="width: auto;"><button type="button" id="object-photo-button-browse">Обзор</button></div>
							<div class="left-auto"><button type="button" id="object-photo-button-add">Загрузить</button></div>
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
						<div style="width: 100%; margin: 3px;"><button type="button" class="object-photo-button-delete">Удалить</button></div>
						
					</div>
					
					{# foreach from=$Photos item=Item #}
					<div class="object-photo-div" style="float: left; width: 170px; height: 220px; margin-right: 10px;">
							
						<div align="center" style="border: 2px solid #EADEE0; width: 160px; height: 120px; margin: 3px;">
							<img src="{# $Item.photo #}" alt="" style="width: 160px; height: 120px;" />
						</div>
						<div><input type="hidden" name="id_photo" value="{# $Item.id_photo #}" /></div>
						<div style="width: 100%; margin: 3px;"><button type="button" class="object-photo-button-delete">Удалить</button></div>
						
					</div>
					{# /foreach #}
					
				</div>
			</div>
			{# /if #}
				
			<br class="clear">
			
		</div>
	</div>

</div>