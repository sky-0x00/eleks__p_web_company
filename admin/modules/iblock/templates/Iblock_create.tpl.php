<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=iblock">������ ������</a></li>	
	</ul>
</div>
<br class="clear">

<div class="block-content">
	<h4>���������� �����</h4>				
		
	<br>
	<div><input type="checkbox" id="iblock-active"><label class="form-label">���������� ����</label></div>
	
	<div class="span">��������</div>
	<div><input type="text" class="form-text" value="" id="iblock-description"></div>
	
	<br>
	<div class="span">�����</div>
	<div><input type="text" class="form-text" value="" id="iblock-name"></div>
	
	<br>
	<div class="span">����������</div>
	<div><textarea class="form-text" style="height: 200px; width: 600px;" id="iblock-content"></textarea></div>
	<div id="iblock-content_resizer" class="text_editor" onMouseDown="textareaResizer(event);" style="width:600px;">&nbsp;</div>
	
</div>

<br class="clear">

<div class="action-panel">
<button id="action-iblock-submit">��������</button> ��� <a href="{#$SESS_URL#}section=iblock" class="cancel">����� ��� ����������</a>
</div>