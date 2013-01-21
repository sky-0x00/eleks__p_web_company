<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Вернуться к списку информационных блоков</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">

<h4>Управление контентом блока {# $BlockTitle #}</h4>

	<div style="float: left; width: 100%; margin-left: 10px; border-right: 5px solid #EADEE0;">
		<div style="float: left; width: 100%;">
			<form method="post" enctype="multipart/form-data">
				
				<br>
				<div ><input type="hidden" value="{# $Block.id_block #}" id="module-blocks-type-id"></div>
				<br>
				
				<div class="span">Список элементов:</div>
				<div>
					<select style="width: 500px;" id="module-blocks-block-list">
						<option value="0"></option>
						{# foreach from=$ContentArray item=Item #}
						<option value="{#$Item.id_content#}">{#$Item.name#}</option>
						{# /foreach #}
					</select>
				</div>
				
				<br class="clear">
				<br class="clear">
				
				<div ><input type="hidden" value="" id="module-blocks-block-id"></div>
				<div class="span">Название:</div>
				<div><input class="form-text" style="width: 490px;" type="text" id="module-blocks-block-name" /></div>
				
				<div id="module-blocks-content-form">
					{# foreach from=$FieldsArray item=Item #}
					<br>
					<div class="span">{# $Item.title #}:</div>
					<div>
						{# if $Item.type == 'textarea' #}
						<div>
							<textarea class="form-textarea" style="width: 630px; height: 300px;" name="{# $Item.name #}"></textarea>
							<br class="clear">
							<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
							<label style="width: 100px;" class="form-label">редактор</label>
						</div>
						{# elseif $Item.type == 'text' #}
						<input class="form-text" style="width: 490px;" type="{# $Item.type #}" name="{# $Item.name #}" />
						{# elseif $Item.type == 'date' #}
						<input type="text" class="form-text" id="module-blocks-datepicker" name="{# $Item.name #}" />
						{# elseif $Item.type == 'select' #}
						<select class="form-select" name="{# $Item.name #}">
							<option value=""></option>
							<option value="ДТП">ДТП</option>
							<option value="В угоне">В угоне</option>
							<option value="Скрывшиеся с места ДТП">Скрывшиеся с места ДТП</option>
						</select>
						{# else #}
						<input type="{# $Item.type #}" name="{# $Item.name #}" />
						{# /if #}
					</div>
					{# /foreach #}
				</div>
				
				<br>
				<div class="span"><a class="under" id="module-blocks-emptyform">Очистить</a></div>
				
				<br class="clear">
				
				<div class="action-panel" style="margin-left:0px;">
					<button id="module-blocks-submit" type="button">Сохранить</button> 
					<button id="module-blocks-delete" type="button">Удалить</button>
					<button id="module-blocks-create" type="button">Добавить</button>
				</div>
			</form>
			
			{# if ($Block.photo) && ($Block.photo=='Y') #}
			
			<div id="module-blocks-image-form" style="width: 100%; float: left; height: auto; margin-bottom: 30px;" >
				<div class="span"><a class="under" id="module-blocks-image-new-toggle">Добавить новую фотографию</a></div>
					
				<div id="module-blocks-image-new-div" style="width: 100%; float: left; height: auto; margin-bottom: 30px; display: none;">
					<form method="post" enctype="multipart/form-data" name="module-blocks-image-new-form">	
						<br>
						<div class="left">Файл</div>
						<br class="clear">
						
						<div style="margin: 5px 0px;">
							<div><input type="hidden" value="0" id="module-blocks-image-new-block-id"></div>
							<div class="left" style="width: auto;"><input class="form-text" type="text" value="" id="module-blocks-image-new-file" style="width: 150px;"></div>
							<div class="left" style="width: auto;"><button type="button" id="module-blocks-image-button-browse">Обзор</button></div>
						</div>
						<br class="clear">
						
						<div style="margin-top: 5px;"><button type="button" id="module-blocks-image-button-add">Добавить</button></div>
					</form>
				</div>
				
				<br>
				<div class="span"><a class="under" id="module-blocks-image-list-toggle">Список фотографий:</a></div>
				<br>	
				
				<div id="module-blocks-image-list" style="display: none; width: 100%; float: left; height: auto;">
					<div class="module-blocks-photo-div" style="display: none; width: 406px; height: 390px;">
						
						<div class="left-auto" style="border: 2px solid #EADEE0; width: auto; height: auto; margin: 3px;"><img src="" alt="" style="width: auto; height: 300px;" /></div>
						<div><input type="hidden" name="id_image" value="0" /></div>
						<br class="clear">
						<p style="margin: 0 0 0 3px;">Ссылка на фотографию:</p>
						<div class="left-auto" style="width: 100%; margin: 3px;"><input type="text" name="link" value="" style="width: 400px;" /></div>
						<br class="clear">
						<!--<p style="margin: 0 0 0 3px;">Ссылка на миниатюру (160х120)</p>
						<div class="left-auto" style="width: 100%; margin: 3px;"><input type="text" name="thumb" value="" style="width: 400px;" /></div>
						<br class="clear">-->
						<div class="left-auto" style="width: 100%; margin: 3px;"><button type="button" class="module-blocks-image-button-delete">Удалить</button></div>
						
					</div>
				</div>
			</div>
			{# /if #}
		</div>
	</div>

</div>