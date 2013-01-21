<div class="chooser-panel">
	<ul>
		<li><a href="{# $SESS_URL #}section=module">Вернуться к списку модулей</a></li>
		<li><a id="module-blocks-newtypetoggle">Добавить новый информационный блок</a></li>
	</ul>
</div>
<br class="clear">

<div id="module-blocks-newtypediv" style="width: 100%; float: left; height: auto; margin-bottom: 30px; display: none;">
	<div>
		<input type="hidden" value="{# $SESS_URL #}" id="session">
		<input type="hidden" value="{# $smarty.get.type #}" id="module-type">
		<div class="left" style="width: 170px;  margin-left: 20px;"><span>Имя</span></div>
		<div class="left" style="width: 170px;"><span>Название</span></div>
		<br class="clear">
		<div class="left" style="width: 170px; margin-left: 20px;"><input type="text" value="" id="module-blocks-new-type-name" class="form-text" style="width: 150px;"></div>
		<div class="left" style="width: 170px;"><input type="text" value="" id="module-blocks-new-type-title" class="form-text" style="width: 150px;"></div>
		<button id="module-blocks-addnewtype" type="button" style="float: left; margin-left: 20px;">Добавить</button>
	</div>
</div>

<div class="block-content" style="height:auto;">

<h4>Список информационных блоков</h4>

	<table class="table" cellspacing="0" cellpadding="0">
		<tbody id="module-blocks-typetbody">
			<tr class="thead">
				<td>Название</td>
				<td width="10%">Действия</td>	
			</tr>
			{# foreach from = $BlockArray key=id item=item #}
			<tr id="tr{# $item.id_block #}">
				<td><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&content={# $item.id_block #}">{# $item.title #}</a></td>
				<td>
					<div class="action-menu">
	    				<a class="edit" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&block={# $item.id_block #}"></a>
	    				<div class="delete" onclick="deleteBlock({#$item.id_block#}, '{#$item.title#}')"></div>
	    			</div>
				</td>
			</tr>
			{# /foreach #}
		</tbody>
	</table>

</div>