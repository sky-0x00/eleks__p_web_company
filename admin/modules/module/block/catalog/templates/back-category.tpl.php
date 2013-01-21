<div class="chooser-panel">
	<ul>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">Заказы</a></li>-->
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">Список элементов</a></li>		
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">Структура каталога</a></li>
		{# if $smarty.get.action=='edit' #}
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">Добавить элемент</a></li>
		{# /if #}
        <!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">Управление параметрами</a></li>-->
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">

	<h4>Редактирование категории "<span id="cat-head">{# $Cat.name #}</span>"</h4>

	<div style="float: left; width: 100%; margin-left: 10px;">
		<div style="float: left; width: 100%;">
			<form method="post">
				
				<div><input type="hidden" value="{# $smarty.get.id #}" id="cat-id" /></div>
	
				<br>
				<div class="span"><span style="font-weight: bold;">Название категории:</span></div>
				<div><input type="text" class="form-text" value="{# $Cat.name #}" id="cat-name" /></div>				
				<br>
								
				<br>
				<div class="span"><span style="font-weight: bold;">Индекс сортировки:</span></div>
				<div><input type="text" class="form-text" value="{# $Cat.sort #}" id="cat-sort" /></div>				
				<br>
				
				<br>
				<div class="span">					
					<span style="font-weight: bold;">Видимость категории:</span>
					<input type="checkbox" class="form-checkbox"  id="cat-active" {# if $Cat.active>0 #}checked{# /if #} />
				</div>
				<br>
				
				<div id="cat-fields-div">
					
					<div class="span"><a class="under" id="cat-add-field">Добавить поле</a></div>
					<br>				
					
					<div style="margin: 10px 0px; padding: 5px;">
						
						<div class="left" style="width: 120px;"><span>Тип поля</span></div>
						<div class="left" style="width: 100px;"><span>Имя(англ.)</span></div>
						<div class="left" style="width: 200px;"><span>Заголовок</span></div>
						<div class="left" style="width: 300px;"><span>Параметры (через точку с запятой)</span></div>
						<div class="left-auto"><span>Обязательное</span></div>
						
					</div>
					<br class="clear">
					
					<div class="cat-field" style="display: none; margin: 10px 0px; padding: 8px 5px;">
						<div><input type="hidden" name="id_field" value="0" /></div>
						
						<div class="left" style="width: 120px;">
							<select name="id_input" style="width: 120px;">
								{# foreach from=$InputTypes item=Item #}
								<option value="{# $Item.id #}">{# $Item.name #}[{# $Item.id #}]</option>
								{# /foreach #}
							</select>
						</div>
						
						<div class="left" style="width: 100px;"><input type="text" name="name" value="" style="width: 100px;" /></div>
						<div class="left" style="width: 200px;"><input type="text" name="title" value="" style="width: 200px;" /></div>
						<div class="left" style="width: 300px;"><textarea name="options" style="width: 300px; height: 60px;"></textarea></div>
						
						<div class="left-auto"><input type="checkbox" name="empty" /></div>
						
						<div class="left-auto"><div class="input-fields-button-delete"></div></div>
						<div class="left-auto"><div class="input-fields-button-save"></div></div>
					
						<br class="clear">
					</div>
					
					{# foreach from=$CatFields item=fields #}
					<div class="cat-field" style="margin: 10px 0px; padding: 8px 5px;">
						<div><input type="hidden" name="id_field" value="{# $fields.id_field #}" /></div>
						
						<div class="left" style="width: 120px;">
							<select name="id_input" style="width: 120px;">
								{# foreach from=$InputTypes item=Item #}
								<option value="{# $Item.id #}" {# if $Item.id == $fields.type #} selected {# /if #}>{# $Item.name #}[{# $Item.id #}]</option>
								{# /foreach #}
							</select>
						</div>
						
						<div class="left" style="width: 100px;"><input type="text" name="name" value="{# $fields.name #}" style="width: 100px;" /></div>
						<div class="left" style="width: 200px;"><input type="text" name="title" value="{# $fields.title #}" style="width: 200px;" /></div>
						<div class="left" style="width: 300px;"><textarea name="options" style="width: 300px; height: 60px;">{# $fields.options #}</textarea></div>
						
						<div class="left-auto">
							<input type="checkbox" name="empty" {# if $fields.empty == 0 #}checked{# /if #} />
						</div>
						
						<div class="left-auto"><div class="input-fields-button-delete"></div></div>
						<div class="left-auto"><div class="input-fields-button-save"></div></div>
					
						<br class="clear">
					</div>
					{# /foreach #}
				</div>
				
				<br class="clear">
				<br class="clear">
				
				<div class="action-panel" style="margin-left:0px;">
					<button id="cat-button-submit" type="button">Сохранить</button>
				</div>
				
			</form>
		</div>
	</div>

	
</div>