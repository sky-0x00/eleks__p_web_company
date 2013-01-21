<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=template">Вернуться к списку шаблонов</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">

	<h4>Добавление шаблона</h4>
	
	<br>		
	<div class="span">Название<span style="color: #FF0000">*</span></div>
	<div><input type="text" class="form-text" value="" id="template-name"></div>
	
	<br>
	<div class="span">Имя файла<span style="color: #FF0000">*</span></div>
	<div><input type="text" class="form-text" value="" id="template-filename"></div>
	
	<br>
	<div class="span">Группа<span style="color: #FF0000">*</span></div>
	<div>
		<select class="form-select" id="template-group">
			{# foreach from=$TemplateGroups item=item #}
			<option value="{# $item.id #}">{# $item.name #}</option>
			{# /foreach #}
		</select>
	</div>
	
	<br>		
	<div class="span">css</div>
	<div><input type="text" class="form-text" value="" id="template-css"></div>
	
	<br>
	<div class="span">Описание</div>
	<div>
		<textarea class="form-textarea" id="template-description"></textarea>
	</div>
	
</div>

<br class="clear">
<br class="clear">

<div class="action-panel">
	<button id="template-button-create">Добавить</button> или <a href="{# $SESS_URL #}section=template" class="cancel">выйти без сохранения</a>
</div>
