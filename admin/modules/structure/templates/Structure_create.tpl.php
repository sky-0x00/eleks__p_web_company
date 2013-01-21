<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=structure">Структура</a></li>
		<li><a href="{# $SESS_URL #}section=structure&action=create">Добавить раздел</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">
	<h4>Добавление раздела</h4>				

	<br>
	<div><input type="checkbox" class="form-checkbox" id="active" {# if $RecordsArray[0].active == 1 #} checked {# /if #}><label class="form-label">публикация раздела</label></div>
			
	<div class="span">Название:</div>
	<div><input type="text" class="form-text" value="{# $RecordsArray[0].name #}" id="name_"></div>
	
	<br>
	<div class="span">Ссылка:</div>
	<div><input type="text" class="form-text" value="{# $RecordsArray[0].url #}" id="url"></div>
	
	<br>
	<div class="span">Раздел:</div>
	<div class="input-drop" id="input-structure">
	<input type="text" id="input-text-result-s">
	</div>
	<input type="hidden" id="parentid" value="">
	<div class="input-drop-result" id="input-drop-result-s"></div>
	
	
	<br>
	<div class="span">Макет:</div>
	<div class="input-drop" id="input-drop">
	<input type="text" id="input-text-result-t">
	</div>
	<input type="hidden" id="template_id">
	<div class="input-drop-result" id="input-drop-result-t"></div>

</div>

<br class="clear"><br>

<div class="block-content">

	<h5><a class="under" id="action-module-list">Модули и данные</a></h5>

	<div id="module-list">
		{# foreach from=$ModuleArray item=Item key=id #}
			<div>
				<input type="checkbox" class="form-checkbox" id="module_{#$id#}" value="{#$Item.id#}"><label class="form-label">{# $Item.name #}</label>
			</div>
		{# /foreach #}
		<input type="hidden" id="module-count" value="{# $id #}">
	</div>
</div>	

<br class="clear"><br>

<div class="block-content">											
	<h5>Дополнительные настройки</h5>
	
	<br>
	<div class="span">Приоритет:</div>
	<div><input type="text" class="form-text" value="{# $RecordsArray[0].priority #}" id="priority"></div>			
	
	<br>
	<div><input type="checkbox" class="form-checkbox" id="title_upply"><label class="form-label">применить ко всем</label></div>
	
	<div class="span">Заголовок:</div>
	<div>
	<input type="text" class="form-text" value="{# $RecordsArray[0].title #}" id="title">
	</div>			
	
	<br>
	<div class="span">Описание:</div>
	<div><textarea id="description" class="form-text">{# $RecordsArray[0].description #}</textarea></div>	
	<div id="description_resizer" class="text_editor" onMouseDown="textareaResizer(event);">&nbsp;</div>		
	
	<br>
	<div class="span">Ключевые слова:</div>
	<div><textarea id="keywords" class="form-text">{# $RecordsArray[0].keywords #}</textarea></div>			

	<br>
	<div><input type="checkbox" class="checkbox" id="type_id" {# if $RecordsArray[0].type_id == 1 #} checked {# /if #}> <label class="x-form-label">Использовать параметры</label></div>
</div>

<br class="clear">

<div class="action-panel">
<button id="action-structure-submit">Добавить</button> или <a href="{#$SESS_URL#}se" class="cancel">выйти без сохранения</a>
</div>
