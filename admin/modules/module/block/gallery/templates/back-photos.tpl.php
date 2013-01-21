<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module">Вернуться к списку модулей</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Вернуться к списку альбомов</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">

	<h4>Управление фотографиями</h4>

	<div style="float: left; width: 100%; height: auto; margin-left: 10px;">
		<div><input type="hidden" id="module-gallery-album-id" value="{# $smarty.get.album #}" /></div>
		<br>
		<div style="margin-left: 10px;">
					
			<div id="module-gallery-photo-new-div" style="width: 100%; float: left; height: auto; margin-bottom: 30px;">
				<form method="post" enctype="multipart/form-data">
					<br>		
					<div class="span" style="font-weight: bold;">Выберите загружаемый файл</div>
					<div class="left-auto"><input class="form-text" type="text" value="" id="module-gallery-photo-new-file" style="width: 200px;"></div>
					<div class="left-auto"><button type="button" id="module-gallery-photo-button-browse">Обзор</button></div>
					<div class="left-auto"><button type="button" id="module-gallery-photo-button-add">Загрузить</button></div>
				</form>
			</div>
		</div>
		
		<div id="module-gallery-photo-list-div" style="float: left; width: 100%;">
			<div class="module-gallery-photo-div" style="width: auto; display: none;">
				<div class="left-auto" style="border: 2px solid #EADEE0;"><img src="" alt="" style="width: auto; height: 120px;" /></div>
				<div class="left-auto" style="margin-bottom: 10px; margin-right: 0px;">
					<textarea class="form-textarea" style="width: 500px; height: 150px" name="descr"></textarea>
				</div>
				<div><input type="hidden" name="id_photo" value="" /></div>
				<br class="clear">
				<div class="left-auto"><button class="module-gallery-photo-button-save" type="button">Сохранить</button></div>
				<div class="left-auto"><button class="module-gallery-photo-button-delete" type="button">Удалить</button></div>
			</div>
			{# foreach from = $PhotoArray key=key item=item #}
			<div class="module-gallery-photo-div" style="width: auto;">
				<div style="margin-left: 99px;"> <input type="text" class="form-text" name="name" style="width:495px;" value="{# $item.name #}"></div>
				<div class="left-auto" style="border: 2px solid #EADEE0;"><img src="{# $item.thumb #}" alt="" style="width: auto; height: 120px;" /></div>
				<div class="left-auto" style="margin-bottom: 10px; margin-right: 0px;">
					<textarea class="form-textarea" style="width: 500px; height: 120px" name="descr">{# $item.descr #}</textarea>
				</div>
				<div><input type="hidden" name="id_photo" value="{# $item.id_photo #}" /></div>
				<br class="clear">
				<div class="left-auto"><button class="module-gallery-photo-button-save" type="button">Сохранить</button></div>
				<div class="left-auto"><button class="module-gallery-photo-button-delete" type="button">Удалить</button></div>
			</div>
			{# /foreach #}
		</div>
	</div>

</div>