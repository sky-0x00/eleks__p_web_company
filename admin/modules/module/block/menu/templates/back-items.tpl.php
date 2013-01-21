<div class="chooser-panel">
		<ul>
			<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}">��������� � ������ ���������</a></li>
		</ul>
	</div>
	<br class="clear">

	<div class="block-content" style="height: auto;">

		<h4>���������� ���������� ��������� &laquo;{# $CatName #}&raquo;</h4>

		<div style="float: left; width: 100%; margin-left: 10px;">
			<div style="float: left; width: 100%;">
				
				<br>					
				<div class="span">������ ���������:</div>
				<div>
					<select style="width: 500px; height: 20px;" id="item-list">
						{# foreach from=$ItemList item=Item #}
						<option value="{# $Item.value #}">{# $Item.caption #}</option>
						{# /foreach #}
					</select>
				</div>
					
				<br>
				<div class="span"><a class="under" id="item-fields-empty">��������</a></div>
				<br>
				
				<input type="hidden" id="cat-id" value="{# $smarty.get.cat #}" />
				<input type="hidden" id="item-id" value="" />
				
				<div class="span">������������:</div>
				<div>
					<select style="width: 500px; height: 20px;" id="item-cat">
						{# if !$SubCats #}
						<option value="{# $smarty.get.cat #}"></option>
						{# /if #}
						{# foreach from=$SubCats item=Item #}
						<option value="{# $Item.id_cat #}">{# $Item.name #}</option>
						{# /foreach #}
					</select>
				</div>
				<br>
				
				<div class="span">��������:</div>
				<div><input class="form-text" style="width: 490px;" type="text" id="item-name" /></div>
				<br>
								
				<div class="span">������� ��������:</div>
				<div>
					<textarea class="form-textarea" style="width: 495px; height: 100px;" id="item-annot"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">��������</label>
				</div>
				<br>
				
				<div class="span">������:</div>
				<div><input class="form-text" style="width: 120px;" type="text" id="item-portion" /></div>
				<br>
				
				<div class="span">���� (� ���.):</div>
				<div><input class="form-text" style="width: 120px;" type="text" id="item-price" /></div>
				<br>
				
				<div>
					<input class="form-checkbox" type="checkbox" id="item-recipe" />
					<span> �������� ������</span>
				</div>
				<br>
				
				<div id="item-recipe-div" style="height: auto; display: none;">
					<div class="span" style="position: relative; z-index: 0;">��������:</div>
					<div>
						<textarea class="form-textarea" style="width: 630px; height: 300px;" id="item-description"></textarea>
						<br>
						<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
						<label style="width: 100px;" class="form-label">��������</label>
					</div>
					<br>
					
					<div class="span">�������� �������:</div>			
					<div id="item-img-div">
						<input type="hidden" value="" name="item_picture" id="item-picture" />
						<img style="width: 400px; height: auto;" id="item-image" src="" alt="" />
					</div>
					<br class="clear">
					
					<div>
						<form method="post" enctype="multipart/form-data">	
							<br>
							<div class="span">����:</div>
								
							<div>
								<div class="left-auto" style="width: auto;"><input class="form-text" type="text" value="" id="item-picture-new-file" style="width: 150px;"></div>
								<div class="left-auto" style="width: auto;"><button type="button" id="item-picture-button-browse">�����</button></div>
								<div class="left-auto"><button type="button" id="item-picture-button-add">���������</button></div>
							</div>
							
							<br class="clear">
						</form>
					</div>
				</div>
				<br>
																	
				<div class="action-panel" style="margin-left: 0px;">
					<button id="item-button-submit" type="button">���������</button> 
					<button id="item-button-delete" type="button">�������</button>
					<button id="item-button-create" type="button">��������</button>
				</div>
				
				<!--<div style="width: 100%; float: left; height: auto; margin-bottom: 30px;" >
					
					<div>
						<form method="post" enctype="multipart/form-data">	
							<br>
							<div class="span">�������� ����������:</div>
								
							<div>
								<div class="left-auto" style="width: auto;"><input class="form-text" type="text" value="" id="item-photo-new-file" style="width: 150px;"></div>
								<div class="left-auto" style="width: auto;"><button type="button" id="item-photo-button-browse">�����</button></div>
								<div class="left-auto"><button type="button" id="item-photo-button-add">���������</button></div>
							</div>
							
							<br class="clear">
						</form>
					</div>
					<br>
					
					<br>
					
					<div style="width: 100%; float: left; height: auto;">
						
						<div class="item-photo-div" style="float: left; display: none; width: 170px; height: 220px; margin-right: 10px;">
							
							<div align="center" style="border: 2px solid #EADEE0; width: 160px; height: 120px; margin: 3px;"><img src="" alt="" style="width: auto; height: 100%;" /></div>
							<div><input type="hidden" name="id_photo" value="0" /></div>
							<div style="width: 100%; margin: 3px;"><button type="button" class="item-photo-button-delete">�������</button></div>
							
						</div>
					</div>
				</div>-->
				
				<br class="clear">
				
			</div>
		</div>

	</div>