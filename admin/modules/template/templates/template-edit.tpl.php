<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=template">��������� � ������ ��������</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">

	<h4>�������������� �������</h4>
	
	<input type="hidden" value="{# $TemplateInfo.template_id #}" id="template-id">
	
	<br>		
	<div class="span">��������<span style="color: #FF0000">*</span></div>
	<div><input type="text" class="form-text" value="{# $TemplateInfo.name #}" id="template-name"></div>
	
	<br>
	<div class="span">��� �����<span style="color: #FF0000">*</span></div>
	<div><input type="text" class="form-text" value="{# $TemplateInfo.filename #}" id="template-filename"></div>
	
	<br>
	<div class="span">������<span style="color: #FF0000">*</span></div>
	<div>
		<select class="form-select" id="template-group">
			{# foreach from=$TemplateGroups item=item #}
			<option value="{# $item.id #}" {# if $item.id==$TemplateInfo.group #}selected{# /if #}>{# $item.name #}</option>
			{# /foreach #}
		</select>
	</div>
	
	<br>		
	<div class="span">css</div>
	<div><input type="text" class="form-text" value="{# $TemplateInfo.css #}" id="template-css"></div>
	
	<br>
	<div class="span">��������</div>
	<div>
		<textarea class="form-textarea" id="template-description">{# $TemplateInfo.description #}</textarea>
	</div>
	
</div>

<br class="clear">
<br class="clear">

<div class="action-panel">
	<button id="template-button-update">���������</button> ��� <a href="{# $SESS_URL #}section=template" class="cancel">����� ��� ����������</a>
</div>