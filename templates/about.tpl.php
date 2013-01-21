{# include file='include/header.tpl.php' #}
	
	<div class="content" style="height: auto; border: 0px solid gray; margin-top: -20px; padding-bottom: 0px;">
		
		<div class="comments-form png" style="border: 0px solid orange;">
			<div class="cross png" title="Закрыть"></div>
			<div class="inside">
				<h1 style="font-size: 18px; margin-bottom: 10px">Отзывы</h1>
				<div class="full-size">
					<img src="{# $Comments[0].photo #}" alt="" />
				</div>
				<div class="comment-text">{# $Comments[0].descr #}</div>
				<div class="comment-nav">
					<ul>
						{# foreach from=$Comments item=Item #}
						<li>
							<input type="hidden" name="id_photo" value="{# $Item.id_photo #}" />
							<input type="hidden" name="photo" value="{# $Item.photo #}" />
							<input type="hidden" name="descr" value="{# $Item.descr #}" />
							<img title="{# $Item.name #}" src="{# $Item.thumb #}" alt="" style="width: 60px; height: 83px; cursor: pointer;" />
						</li>
						{# /foreach #}
					</ul>
				</div>
				<div class="slider-wrap">					
				</div>	
			</div>	
		</div>
			
		<div class="left-column" style="width: 128px; position: absolute; border: 0px solid yellow; margin-left: 100px;">
			<h1 style="font-size: 18px">Отзывы</h1>
			<a><img class="comments png" src="/images/comments.png" width="135" height="145" alt="" title="Посмотреть отзывы" /></a>
			<!--<span class="comments png"><a>Посмотреть отзывы</a></span>-->
		</div>
		
		<div class="basic" style="border: 0px solid white; margin-top: 0px;">
			<div id="breadcrumbs"><a href="/">На главную</a> / <span>О компании</span></div>			
			<h1>О компании</h1>
			<div class="company">
				<p>{# $DOCUMENT_CONTENT #}</p>
			</div>
            
            <h1 class="about">Сертификаты и допуски:</h1>
    		<div class="certificates png">
    			<div class="to-left png" title="Назад">&nbsp;</div>
    			<div class="to-right png" title="Вперед">&nbsp;</div>
    			<div class="wrapper">
    				<ul>
    					{# foreach from=$Sertificates item=Item #}
    					<li>
    						<a class="highslide" href="{# $Item.photo #}" onclick="return hs.expand(this, {  })">
    							<img title="{# $Item.name #}" src="{# $Item.thumb #}" alt="" style="width: 79px; height: 106px;" />
    						</a>	
    					</li>
    					{# /foreach #}
    				</ul>	
    			</div>
    		</div>
        
		</div>	
			
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}