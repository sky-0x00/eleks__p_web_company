{# include file='include/header.tpl.php' #}
	
	<div class="content">
		
		<div id="map" class="png">
			<div class="cross png">&nbsp;</div>
			<div class="name">Схема проезда</div>
			<div class="route">Номера маршрутов</div>
		</div>
		
		<div class="left-column">
			<!--<span class="map png"><a>Посмотреть схему проезда</a></span>-->
		</div>
		<div class="right-column">
			{# $cms_module_feedback #}	
		</div>
		<div class="center">
			<div id="breadcrumbs"><a href="/">Главная</a> / <span>Контакты</span></div>
			<h1>Контактная информация</h1>
			
			{# $DOCUMENT_CONTENT #}
			<div class="border"></div>

		</div>
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}