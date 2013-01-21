<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module">Вернуться к списку модулей</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Вернуться к списку альбомов</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">

	<h4>Редактирование альбома "<span id="module-gallery-album-edit-head">{# $Album.name #}</span>"</h4>

	<div style="float: left; width: 500px; margin-left: 10px;">
		<div style="float: left; width: 100%;">
			<form method="post">
				
				<input type="hidden" value="{# $Album.id_album #}" id="module-gallery-album-edit-id" />
				
				<br>
				
				<br>
				<div class="span" style="font-weight: bold;">Название<span class="red">*</span>:</div>
				<div><input class="form-text" style="width: 400px;" type="text" id="module-gallery-album-edit-name" value="{# $Album.name #}" /></div>
				<br>
			
				<br>
				<div class="span" style="font-weight: bold;">Текстовый идентификатор:</div>
				<div><input class="form-text" style="width: 400px;" type="text" id="module-gallery-album-edit-alias" value="{# $Album.alias #}" /></div>
				<br>
									
				<br>
				<div class="span" style="font-weight: bold;">Описание:</div>
				<div><textarea class="form-textarea" style="width: 405px; height: 200px;" id="module-gallery-album-edit-descr">{# $Album.descr #}</textarea></div>
				<br>
				
				<br class="clear">
				
				<div class="action-panel" style="margin-left:0px;">
					<button id="module-gallery-album-button-submit" type="button">Сохранить</button>
				</div>
				
			</form>
		</div>
	</div>

	
</div>