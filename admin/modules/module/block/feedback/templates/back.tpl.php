
<div class="block-content">	
	<h5>{# $mod_info[0].name #}</h5>
	
	<script language="javascript" src="{#$mod_path#}/js/function.js"></script>

	<br>
	<div><input type="checkbox" id="feedback-allow" {# if $mod_param[0].feedback_allow_mail == 'Y' #} checked {# /if #}><label class="form-label">Уведомление на E-mail</label></div>

	<div style="float: left; width: 350px;">
	
	<div class="span">Список адресов:</div>
	<div><input type="text" class="form-text" id="feedback-mails" value="{# $mod_param[0].feedback_mails #}"></div>

	<br>
	<div class="span">Заголовок письма:</div>
	<div><input type="text" class="form-text" id="feedback-subject" value='{# $mod_param[0].feedback_subject #}'></div>
	
	<br>
	<div class="span"><a class="under">Шаблон письма:</a></div>
	<div><textarea class="form-text" style="height: 150px; width: 500px;" id="feedback-mail-template">{# $mod_param[0].feedback_mail_template #}</textarea></div>
	<div id="feedback-mail-template_resizer" class="text_editor" onMouseDown="textareaResizer(event);">&nbsp;</div>		
	
	<br>
	<div class="span">Сообщение о доставке:</div>
	<div><input type="text" class="form-text" id="feedback-access" value="{# $mod_param[0].feedback_access #}"></div>
	
	<br>
	<div class="span">Сообщение об ошибке:</div>
	<div><input type="text" class="form-text" id="feedback-error" value="{# $mod_param[0].feedback_error #}"></div>
	
	<br>
	<div><input type="checkbox" id="feedback-captcha" {# if $mod_param[0].feedback_captcha == 'Y' #} checked {# /if #}><label class="form-label">Использовать защиту CAPTCHA</label></div>	
	
	</div>
	
	<div style="float: left; width: 500px;">

	<div class="span"><a class="under">Шаблон формы:</a></div>
	<div><textarea class="form-text" style="height: auto; min-height: 385px; width: 100%;" id="feedback-template"></textarea></div>
	<div style="display:none;" id="feedback-template-temp">{# $mod_param[0].feedback_front_template #}</div>
	
	</div>
	
</div>

<br class="clear">

<div class="action-panel">
	<button id="module-feedback-submit">Сохранить</button> или <a href="{#$SESS_URL#}section=module" class="cancel">выйти без сохранения</a>
</div>