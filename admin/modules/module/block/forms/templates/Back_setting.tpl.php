<h4>Настройка веб-формы</h4>

<fieldset class="x-fieldset">
	<legend class="x-legend">Настройка</legend>
	
	<br>
	<div><input type="checkbox" class="x-form-checkbox" id="active" {# if $FormInfo[0].active == 'Y' #} checked {# /if #}><label class="x-form-label">Активность</label></div>
	
	<br>
	<div class="span">Заголовок (рус):</div>
	<div><input type="text" class="x-form-text" value="{# $FormInfo[0].name #}"></div>
	
	<br>
	<div class="span">Имя формы (анг):</div>
	<div><input type="text" class="x-form-text" value="{#$FormInfo[0].alias#}"></div>
	
	<br>
	<div class="span">Описание:</div>
	<div><textarea class="x-form-text" id="description">{#$FormInfo[0].description#}</textarea></div>
	<div id="description_resizer" class="text_editor" onMouseDown="textareaResizer(event);">&nbsp;</div>
	
	<br>
	<div><input type="checkbox" class="x-form-checkbox" id="allow_mail" {# if $FormInfo[0].allow_mail == 'Y' #} checked {# /if #}><label class="x-form-label">Уведомление на E-mail</label></div>
	
	<br>
	<div class="span">Список адресов для рассылки:</div>
	<div><textarea class="x-form-text">{#$FormInfo[0].mail#}</textarea></div>

	<br>
	<div class="span">Шаблон письма для уведомления:</div>
	<div><textarea class="x-form-text" id="template">{#$FormInfo[0].mail_content#}</textarea></div>
	<div id="template_resizer" class="text_editor" onMouseDown="textareaResizer(event);">&nbsp;</div>
	
</fieldset>

<br>

<fieldset class="x-fieldset">
	<legend class="x-legend"><a class="under">Список полей</a></legend>
	<br>
	<a href="">Добавить поле</a>	
<!--	<div class="left">Статус</div>
	<div class="left">Тип</div>
	<div class="left">Значение</div>
	<div class="left">Второе значение</div>
	<div class="left">Поле обязательное</div>
-->
	<br class="clear">
	<br class="clear">
	{# foreach from=$FormFields item=fields #}
	<div class="left" style="width: 100px;">
		<input type="checkbox" class="x-form-checkbox"><label class="x-form-label">Активен</label>
	</div>
	<div class="left" style="width: 170px;">
		<select>
		{# foreach from=$FormAllTypes item=Item #}
			<option value="{#$Item.id#}" {# if $Item.id == $fields.type #} selected {# /if #}>{#$Item.name#}[{#$Item.type#}]</option>
		{# /foreach #}
		</select>
	</div>
	<div class="left">
		<input type="text" value="{#$fields.value#}">
	</div>
	<div class="left">
		<input type="text" value="{#$fields.alter_value#}">
	</div>
	<div class="left">
		<input type="checkbox" class="x-form-checkbox"><label class="x-form-label">Обязательное</label>
	</div>
	<div>
		<button>Удалить</button>
	</div>
	<br class="clear">
		
	{# /foreach #}
	
</fieldset>

<div class="button-menu">
<button>Сохранить</button>
<button>Отменить</button>
</div>