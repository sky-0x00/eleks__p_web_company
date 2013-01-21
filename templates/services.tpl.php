{# include file='include/header.tpl.php' #}
	
	<div style="position: absolute; top: -20000px;">
		{# foreach from=$Objects key=key item=Item #}
		<img src="{# $Item.photo #}" width="331" height="219" />
		{# /foreach #}
	</div>
	
	<div class="content">
		<div class="left-column">
			<h1 style="font-size: 18px">Направления работы</h1>
			<div class="circle png">
				<a title="Автоматизированные системы" class="first{# if $DOCUMENT_SECTION == 'services' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services' #}href="/services/"{# /if #}>&nbsp;</a>
				<a title="Электромонтажные работы" class="second{# if $DOCUMENT_SECTION == 'services/montage' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/montage' #}href="/services/montage/"{# /if #}>&nbsp;</a>
				<a title="Строительные работы" class="third{# if $DOCUMENT_SECTION == 'services/construction' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/construction' #}href="/services/construction/"{# /if #}>&nbsp;</a>
				<a title="Системы безопасности" class="fourth{# if $DOCUMENT_SECTION == 'services/safety' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/safety' #}href="/services/safety/"{# /if #}>&nbsp;</a>
				<a title="Узлы теплоучета" class="fifth{# if $DOCUMENT_SECTION == 'services/node' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'services/node' #}href="/services/node/"{# /if #}>&nbsp;</a>
				{# if $DOCUMENT_SECTION == 'services' #}
				<div class="ball png"></div>
				{# elseif $DOCUMENT_SECTION == 'services/montage' #}
				<div class="ball png" style="left: 85px; top: 120px;"></div>
				{# elseif $DOCUMENT_SECTION == 'services/construction' #}
				<div class="ball png" style="left: 89px; top: 165px;"></div>
				{# elseif $DOCUMENT_SECTION == 'services/safety' #}
				<div class="ball png" style="left: 125px; top: 194px;"></div>
				{# /if #}
				<div class="description">{# $Objects[0].type #}</div>
			</div>	
			
			<h1 style="font-size: 18px">Продукция</h1>			
			<div class="box">
				<p>У нас вы можете заказать оборудование</p>
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
			<p>Представляемое оборудование поставляется известными мировыми лидерами</p>
			<p>&nbsp;</p>
			<!--<em>Контактный телефон</em>
			<p class="phone">(495) 225-77-14</p>-->
		</div>

		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <span>Услуги</span></div>
			<h1>Услуги</h1>
			<h2 class="product">{# $Objects[0].type #}</h2>
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