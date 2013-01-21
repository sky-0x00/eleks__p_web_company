<div>
	<h5>{# $mod_info[0].name #}</h5>
	
	<script language="javascript" src="/admin/lib/jQuery/jquery.ajax.upload.js" type="text/javascript"></script>
	<script language="javascript" src="/admin/lib/jquery-ui/ui.datepicker.js" type="text/javascript"></script>
	<script language="javascript" src="/admin/lib/jquery-ui/ui.datepicker-ru.js" type="text/javascript"></script>
	<script language="javascript" src="/admin/lib/jQuery/jquery.jqia.selects.js" type="text/javascript"></script>
	<script language="javascript" src="{# $mod_path #}/js/function.js" type="text/javascript"></script>
	
	<div class="chooser-panel">
		<ul>
			<li><a href="{# $SESS_URL #}section=module">Вернуться к списку модулей</a></li>
		</ul>
	</div>
	<br class="clear">

	<div class="block-content" style="height: auto;">

	<h4>Управление мероприятиями</h4>

		<div style="float: left; width: 100%; margin-left: 10px;">
			<div style="float: left; width: 100%;">
				
				<br>
				
				<div class="span">Год:</div>
				<div>
					<select style="width: 60px;" id="year-list">
						<option value="0"></option>
						{# foreach from=$YearList item=Item #}
						<option value="{# $Item #}">{# $Item #}</option>
						{# /foreach #}
					</select>
				</div>
				
				<br>
				
				<div class="span">Статьи:</div>
				<div>
					<select style="width: 500px;" id="event-list">
						<option value="0"></option>
					</select>
				</div>
				
				<br>
				<br>
					
				<input type="hidden" value="" id="event-id" />
				
				<div class="span">Дата:</div>
				<div><input class="form-text" style="width: 100px;" type="text" id="event-date" /></div>
				<br>
					
				<div class="span">Заголовок:</div>
				<div><input class="form-text" style="width: 490px;" type="text" id="event-title" /></div>
				<br>
				
				<div class="span">Краткая аннотация:</div>
				<div>
					<textarea class="form-textarea" style="width: 630px; height: 100px;" id="event-annot"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">редактор</label>
				</div>
				<br>
				
				<div class="span">Текст:</div>
				<div>
					<textarea class="form-textarea" style="width: 630px; height: 300px;" id="event-text"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">редактор</label>
				</div>
				<br>
					
				<br>
				<div class="span"><a class="under" id="event-fields-empty">Очистить</a></div>
					
				<br class="clear">
					
				<div class="action-panel" style="margin-left: 0px;">
					<button id="event-button-submit" type="button">Сохранить</button> 
					<button id="event-button-delete" type="button">Удалить</button>
					<button id="event-button-create" type="button">Добавить</button>
				</div>
				
				<br class="clear">
				
				<div style="width: 100%; float: left; height: auto; margin-bottom: 30px;" >
					
					<div>
						<form method="post" enctype="multipart/form-data">	
							<br>
							<div class="span">Добавить фотографию:</div>
								
							<div>
								<div class="left-auto" style="width: auto;"><input class="form-text" type="text" value="" id="event-photo-new-file" style="width: 150px;"></div>
								<div class="left-auto" style="width: auto;"><button type="button" id="event-photo-button-browse">Обзор</button></div>
								<div class="left-auto"><button type="button" id="event-photo-button-add">Загрузить</button></div>
							</div>
							
							<br class="clear">
						</form>
					</div>
					<br>
					
					<br>
					
					<div style="width: 100%; float: left; height: auto;">
						
						<div class="event-photo-div" style="float: left; display: none; width: 170px; height: 220px; margin-right: 10px;">
							
							<div align="center" style="border: 2px solid #EADEE0; width: 160px; height: 120px; margin: 3px;"><img src="" alt="" style="width: auto; height: 100%;" /></div>
							<div><input type="hidden" name="id_photo" value="0" /></div>
							<div style="width: 100%; margin: 3px;"><button type="button" class="event-photo-button-delete">Удалить</button></div>
							
						</div>
					</div>
				</div>
				
				<br class="clear">
			</div>
		</div>

	</div>

</div>