<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=iblock">������ ������</a></li>	
	</ul>
</div>
<br class="clear">

<div class="block-content">
	<h4>�������������� �����</h4>				

	<input type="hidden" id="iblock-id" value="{# $iblock_info[0].id #}">
	
	<br>
	<div><input type="checkbox" id="iblock-active" {# if $iblock_info[0].active == "Y" #} checked {# /if #}><label class="form-label">���������� ����</label></div>
	
	<div class="span">��������</div>
	<div><input type="text" class="form-text" id="iblock-description" value="{# $iblock_info[0].description #}"></div>
	
	<br>
	<div class="span">�����</div>
	<div><input type="text" class="form-text" id="iblock-name" value="{# $iblock_info[0].name #}"></div>
	
	<br>
	<div class="span">����������</div>
	<div><textarea class="form-text" style="height: 200px; width: 600px;" id="iblock-content">{# $iblock_info[0].content #}</textarea></div>
	<div id="iblock-content_resizer" class="text_editor" onMouseDown="textareaResizer(event);" style="width:600px;">&nbsp;</div>
	
	
</div>

<br class="clear">

<div class="action-panel">
<button id="action-iblock-update">���������</button> ��� <a href="{#$SESS_URL#}section=iblock" class="cancel">����� ��� ����������</a>
</div>
