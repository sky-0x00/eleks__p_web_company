<div>
	<h5>{# $mod_info[0].name #}</h5>
	
	<script language="javascript" src="/admin/lib/jquery-ui/ui.datepicker.js" type="text/javascript"></script>
	<script language="javascript" src="/admin/lib/jquery-ui/ui.datepicker-ru.js" type="text/javascript"></script>
	<script language="javascript" src="/admin/lib/jQuery/jquery.jqia.selects.js" type="text/javascript"></script>
	<script language="javascript" src="{# $mod_path #}/js/function.js" type="text/javascript"></script>
	
	<div class="chooser-panel">
		<ul>
			<li><a href="{#$SESS_URL#}section=module">��������� � ������ �������</a></li>
		</ul>
	</div>
	<br class="clear">

	<div class="block-content" style="height:auto;">

	<h4>���������� ��������</h4>

		<div style="float: left; width: 100%; margin-left: 10px;">
			<div style="float: left; width: 100%;">
				
				<br>
				
				<div class="span">���:</div>
				<div>
					<select style="width: 60px;" id="year-list">
						<option value="0"></option>
						{# foreach from=$YearList item=Item #}
						<option value="{# $Item #}">{# $Item #}</option>
						{# /foreach #}
					</select>
				</div>
				
				<br>
				
				<div class="span">������:</div>
				<div>
					<select style="width: 500px;" id="article-list">
						<option value="0"></option>
					</select>
				</div>
				
				<br>
				<br>
					
				<input type="hidden" value="" id="article-id" />
				
				<div class="span">����:</div>
				<div><input class="form-text" style="width: 190px;" type="text" id="article-date" /></div>
				<br>
					
				<div class="span">���������:</div>
				<div><input class="form-text" style="width: 490px;" type="text" id="article-title" /></div>
				<br>
				
				<div class="span">������� ���������:</div>
				<div>
					<textarea class="form-textarea" style="width: 630px; height: 200px;" id="article-annot"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">��������</label>
				</div>
				<br>
				
				<div class="span">�����:</div>
				<div>
					<textarea class="form-textarea" style="width: 630px; height: 300px;" id="article-text"></textarea>
					<br>
					<input type="checkbox" class="form-checkbox" name="redactor_toggle" />
					<label style="width: 100px;" class="form-label">��������</label>
				</div>
				<br>
					
				<br>
				<div class="span"><a class="under" id="article-fields-empty">��������</a></div>
					
				<br class="clear">
					
				<div class="action-panel" style="margin-left: 0px;">
					<button id="article-button-submit" type="button">���������</button> 
					<button id="article-button-delete" type="button">�������</button>
					<button id="article-button-create" type="button">��������</button>
				</div>
				
				<br class="clear">
				
			</div>
		</div>

	</div>

</div>