<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=module">��������� � ������ �������</a></li>
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">��������� � ������ ��������</a></li>
	</ul>
</div>
<br class="clear">

<div class="block-content" style="height: auto; width: auto;">

	<h4>�������������� ������� "<span id="module-gallery-album-edit-head">{# $Album.name #}</span>"</h4>

	<div style="float: left; width: 500px; margin-left: 10px;">
		<div style="float: left; width: 100%;">
			<form method="post">
				
				<input type="hidden" value="{# $Album.id_album #}" id="module-gallery-album-edit-id" />
				
				<br>
				
				<br>
				<div class="span" style="font-weight: bold;">��������<span class="red">*</span>:</div>
				<div><input class="form-text" style="width: 400px;" type="text" id="module-gallery-album-edit-name" value="{# $Album.name #}" /></div>
				<br>
			
				<br>
				<div class="span" style="font-weight: bold;">��������� �������������:</div>
				<div><input class="form-text" style="width: 400px;" type="text" id="module-gallery-album-edit-alias" value="{# $Album.alias #}" /></div>
				<br>
									
				<br>
				<div class="span" style="font-weight: bold;">��������:</div>
				<div><textarea class="form-textarea" style="width: 405px; height: 200px;" id="module-gallery-album-edit-descr">{# $Album.descr #}</textarea></div>
				<br>
				
				<br class="clear">
				
				<div class="action-panel" style="margin-left:0px;">
					<button id="module-gallery-album-button-submit" type="button">���������</button>
				</div>
				
			</form>
		</div>
	</div>

	
</div>