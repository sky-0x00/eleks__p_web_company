{# include file='include/header.tpl.php' #}
	
	<div class="content" style="margin-top: -20px; height: 556px;">
		
		<div id="map" class="png">
			<div class="cross png">&nbsp;</div>
			<div class="name">Схема проезда</div>
			<div class="route">Номера маршрутов</div>
		</div>
		
        <div id="breadcrumbs"><a href="/">Главная</a> / <span>Контакты</span></div>
        
		<div class="left-column contacts">
			{# $DOCUMENT_CONTENT #}        
			<!--<div class="border"></div>-->
		</div>
        
		<div class="right-column">
			{# $cms_module_feedback0 #}
            
            <script src="/admin/modules/module/block/feedback/js/function.js"></script>
            <div id="feedback"  style="border: 1px none yellow;">            
                <form action="">
                	<h1 style="font-size: 18px;">Форма для быстрой связи:</h1>
                	<p>Имя *</p>
                	<input id="feedback-name" type="text" />
                	<p>Контактный телефон</p>
                	<input id="feedback-phone" type="text" />
                	<p>E-mail *</p>
                	<input id="feedback-email" type="text" />
                	<p>Текст сообщения *</p>
                	<textarea id="feedback-message" rows="" cols=""></textarea>
                	<p>* поля, обязательные для заполнения</p>
                    <button class="png" id="feedback-send">Отправить</button>
                </form>
            </div>	
		</div>
        
		<!--<div class="center">			
			<span class="map png"><a>Посмотреть схему проезда</a></span>
		</div>-->
	</div>
    
</div>
	
{# include file='include/footer.tpl.php' #}