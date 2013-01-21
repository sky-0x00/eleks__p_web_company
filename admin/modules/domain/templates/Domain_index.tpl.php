{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}

<div id="outer">

<div id="block-left">
	{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
</div>

<script language="javascript" src="{#$m_path#}/js/domain.js"></script>

<div id="block-center">
	<h3>Управление сайтом</h3>				
	
	<div class="block-content">	
	<h4>Основные настройки</h4>
	
		<br>
		<div><input type="checkbox" id="active" {# if $DomainInfo[0].active == 1 #} checked {# /if #}><label class="form-label">Публикация сайта</label></div>
		
		<div class="span">Название:</div>
		<div><input type="text" class="form-text" value="{# $DomainInfo[0].name #}"  id="name_"></div>
			
		<br>
		<div class="span">URL сайта</div>
		<div>
			<input type="text" class="form-text" value="{# $DomainInfo[0].url #}" name="url" id="url" />
		</div>
			
		<br>
		<div class="span">Страница 403 (Сайт не доступен):</div>
		<div class="input-drop" id="input-error-e403">
			<input type="text" id="input-text-result-e403" value="{# $DomainInfo[0].page403.name #}" />
		</div>
		<input type="hidden" id="select-403" value="{# $DomainInfo[0].page403.id #}" />
		<div class="input-drop-result" id="input-drop-result-e403"></div>
		
		<br>
		<div class="span">Страница 404 (Страница не найдена):</div>
		<div class="input-drop" id="input-error-e404">
			<input type="text" id="input-text-result-e404" value="{# $DomainInfo[0].page404.name #}" />
		</div>
		<input type="hidden" id="select-404" value="{# $DomainInfo[0].page403.name #}" />
		<div class="input-drop-result" id="input-drop-result-e404"></div>
			
		<br>
		<div class="span">Кодировка сайта:</div>
		<div class="input-drop" id="input-charset">
			<input type="text" id="input-text-result" value="{# $DomainInfo[0].charset #}" />
		</div>
		<input type="hidden" id="charset" value="{# $DomainInfo[0].charset #}" />
		<div class="input-drop-result" id="input-drop-result">
			<div><input type="text" readonly tid="windows-1251" value="windows-1251" /></div>
			<div><input type="text" readonly tid="koi-8r" value="koi-8r" /></div>
			<div><input type="text" readonly tid="utf-8" value="utf-8" /></div>
		</div	
			
	</div>	
	
<!--<div class="block-description">
	<div>
		<span class="title">Последнее изменение</span>
		<span class="text" id="domain-date-update">29.06.2009 16:50</span>
		<span class="title">Редактировал</span>
		<span class="text" id="domain-uid-update">Мелехов Д.С.</span>
	</div>
</div>-->

<br class="clear">

<div class="action-panel">
	<button id="action-domain-submit">Сохранить</button> или <a class="cancel" href="{#$SESS_URL#}&section">перейти  на главную</a>
</div>	

</div>



{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}