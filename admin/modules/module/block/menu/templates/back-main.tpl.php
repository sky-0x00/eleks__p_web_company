<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=module">Вернуться к списку модулей</a></li>
		<li><a class="under" id="add-new-parent-cat">Добавить новую категорию</a></li>
	</ul>
</div>
<br class="clear">

<div id="catalog-new-parent-div" style="width: 100%; height: auto; margin-bottom: 30px; padding-left: 15px; display: none;">
	<input type="hidden" value="{# $smarty.get.type #}" id="module-type" />
	<div class="span">Название новой категории</div>
	<div class="left-auto"><input type="text" class="form-text" value="" name="cat_name"></div>
	<div class="left-auto"><button id="parent-cat-button-submit">Добавить</button></div>
	<div class="left-auto"><button id="parent-cat-button-cancel">Отменить</button></div>
	<br class="clear">
</div>

<div class="block-content" style="height: auto; width: 90%; padding-bottom: 50px;">

	<h4>Список основных категорий меню</h4>
	<br>
	
	<div style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0; clear: left; display: none;" class="cat-list-item">
		<input type="hidden" name="id_cat" value="0" />
		
		<div class="left" style="width: 90%; margin-right: 0;">
			<a class="cat-name" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&cat=" style="margin-left: 25px;"></a>
		</div>
				
		<div class="left" style="width: 10%; margin-right: 0;">
			<div class="action-menu" style="margin: 0;">
				<div class="icon" style="margin: 0;">
					<div class="block" style="display: none;">
						<div class="drop-menu">
							<span class="drop-menu-edit-cat">Редактировать</span>
							<span class="drop-menu-delete-cat">Удалить</span>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
	
	{# foreach from=$CatList item=Item #}
	<div style="float: left; width: 100%; padding: 10px 0 10px 0; height: auto; margin: 0; clear: left;" class="cat-list-item">
		<input type="hidden" name="id_cat" value="{# $Item.value #}" />
		
		<div class="left" style="width: 90%; margin-right: 0;">
			<a class="cat-name" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&cat={# $Item.value #}" style="margin-left: 25px;">{# $Item.caption #}</a>
		</div>
				
		<div class="left" style="width: 10%; margin-right: 0;">
			<div class="action-menu" style="margin: 0;">
				<div class="icon" style="margin: 0;">
					<div class="block" style="display: none;">
						<div class="drop-menu">
							<span class="drop-menu-edit-cat">Редактировать</span>
							<span class="drop-menu-delete-cat">Удалить</span>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
	{# /foreach #}
	
	<br class="clear">
	<br><br>
	
	<div style="margin-left: 20px;">
		<form method="post" enctype="multipart/form-data" action="">
				
			<br>
			<div class="span">Загрузить из файла:</div>
			<div>
				<input type="file" name="menu" style="width: 200px;" />
				<input type="submit" style="margin-left: 20px;" value="Загрузить" />
			</div>
			<div style="font-size: 6;">{# $Message #}<div>
			<br>
		</form>
	</div>
	
</div>