<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=users">Список пользователей</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content">
	
	<h4>Добавление нового пользователя</h4>
	
	<br>
	<input type="checkbox" class="form-checkbox" id="user-active"><label class="form-label">Активный</label>
	
	
	<div class="span">Имя пользователя:</div>
	<div><input type="text" class="form-text" value="{# $UsersInfo[0].name #}" id="user-name"></div>
	
	<br>
	<div class="span">Логин:</div>
	<div><input type="text" class="form-text" value="{# $UsersInfo[0].login #}" id="user-login"></div>
	
	
	<br>
	<div class="span">Пароль:</div>
	<div><input type="password" class="form-text" value="" id="user-password"></div>
	
	<br>
	<div class="span">Повторить пароль:</div>
	<div><input type="password" class="form-text" value="" id="user-password-re" ></div>		
	
	<h5>Контактные данные</h5>
	
	<br>
	<div class="span">Фото:</div>
	<div><input type="file" class="form-file" value="" id="user-photo"></div>
	
	<br>
	<div class="span">Электронная почта:</div>
	<div><input type="text" class="form-text" value="" id="user-mail"></div>
	
	<br>
	<div class="span">Телефон:</div>
	<div><input type="text" class="form-text" value="" id="user-phone"></div>
	
	<br>
	<div class="span">ICQ:</div>
	<div><input type="text" class="form-text" value="" id="user-icq"></div>	
	
	<h5>Характеристика</h5>
	
	<br>
	<div><textarea class="form-textarea" id="user-comment"></textarea></div>	

	<br class="clear">

	<div class="action-panel">
		<button id="action-users-submit">Добавить</button> или <a class="cancel" href="{#$SESS_URL#}section=users">выйти без сохранения</a>
	</div>
	
</div>