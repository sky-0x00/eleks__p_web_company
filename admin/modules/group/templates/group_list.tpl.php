<div class="chooser-panel">
	<ul>
		<li><a class="under" id="user-group-addnew">Добавить группу</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto">

	<div style="float: left; margin-left: 10px;">
						
		<div class="left" style="width: 400px;"><span>Название</span></div>
		<div class="left" style="width: 70px;"><span>Админ.</span></div>
		<div class="left" style="width: 100px; margin-left: 20px;"><span>Действия</span></div>
						
		<br class="clear">
					
		<div class="user-group-div" style="display: none; margin: 10px 0px;">
			<div ><input type="hidden" name="id_group" value="0"></div>
						
			<div class="left" style="width: 400px;"><input type="text" name="name" value="" style="width: 90%;" /></div>
			<div class="left" style="width: 70px;"><input type="checkbox" name="admin" style="margin-left: 15px;" /></div>
						
			<div class="left" style="width: auto;"><button class="picture-button-save"></button></div>
			<div class="left" style="width: auto;"><button class="picture-button-delete"></button></div>
					
			<br class="clear">
		</div>
		
		{# foreach from=$Groups item=group #}
		<div class="user-group-div" style="margin: 10px 0px;">
			<div ><input type="hidden" name="id_group" value="{# $group.group_id #}"></div>
						
			<div class="left" style="width: 400px;"><input type="text" name="name" value="{# $group.name #}" style="width: 90%;" /></div>
			<div class="left" style="width: 70px;"><input type="checkbox" name="admin" {# if $group.admin==1 #}checked{# /if #} style="margin-left: 15px;" /></div>
						
			<div class="left" style="width: auto;"><button class="picture-button-save"></button></div>
			<div class="left" style="width: auto;"><button class="picture-button-delete"></button></div>
					
			<br class="clear">		
		</div>
		{# /foreach #}
	</div>
	
</div>