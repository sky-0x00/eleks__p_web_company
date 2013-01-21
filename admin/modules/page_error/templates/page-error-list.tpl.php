<div class="chooser-panel">
	<ul>
		<li><a class="under" id="page-error-create-link">Добавить страницу</a></li>
	</ul>
</div>
<br class="clear">			
				
<div id="page-error-create-div" style="float: left; margin: 0 0 20px 20px; display: none;">
	<div style="margin: 0px 10px 10px 0px">
		<div class="left" style="width: 320px;">Имя страницы:</div>
		<div class="left" style="width: 200px;">Имя файла:</div>
		<br class="clear">
		<div class="left" style="width: 320px;"><input type="text" id="page-error-name" style="width: 300px;" /></div>
		<div class="left" style="width: 170px;"><input type="text" id="page-error-filename" style="width: 150px;" /></div>
		<div class="left" style="width: 100px;"><button id="page-error-button-create">Создать</button></div>
	</div>
</div>

<div class="block-content" style="height: auto; width: 90%;">

	<h4>Шаблоны</h4>
	<br>

	<div style="float: left; width: 100%;">
						
		<div class="left" style="width: 60%; margin-right: 0;"><span style="color: #000000">Имя шаблона</span></div>
		<div class="left" style="width: 30%; margin-right: 0;"><span style="color: #000000">Имя файла</span></div>
		<div class="left" style="width: 10%; margin-right: 0;"><span style="color: #000000">Действия</span></div>
						
		<br class="clear">
	</div>
	<br class="clear">
	
	<div class="my-tree" style="margin: 10px 0px 15px 0px;"></div>
	
	<div class="page-error-list" style="float: left; width: 100%;">
	
		<div class="page-error-list-item" style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0; display: none;">
			
			<input type="hidden" name="id" value="0" />
				
			<div class="page-error-name-div" style="float: left; width: 90%; margin: 0;">
			
				<div class="left" style="width: 67%; margin-right: 0;">
					<span class="page-error-item-name" style="margin-left: 10px;"></span>
				</div>
					
				<div class="page-error-item-filename" style="float: left; width: 33%; margin-right: 0;">
					<a class="under"></a>
				</div>
			</div>
			
			<div class="page-error-rename-div" style="float: left; width: 90%; display: none;">
				<div class="left-auto" style="margin-left: 10px;"><input type="text" class="form-text" value="" name="name" style="width: 200px;" /></div>
				<div class="left-auto"><input type="text" class="form-text" value="" name="filename" style="width: 100px;" /></div>
				<div class="left-auto"><button class="page-error-button-rename">Сохранить</button></div>
				<div class="left-auto"><button class="page-error-button-cancel">Отменить</button></div>
			</div>
				
			<div class="left" style="width: 10%; margin-right: 0;">
				<div class="action-menu" style="margin: 0;">
					<div class="icon" style="margin: 0;">
						<div class="block" style="display: none;">
							<div class="drop-menu">
								<span class="drop-menu-edit-page-error">Редактировать</span>
								<span class="drop-menu-delete-page-error">Удалить</span>
							</div>
						</div>
					</div>
				</div>
			</div>
				
		</div>
		
		{# foreach from = $PageList item = item #}
		<div class="page-error-list-item" style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0;">
			
			<input type="hidden" name="id" value="{# $item.id #}" />
					
			<div class="page-error-name-div" style="float: left; width: 90%; margin: 0;">
			
				<div class="left" style="width: 67%; margin-right: 0;">
					<span class="page-error-item-name" style="margin-left: 10px;">{# $item.name #}</span>
				</div>
					
				<div class="page-error-item-filename" style="float: left; width: 33%; margin-right: 0;">
					<a class="under">{# $item.filename #}</a>
				</div>
			</div>
			
			<div class="page-error-rename-div" style="float: left; width: 90%; display: none;">
				<div class="left-auto" style="margin-left: 10px;"><input type="text" class="form-text" value="{# $item.name #}" name="name" style="width: 200px;" /></div>
				<div class="left-auto"><input type="text" class="form-text" value="{# $item.filename #}" name="filename" style="width: 100px;" /></div>
				<div class="left-auto"><button class="page-error-button-rename">Сохранить</button></div>
				<div class="left-auto"><button class="page-error-button-cancel">Отменить</button></div>
			</div>
				
			<div class="left" style="width: 10%; margin-right: 0;">
				<div class="action-menu" style="margin: 0;">
					<div class="icon" style="margin: 0;">
						<div class="block" style="display: none;">
							<div class="drop-menu">
								<span class="drop-menu-edit-page-error">Редактировать</span>
								<span class="drop-menu-delete-page-error">Удалить</span>
							</div>
						</div>
					</div>
				</div>
			</div>
				
		</div>
		{# /foreach #}
		
	</div>
</div>		