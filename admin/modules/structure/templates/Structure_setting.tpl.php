<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=structure">Структура</a></li>
		<li><a href="{#$SESS_URL#}section=structure&action=create">Добавить раздел</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">

<h4>Редактирование раздела</h4>

	<br>
	<div><input type="checkbox" class="form-checkbox" id="active" {# if $RecordsArray[0].active == 1 #} checked {# /if #}><label class="form-label">публикация раздела</label></div>
			
	<div class="span">Название:</div>
	<div><input type="text" class="form-text" value="{# $RecordsArray[0].name #}" id="name_"></div>
	
	<br>
	<div class="span">Ссылка:</div>
	<div><input type="text" class="form-text" value="{# $RecordsArray[0].url #}" id="url"></div>
	
	<br>
	<div class="span">Макет:</div>
	
	<div class="input-drop" id="input-drop">
		<input type="text" id="input-text-result-t" value="{# $RecordsArray[0].template_name #}">
	</div>
	<input type="hidden" id="template_id" value="{# $RecordsArray[0].template_id #}">
	<div class="input-drop-result" id="input-drop-result-t"></div>	

	
</div>	

<div class="block-description">
	<div>
		<span class="title">Последнее изменение</span>
		<span class="text">29.06.2009 16:50</span>
		<span class="title">Редактировал</span>
		<span class="text">Мелехов Д.С.</span>
	</div>
</div>

<br class="clear"><br>


<div class="block-content">
	<h5><a class="under" id="action-module-list">Модули и данные</a></h5>
	<div id="module-list"> 
		{# foreach from=$ModuleArray item=Item key=id  #}
		{# assign var="checked" value="" #}
		{# foreach from=$ModuleID item=Rec #}
		{# if $Item.id == $Rec.module_id #} {# assign var="checked" value="checked" #} {# /if #}
		{# /foreach #}
		<div> 
			<input type="checkbox" class="form-checkbox" id="module_{#$id#}" value="{# $Item.id #}" {# $checked #}><label class="form-label">{# $Item.name #}</label>
		</div>
		{# /foreach #}
		<input type="hidden" id="module-count" value="{# $id+1 #}">
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
	<div><input type="checkbox" class="checkbox" id="type_id" {# if $RecordsArray[0].type_id == 1 #} checked {# /if #}> <label class="form-label">Использовать параметры</label></div>
</div>	


<br class="clear">

<div class="action-panel">
<input type="hidden" id="id_page" value="{# $smarty.get.id #}">
<button id="action-structure-update">Сохранить</button> или <a href="{#$SESS_URL#}se" class="cancel">выйти без изменений</a>
</div>

