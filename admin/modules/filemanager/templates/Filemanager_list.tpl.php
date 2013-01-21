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
	{# if $CurPath!='' #}
		<tr class="tbody">
			<td></td>
	    	<td><div class="icon"><a class="folder_up" onClick="chdir('upngo');"> ... </a></div></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>        
	    </tr>
	{# /if #}
	{# foreach from=$FilesList item=FileItem key=item  #}
	{# if $item % 2 #} {# assign var=style value="tr1" #} {# else #} {# assign var=style value="tr2" #} {# /if #}
	{# assign var=path value=$FileItem.filename #}
	{# if $icon[$item] == "icon_img" #}
	{# assign var=action value="OpenImageWin('$CurPath/$path')" #}
	{# else #}
	{# assign var=action value="OpenFileWin('$CurPath/$path')" #}
	{# /if #}
	<tr class="tbody">
    	<td class="action">
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