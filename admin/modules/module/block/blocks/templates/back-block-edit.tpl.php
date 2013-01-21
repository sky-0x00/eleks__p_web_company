<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Вернуться к списку информационных блоков</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">

	<h4>Редактировать структуру информационного блока "<span id="module-blocks-type-head">{# $BlockType.title #}</span>"</h4>

	<div style="float: left; width: 100%; margin-left: 10px; border-right: 5px solid #EADEE0;">
		<div style="float: left; width: 100%;">
			<form method="post">
				
				<div ><input type="hidden" value="{# $smarty.get.block #}" id="module-blocks-type-id"></div>
	
				<br>
				<div class="span"><span style="font-weight: bold;">Имя блока:</span></div>
				<div><input type="text" class="form-text" value="{# $BlockType.name #}" id="module-blocks-type-name"></div>
				
				<br>
				<div class="span"><span style="font-weight: bold;">Название блока:</span></div>
				<div><input type="text" class="form-text" value="{# $BlockType.title #}" id="module-blocks-type-title"></div>
				
				<br>
				<div class="span">
					<span style="font-weight: bold;">Разрешить добавление фотографий:</span>
					<input type="checkbox" class="form-checkbox" id="module-blocks-type-photo" {# if $BlockType.photo == 'Y' #}checked{# /if #}>
				</div>
				
				<br>
				<div class="span"><a class="under" id="module-blocks-showtypefields">Список полей:</a></div>
				
				<br>
				<div id="module-blocks-type-fields-div">
					
					<div class="span"><a class="under" id="module-blocks-addnewfield">Добавить поле</a></div>
					<br>				
					
					<div style="margin: 10px 0px;">
						
						<div class="left" style="width: 170px;"><span>Тип поля</span></div>
						<div class="left"><span>Имя(англ.)</span></div>
						<div class="left"><span>Заголовок</span></div>
						<div class="left" style="width: auto;"><span>Пустое</span></div>
						
					</div>
					<br class="clear">
					
					<div class="module-blocks-field" style="display: none; margin: 10px 0px;">
						<div ><input type="hidden" name="id_field" value="0"></div>
						
						<div class="left" style="width: 170px;">
							<select name="id_input">
								{# foreach from=$InputTypes item=Item #}
								<option value="{#$Item.id#}" {# if $Item.id == $fields.id_input #} selected {# /if #}>{#$Item.name#}[{#$Item.type#}]</option>
								{# /foreach #}
							</select>
						</div>
						
						<div class="left"><input type="text" name="name" value=""></div>
						<div class="left"><input type="text" name="title" value=""></div>
						<div class="left" style="width: auto;"><input type="checkbox" name="empty"></div>
						
						<div class="left" style="width: auto;"><div class="module-blocks-fields-button-delete"></div></div>
						<div class="left" style="width: auto;"><div class="module-blocks-fields-button-save"></div></div>
					
						<br class="clear">
					</div>
					
					{# foreach from=$BlockFields item=fields #}
					<div class="module-blocks-field" style="margin: 10px 0px;">
						<div ><input type="hidden" name="id_field" value="{# $fields.id_field #}"></div>
						
						<div class="left" style="width: 170px;">
							<select name="id_input">
								{# foreach from=$InputTypes item=Item #}
								<option value="{#$Item.id#}" {# if $Item.id == $fields.id_type #} selected {# /if #}>{#$Item.name#}[{#$Item.type#}]</option>
								{# /foreach #}
							</select>
						</div>
						
						<div class="left"><input type="text" name="name" value="{#$fields.name#}"></div>
						<div class="left"><input type="text" name="title" value="{#$fields.title#}"></div>
						<div class="left" style="width: auto;"><input type="checkbox" name="empty" {#if $fields.empty == 'Y' #}checked{# /if #}></div>
						
						<div class="left" style="width: auto;"><div class="module-blocks-fields-button-delete"></div></div>
						<div class="left" style="width: auto;"><div class="module-blocks-fields-button-save"></div></div>
					
						<br class="clear">
					</div>
					{# /foreach #}
				</div>
				
				<br class="clear">
				<br class="clear">
				
				<div class="action-panel" style="margin-left:0px;">
					<button id="module-blocks-type-submit" type="button">Сохранить</button>
				</div>
				
			</form>
		</div>
	</div>

	
</div>