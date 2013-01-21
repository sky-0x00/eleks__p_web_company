<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=users">Список пользователей</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">
	
	<h4>Редактирование пользователя</h4>
	<br>
	<input type="checkbox" class="form-checkbox" id="user-active" {# if $data[0].active == 'Y' #} checked {# /if #}><label class="form-label">Активный</label>
	
	<div class="span">Имя пользователя:</div>
	<div><input type="text" class="form-text" value="{# $data[0].name #}" id="user-name"></div>
	
	<br>
	<div class="span">Логин:</div>
	<div><input type="text" class="form-text" value="{# $data[0].login #}" id="user-login"></div>
	
	<br><a class="under" id="user-password-change">назначить новый пароль</a>
	
	<div id="layer-password-change">
	<br>
	<div class="span">Пароль:</div>
	<div><input type="password" class="form-text" value="" id="user-password"></div>
	
	<br>
	<div class="span">Повторить пароль:</div>
	<div><input type="password" class="form-text" value="" id="user-password-re" ></div>		
	
	<br>
	<input type="checkbox" class="form-checkbox" id="report-mail" checked><label class="form-label"> уведомление на электронную почту</label>
	</div>
	
</div>

<br class="clear"><br>

<div class="block-content">
	
	<h5>Контактные данные</h5>
	
	<br>
	<div class="span">Фото:</div>
	<div><input type="file" class="form-file" id="user-photo"></div>
	
	<br>
	<div class="span">Электронная почта:</div>
	<div><input type="text" class="form-text" value="{# $data[0].email #}" id="user-mail"></div>
	
	<br>
	<div class="span">Телефон:</div>
	<div><input type="text" class="form-text" value="{# $data[0].phone #}" id="user-phone"></div>
	
	<br>
	<div class="span">ICQ:</div>
	<div><input type="text" class="form-text" value="{# $data[0].icq #}" id="user-icq"></div>	
</div>

<br class="clear"><br>

<div class="block-content">
	
	<h5>Характеристика</h5>
	
	<br>
	<div><textarea class="form-textarea" id="user-comment">{# $data[0].comment #}</textarea></div>	
</div>

<br class="clear">

<div class="action-panel">
	<input type="hidden" name="id_user" value="{# $data[0].user_id #}" />
	<button id="action-users-update">Сохранить</button> или <a class="cancel" href="{#$SESS_URL#}section=users">выйти без изменений</a>
</div>