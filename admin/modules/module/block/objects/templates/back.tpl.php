<div>
	<h5>{# $mod_info[0].name #}</h5>
	
	<script language="javascript" src="/admin/lib/jQuery/jquery.ajax.upload.js"></script>
	<script language="javascript" src="/admin/lib/jQuery/jquery.jqia.selects.js"></script>
	<script language="javascript" src="{# $mod_path #}/js/function.js"></script>
	
	<div class="chooser-panel">
		<ul>
			<li><a href="{# $SESS_URL #}section=module">Вернуться к списку модулей</a></li>
		</ul>
	</div>
	<br class="clear">

	<div class="block-content" style="height:auto;">

		<h4>Управление проектами</h4>

		<div style="float: left; width: 100%; margin-left: 10px;">
			<div style="float: left; width: 100%;">
				
				<br>					
				<div class="span">Список проектов:</div>
				<div>
					<select style="width: 500px;" id="object-list">
						{# foreach from=$Objects item=Item #}
						<option value="{# $Item.value #}">{# $Item.caption #}</option>
						{# /foreach #}
					</select>
				</div>
					
				<br>
				<div class="span"><a class="under" id="object-fields-empty">Очистить</a></div>
				<br>
					
				<input type="hidden" value="" id="object-id" />
				
				<div class="span">Тип проекта<span class="red">*</span>:</div>
				<div>
					<select style="width: 500px;" id="object-type">
						{# foreach from=$Types item=Item #}
						<option value="{# $Item.value #}">{# $Item.caption #}</option>
						{# /foreach #}
					</select>
				</div>
				<br>
								
				<div class="span">Название<span class="red">*</span>:</div>
				<div><input class="form-text" style="width: 490px;" type="text" id="object-name" /></div>
				<br>
				
				<div class="span">Место нахождения (город):</div>
				<div><input class="form-text" style="width: 490px;" type="text" id="object-town" /></div>
				<br>
				
				<div>
					<input class="form-checkbox" type="checkbox" id="object-primary" />
					<div class="span" style="display: inline-block;">ключевой</div>
				</div>
				<br>
				
				<div class="span" style="position: relative; z-index: 0;">Краткое описание<span class="red">*</span>:</div>
				<div>
					<textarea class="form-textarea" style="width: 630px; height: 200px;" id="object-short_description"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">редактор</label>
				</div>
				<br>
				
				<div class="span" style="position: relative; z-index: 0;">Описание<span class="red">*</span>:</div>
				<div>
					<textarea class="form-textarea" style="width: 630px; height: 300px;" id="object-description"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">редактор</label>
				</div>
				<br>
				
				<div class="span">Картинка объекта:</div>			
				<div id="object-img-div">
					<input type="hidden" value="" name="object_picture" id="object-picture" />
					<img style="width: 400px; height: auto;" id="object-image" src="" alt="" />
				</div>
				<br class="clear">
				
				<div>
					<form method="post" enctype="multipart/form-data">	
						<br>
						<div class="span">Файл:</div>
							
						<div>
							<div class="left-auto" style="width: auto;"><input class="form-text" type="text" value="" id="object-picture-new-file" style="width: 150px;"></div>
							<div class="left-auto" style="width: auto;"><button type="button" id="object-picture-button-browse">Обзор</button></div>
							<div class="left-auto"><button type="button" id="object-picture-button-add">Загрузить</button></div>
						</div>
						
						<br class="clear">
					</form>
				</div>
				<br>
								
				<br class="clear">
													
				<div class="action-panel" style="margin-left: 0px;">
					<button id="object-button-submit" type="button">Сохранить</button> 
					<button id="object-button-delete" type="button">Удалить</button>
					<button id="object-button-create" type="button">Добавить</button>
				</div>
				
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
					</div>
				</div>
				
				<br class="clear">
				
			</div>
		</div>

	</div>

</div>