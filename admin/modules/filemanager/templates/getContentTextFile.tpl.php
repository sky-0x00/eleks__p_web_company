<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<body>
<table style="height:100%;width:100%;border-collapse:collapse;" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="vertical-align:top; padding: 20px">
			<input type="hidden" id="{# $UNIQHDWID #}_form[filename]" name="{# $UNIQHDWID #}_form[filename]" value="{# $FILENAME #}">
			<textarea id="{# $UNIQHDWID #}_form[content]" name="{# $UNIQHDWID #}_form[content]">{# $CONTENT #}</textarea>
		</td>
	</tr>
	<tr>
		<td>
		<div class="window_bottom">
			<div id="window_corner"></div>			
			<div style="float: right; margin-top: 2px;">
				<button onClick="SaveFileContent({# $PAGEID #}, '{# $UNIQHDWID #}');">Сохранить</button>
			</div>
						
			<div style="margin-left: 20px;"><input type="checkbox" class="x-form-checkbox"><label class="x-form-label" style="width: 100px;">редактор</label></div>
		</div>
		</td>
	</tr>
</table>
</body>