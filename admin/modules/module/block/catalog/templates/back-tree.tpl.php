<div class="chooser-panel">
	<ul>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=orders">������</a></li>-->
		<li><a href="{#$SESS_URL#}section=module&type={# $smarty.get.type #}">������ ���������</a></li>
		<!--<li class="current"><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=tree">��������� ��������</a></li> -->
		<li class="current">��������� ��������</li>
		<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=add">�������� �������</a></li>
		<!--<li><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=settings">���������� �����������</a></li>-->
		
	</ul>
</div>
<br class="clear">

<div id="catalog-new-parent-div" style="width: 100%; height: auto; margin-bottom: 30px; padding-left: 15px; display: none;">
	<input type="hidden" value="{# $smarty.get.type #}" id="module-type" />
	<div class="span">�������� ����� ���������</div>
	<div class="left-auto"><input type="text" class="form-text" value="" name="cat_name"></div>
	<div class="left-auto"><button id="parent-cat-button-submit">��������</button></div>
	<div class="left-auto"><button id="parent-cat-button-cancel">������</button></div>
	<br class="clear">
</div>

<div class="block-content" style="height: auto; width: 90%; padding-bottom: 50px;">
	
	
	<h4>��������� �������� <a id="add-new-parent-cat" class="under">�������� ���������</a></h4>
	
	<br>
	
	<div class="my-tree" style="margin: 10px 0px 15px 0px;"></div>
	
	
	
	<div id="cat-list" style="float: left; width: 100%;">
		<ul>
			<li class="cat-list-item" style="display: none;">
				<div class="cat-edit-div" style="display: none;">
					<div class="left-auto"><input type="text" class="form-text" value="" name="cat_name"></div>
					<div class="left-auto"><button class="cat-button-apply">���������</button></div>
					<div class="left-auto"><button class="cat-button-cancel">������</button></div>
					<br class="clear">
				</div>
				<div class="cat-item-div" style="display: none;">
					<input type="hidden" value="0" name="cat_id" />
					<div class="left-auto"><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=category&id="></a></div>
					<!--<div class="left-auto" style="margin: 0px;"><button class="cat-button-create"></button></div>-->
					<div class="left-auto" style="margin: 0px;"><button class="cat-button-edit"></button></div>
					<div class="left-auto" style="margin: 0px;"><button class="cat-button-delete"></button></div>
					<br class="clear">
				</div>
			</li>
		{# defun name="myList" list=$CatTree #}
		{# foreach from=$list item=elm #}
			<li class="cat-list-item">
				<div class="cat-item-div">
					<input type="hidden" value="{# $elm.id #}" name="cat_id" />
					<div class="left-auto"><a href="{# $SESS_URL #}section=module&type={# $smarty.get.type #}&action=category&id={# $elm.id #}">{# $elm.name #}</a></div>
					<!--<div class="left-auto" style="margin: 0px;"><button class="cat-button-create"></button></div>-->
					<div class="left-auto" style="margin: 0px;"><button class="cat-button-edit"></button></div>
					<div class="left-auto" style="margin: 0px;"><button class="cat-button-delete"></button></div>
					<br class="clear">
				</div>
				{# if !empty($elm.children) #}
				<ul>
					{# fun name="myList" list=$elm.children #}
				</ul>
				{# /if #}
			</li>
		{# /foreach #}
		{# /defun #}
		</ul>
	</div>
	
	<br class="clear">
</div>

<p>&nbsp;<p>