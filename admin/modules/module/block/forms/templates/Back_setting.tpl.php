<h4>��������� ���-�����</h4>

<fieldset class="x-fieldset">
	<legend class="x-legend">���������</legend>
	
	<br>
	<div><input type="checkbox" class="x-form-checkbox" id="active" {# if $FormInfo[0].active == 'Y' #} checked {# /if #}><label class="x-form-label">����������</label></div>
	
	<br>
	<div class="span">��������� (���):</div>
	<div><input type="text" class="x-form-text" value="{# $FormInfo[0].name #}"></div>
	
	<br>
	<div class="span">��� ����� (���):</div>
	<div><input type="text" class="x-form-text" value="{#$FormInfo[0].alias#}"></div>
	
	<br>
	<div class="span">��������:</div>
	<div><textarea class="x-form-text" id="description">{#$FormInfo[0].description#}</textarea></div>
	<div id="description_resizer" class="text_editor" onMouseDown="textareaResizer(event);">&nbsp;</div>
	
	<br>
	<div><input type="checkbox" class="x-form-checkbox" id="allow_mail" {# if $FormInfo[0].allow_mail == 'Y' #} checked {# /if #}><label class="x-form-label">����������� �� E-mail</label></div>
	
	<br>
	<div class="span">������ ������� ��� ��������:</div>
	<div><textarea class="x-form-text">{#$FormInfo[0].mail#}</textarea></div>

	<br>
	<div class="span">������ ������ ��� �����������:</div>
	<div><textarea class="x-form-text" id="template">{#$FormInfo[0].mail_content#}</textarea></div>
	<div id="template_resizer" class="text_editor" onMouseDown="textareaResizer(event);">&nbsp;</div>
	
</fieldset>

<br>

<fieldset class="x-fieldset">
	<legend class="x-legend"><a class="under">������ �����</a></legend>
	<br>
	<a href="">�������� ����</a>	
<!--	<div class="left">������</div>
	<div class="left">���</div>
	<div class="left">��������</div>
	<div class="left">������ ��������</div>
	<div class="left">���� ������������</div>
-->
	<br class="clear">
	<br class="clear">
	{# foreach from=$FormFields item=fields #}
	<div class="left" style="width: 100px;">
		<input type="checkbox" class="x-form-checkbox"><label class="x-form-label">�������</label>
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
		<input type="checkbox" class="x-form-checkbox"><label class="x-form-label">������������</label>
	</div>
	<div>
		<button>�������</button>
	</div>
	<br class="clear">
		
	{# /foreach #}
	
</fieldset>

<div class="button-menu">
<button>���������</button>
<button>��������</button>
</div>