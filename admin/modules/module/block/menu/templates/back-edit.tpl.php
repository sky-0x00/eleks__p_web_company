<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module">Вернуться к списку модулей</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Вернуться к списку категорий</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">

	<h4>Редактирование категории "<span id="cat-head">{# $CatName #}</span>"</h4>

	<div style="float: left; width: 100%; margin-left: 10px;">
		<div style="float: left; width: 100%;">
			<form method="post">
				
				<div><input type="hidden" value="{# $smarty.get.edit #}" id="cat-id"></div>
	
				<br><br>
				<div class="span"><span style="font-weight: bold;">Название категории:</span></div>
				<div><input type="text" class="form-text" value="{# $CatName #}" id="cat-name"></div>				
				<br><br>
				
				<h5>Подкатегории</h5>
				
				<div id="subcats-div">
					
					<div class="subcat-div" style="display: none; margin: 10px 0px;">
						<input type="hidden" name="id_cat" value="0">
						
						<div class="left-auto"><input type="text" name="name" value=""></div>
						
						<div class="left" style="width: auto;"><div class="subcat-button-delete"></div></div>
						<div class="left" style="width: auto;"><div class="subcat-button-save"></div></div>
					
						<br class="clear">
					</div>
					
					{# foreach from=$SubCats item=Item #}
					<div class="subcat-div" style="margin: 10px 0px;">
						<input type="hidden" name="id_cat" value="{# $Item.id_cat #}">
						
						<div class="left-auto"><input type="text" name="name" value="{# $Item.name #}" /></div>
						
						<div class="left" style="width: auto;"><div class="subcat-button-delete"></div></div>
						<div class="left" style="width: auto;"><div class="subcat-button-save"></div></div>
					
						<br class="clear">
					</div>
					{# /foreach #}
				</div>
				
				<br class="clear">
				
				<div class="action-panel" style="margin-left:0px;">
					<button id="cat-button-submit" type="button">Сохранить</button>
					<div class="span" style="display: inline-block;">или&nbsp;&nbsp;<a class="under" id="add-subcat">добавить подкатегорию</a></div>
				</div>
				
			</form>
		</div>
	</div>

	
</div>