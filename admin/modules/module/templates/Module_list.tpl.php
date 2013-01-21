<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}">Управление списком</a></li>
		<li><a href="{#$SESS_URL#}">Загрузка нового модуля</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height:auto;">

<h4>Список модулей</h4>

	<table class="table" cellspacing="0" cellpadding="0">
		<tr class="thead">
			<td>Название</td>
			<td width="10%">Действия</td>	
		</tr>
		{# foreach from = $ModuleArray item = Item key = id #}
		<tr class="tbody">
			<td><a href="{# $SESS_URL #}section=module&type={# $Item.id #}">{#$Item.name#}</a></td>
			<td>
			<div class="action-menu">
	    		<div class="icon">
	    				<div class="block">
	    					<div class="drop-menu">
	    					
	    					</div>
	    				</div>
	    		</div>
	    	</div>
			</td>
		</tr>
		{# /foreach #}
	</table>

</div>
<!--
<div class="block-description" style="margin-top: 30px;">
	<div>
		<span class="title">Последнее изменение</span>
		<span class="text">29.06.2009 16:50</span>
		<span class="title">Создал</span>
		<span class="text">Мелехов Д.С.</span>
		<span class="title">Редактировал</span>
		<span class="text">Мелехов Д.С.</span>
		<span class="title">Комментарий</span>
		<span class="text"></span>
	</div>
</div>
-->