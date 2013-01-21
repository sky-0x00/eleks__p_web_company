<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module">Вернуться к списку модулей</a></li>
		<li><a class="under" id="module-gallery-album-new-toggle">Добавить новый альбом</a></li>
	</ul>
</div>
<br class="clear">

<div id="module-gallery-album-new-div" style="width: 100%; float: left; height: auto; margin-bottom: 30px; display: none;">
	<div>
		<input type="hidden" value="{# $SESS_URL #}" id="session">
		<input type="hidden" value="{# $smarty.get.type #}" id="module-type">
		<input class="form-text" type="text" value="" id="module-gallery-album-new-name" style="float: left; margin-left: 20px;">
		<button type="button" id="module-gallery-album-button-add" style="float: left; margin-left: 20px;">Добавить</button>
	</div>
</div>

<div class="block-content" style="height:auto; width: 500px;">

	<h4>Список альбомов</h4>
	<br>
	<div id="module-gallery-album-list" style="float: left; width: 100%; margin-left: 10px;">
		<div id="module-gallery-album-list-head">
			<div class="left"><span>Название</span></div>	
			<div class="right"><span>Действия</span></div>
		</div>
		
		<br class="clear">
		<br class="clear">
		
		<div id="module-gallery-album-list-albums" style="height:auto; width:100%;">
			<div class="module-gallery-album-list-item" style="width: 100%; display: none;">
				<input type="hidden" name="id_album" value="0" />
				<div class="left-auto">
					<a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&album="></a>
				</div>
			
				<div class="right">	
					<div class="action-menu">
	    				<a class="edit" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&edit_album="></a>
	    				<div class="delete"></div>
	    			</div>
	    		</div>
	    		<br class="clear">
	    	</div>
			{# foreach from = $AlbumArray key=id item=item #}
			<div class="module-gallery-album-list-item" style="width:100%;">
				<div><input type="hidden" name="id_album" value="{# $item.id_album #}"></div>
				<div class="left-auto">
					<a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&album={# $item.id_album #}">{# $item.name #}</a>
				</div>
			
				<div class="right">	
					<div class="action-menu">
	    				<a class="edit" href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&edit_album={# $item.id_album #}"></a>
	    				<div class="delete"></div>
	    			</div>
	    		</div>
	    		<br class="clear">
	    	</div>
			{# /foreach #}
		</div>
	</div>

</div>