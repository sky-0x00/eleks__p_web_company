{# include file='include/header.tpl.php' #}
	
	<div style="position: absolute; top: -20000px;">
		{# foreach from=$Objects key=key item=Item #}
		<img src="{# $Item.photo #}" width="331" height="219" />
		{# /foreach #}
	</div>
	
	<div class="content" style="border: 1px none gray; margin-top: 0px; padding-bottom: 0px;">
		<div class="left-column services" style="margin-top: 30px; margin-left: 30px; position: absolute; width: auto; border: 0px solid orange;">
			<h1 style="font-size: 18px">Направления работ:</h1>
			<div class="circle png">
				<a title="Автоматизированные системы" class="first{# if $DOCUMENT_SECTION == 'services' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services' #}href="/services/"{# /if #}>&nbsp;</a>
				<a title="Электромонтажные работы" class="second{# if $DOCUMENT_SECTION == 'services/montage' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/montage' #}href="/services/montage/"{# /if #}>&nbsp;</a>
				<a title="Строительные работы" class="third{# if $DOCUMENT_SECTION == 'services/construction' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/construction' #}href="/services/construction/"{# /if #}>&nbsp;</a>
				<a title="Системы видеонаблюдения" class="fourth{# if $DOCUMENT_SECTION == 'services/safety' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/safety' #}href="/services/safety/"{# /if #}>&nbsp;</a>
				<a title="Узлы теплоучета" class="fifth{# if $DOCUMENT_SECTION == 'services/node' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/node' #}href="/services/node/"{# /if #}>&nbsp;</a>
				{# if $DOCUMENT_SECTION == 'services' #}
                <div class="ball png" style="left: 111px; top: 88px;"></div>
				<div class="description" style="left: 110px; top: 114px;">{# $Objects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'services/montage' #}
                <div class="ball png" style="left: 85px; top: 120px;"></div>
				<div class="description png" style="left: 120px; top: 126px;">{# $Objects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'services/construction' #}
                <div class="ball png" style="left: 89px; top: 165px;"></div>
				<div class="description png" style="left: 120px; top: 132px;">{# $Objects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'services/safety' #}
                <div class="ball png" style="left: 125px; top: 194px;"></div>
                <div class="description png" style="left: 120px; top: 126px;">{# $Objects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'services/node' #}
				<div class="description png" style="left: 114px; top: 126px;">{# $Objects[0].type #}</div>
				<div class="ball png" style="left: 166px; top: 188px;"></div>
                {# /if #}
				
			</div>	
			
			<div class="box">
				<h1 style="font-size: 18px; margin-bottom: 10px;">Наша продукция:</h1>
				<div class="box-top png">&nbsp;</div>
				<div class="box-center png">
					<ul class="products">
						{# foreach from=$Categories item=Item #}
						<li><a href="/products/{# $Item.id #}/">{# $Item.name #}</a></li>
						{# /foreach #}
					</ul>	
				</div>
				<div class="box-bottom png">&nbsp;</div>
			</div>		
			<p>&nbsp;</p>
			<!--<em>Контактный телефон</em>
			<p class="phone">(495) 225-77-14</p>-->
		</div>

		
		<div class="basic" style="border: 0px solid orange; margin-left: 350px; padding-bottom: 20px;">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/services/">Услуги</a> / <span>{# $Objects[0].type #}</span></div>
			<h1 style="margin-left: 0px;">Услуги</h1>
			<h2 class="product" style="margin-left: 40px;">{# $Objects[0].type #}</h2>
			<div class="object-photo">
				{# foreach from=$Objects key=key item=Item #}
				<img src="{# $Item.photo #}" width="331" height="219" {# if $key>0 #}style="display: none;" {# /if #}/>
				{# /foreach #}
				<div class="above">
					<div class="left png" style="display: none;">&nbsp;</div>
					<div class="right png" style="display: none;">&nbsp;</div>
					<div class="comment png" style="display: none;">
						{# foreach from=$Objects key=key item=Item #}
						<div class="desc" {# if $key>0 #}style="display: none;"{# /if #}>{# $Item.name #}</div>
						{# /foreach #}
						{# if $DOCUMENT_SECTION == 'services' #}
						<a href="/projects/asu/">Посмотреть все объекты</a>
						{# elseif $DOCUMENT_SECTION == 'services/montage' #}
						<a href="/projects/montage/">Посмотреть все объекты</a>
						{# elseif $DOCUMENT_SECTION == 'services/safety' #}
						<a href="/projects/safety/">Посмотреть все объекты</a>
						{# elseif $DOCUMENT_SECTION == 'services/construction' #}
						<a href="/projects/construction/">Посмотреть все объекты</a>
						{# /if #}
					</div>
				</div>				
			</div>
			<div class="service-info">
				{# $DOCUMENT_CONTENT #}                
			</div>	
		</div>	
		
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}