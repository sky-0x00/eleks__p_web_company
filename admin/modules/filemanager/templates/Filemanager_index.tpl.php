{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}

	<tr>
		<td id="td_body" align="center">
		
		{# include file = "$root/admin/modules/filemanager/templates/redactor-window.tpl.php" #}
		{# include file = "$root/admin/modules/filemanager/templates/image-window.tpl.php" #}
		
		<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		
			<tr>
				<td class="main-menu">
				{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
				</td>
				
				<td class="vertical">
					<h3>Файловый менеджер</h3>			
					
					<script language="javascript" src="/admin/lib/jQuery/jquery.ajax.upload.js"></script>
					<script language="javascript" src="/admin/modules/filemanager/js/function.js"></script>
					<script language="javascript" src="/admin/modules/filemanager/js/file-editor.js"></script>
					
					<div id="filemanager">					
						<div id="globalparent">				
							<table class="table-file" cellspacing="0" cellpadding="0">				
								<input type="hidden" id="filemanager-current-path" value="{# $CurPath #}" />
								<tr class="thead">
									<td width="5%"></td>
									<td><a class="under">Имя</a></td>
									<td width="20%"><a class="under">Описание</a></td>
									<td width="10%"><a class="under">Размер</a></td>
									<td width="10%">Атрибуты</td>
									<td width="15%"><a class="under">Изменен</a></td>
								</tr>
								{# foreach from=$FilesList item=FileItem key=item  #}
								{# if $item % 2 #} {# assign var=style value="tr1" #} {# else #} {# assign var=style value="tr2" #} {# /if #}
								{# assign var=path value=$FileItem.filename #}
								{# if $icon[$item] == "icon_img" #}
								{# assign var=action value="OpenImageWin('$CurPath/$path')" #}
								{# else #}
								{# assign var=action value="OpenFileWin('$CurPath/$path')" #}
								{# /if #}
								<tr class="tbody">
									<td>
										<div class="action-menu" style="margin: 0;">
											<div class="icon" style="margin: 0;">
												<div class="block" style="display: none;">
													<div class="drop-menu">
														<input type="hidden" {# if $FileItem.is_folder==1 #} value="folder" {# else #} value="file" {# /if #} name="type" />
														<input type="hidden" value="{# $FileItem.filename #}" name="name" />
														<span class="drop-menu-rename">Переименовать</span>
														<span class="drop-menu-delete">Удалить</span>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td class="{# $style #}">
										<div class="icon">{# if $FileItem.is_folder==1 #}{# /if #}
											<div class="old-div">
												<a {# if $FileItem.is_folder==1 #} class="{# $icon[$item] #}" onClick="chdir('{# $FileItem.filename #}');" {# else #} class="{# $icon[$item] #}" {# /if #}>{# $FileItem.filename #}</a>
											</div>
											<div class="new-div" style="display: none;">
												<div class="left-auto"><input type="text" class="form-text" value="" name="new_name" style="width: 100px;"></div>
												<div class="left-auto"><button class="filemanager-button-rename">Сохранить</button></div>
												<div class="left-auto"><button class="filemanager-button-cancel">Отмена</button></div>
											</div>
										</div>
									</td>
									<td class="{# $style #}">{# $alt[$item] #}</td>
									<td class="{# $style #}">{# $FileItem.size #}</td>
									<td class="{# $style #}">{# $FileItem.attr #}</td>
									<td class="{# $style #}">{# $FileItem.modified #}</td>
								</tr>
								{# /foreach #}

							</table>
						</div>
					
						<br>

						<div style="margin-top:10px;"><a class="under-title" id="show-slice-file">Добавить файл или каталог</a></div>
						<div class="slice-file" id="slice-file" style="display:none;">
							<div>	
								<span>Каталог</span>
								<input type="text" id="filemanager-new-folder-name" /> 
								<button id="filemanager-button-folder-create">Создать</button>
								
								<span>Файл</span>
								<input type="text" id="filemanager-new-file-name" /> 
								<select id="filemanager-new-file-ext">
									<option value=".html">html</option>
									<option value=".php">php</option>
									<option value=".txt">txt</option>
									<option value=".js">js</option>
								</select> 
								<button id="filemanager-button-file-create">Создать</button>
							</div>
						</div>
					
						<div style="margin-top: 20px;"><a class="under-title" id="show-slice-upload">Загрузка файлов</a></div>
						<div class="slice-file" id="slice-upload" style="display:none;">
							<div>
								<span>Выберите файл</span>
								<div class="left-auto"><input class="form-text" type="text" value="" id="filemanager-file-upload" style="width: 200px;"></div>
								<div class="left-auto"><button type="button" id="filemanager-file-upload-button-browse">Обзор</button></div>
								<div class="left-auto"><button type="button" id="filemanager-file-upload-button-submit">Добавить</button></div>
								
							</div>
						</div>
					</div>			
				</td>
			</tr>
		
		</table>
		
		</td>
	</tr>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}