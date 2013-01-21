{# include file='include/header.tpl.php' #}
	
	<div class="content">
		
		<!--<div class="product-order">
			<div class="cross"></div>			
			<form>
				<h2 style="font-size: 18px">Форма заявки</h2>
				<p>Ваше имя</p>
				<input type="text" />
				<p>Контактная информация <em>(телефон, e-mail)</em></p>
				<input type="text" />
				<p>Комментарии</p>
				<textarea rows="" cols=""></textarea>
				<div align="right"><button>отправить</button></div>
			</form>
		</div>-->
			
		<div class="left-column">
			<div class="box" style="margin-top: 56px">
				<div class="box-top png">&nbsp;</div>
				<div class="box-center png">
					<ul class="products">
						{# foreach from=$Categories key=key item=Item #}
						{# if $Item.id==$cat_id #}
						<li class="active">{# $Item.name #}</li>
						{# else #}
						<li><a href="/products/{# $Item.id #}/">{# $Item.name #}</a></li>
						{# /if #}
						{# /foreach #}
					</ul>	
				</div>
				<div class="box-bottom png">&nbsp;</div>
			</div>	
			<div class="price png">
				<form method="post" action="">
					<input type="hidden" name="getexcel" value="1" />
				</form>
				<span class="png"><a>Скачать прайс-лист</a></span>
			</div>
		</div>
		
		<div class="product-photo">
			<div class="cross" title="Закрыть"></div>
			<div class="title"></div>
			<div class="big-image"></div>			
			<div class="product-desc" style="clear: both; margin-left: 10px; margin-right: 10px;"></div>
		</div>	
		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/products/">Продукция</a> / <span>{# $cat_name #}</span></div>
			<h1>Продукция</h1>
			<h2 class="product">{# $cat_name #}</h2>
			{# foreach from=$Items item=Item #}
			<table class="product-details" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="product-name" colspan="2">
						<input type="hidden" name="id_item" value="{# $Item.id_item #}" />						
						<input type="hidden" name="image" value="{# $Item.image #}" />
						<div style="display: none;">{# $Item.description #}</div>
						<a>{# $Item.name #}</a>
					</td>
				</tr>
				{# foreach from=$Item.properties item=item #}
				{# if $item.value #}
				<tr>
					<td class="char">{# $item.title #}:</td>
					<td class="value">{# $item.value #}</td>
				</tr>
				{# /if #}
				{# /foreach #}				
			</table>	
			{# /foreach #}	
			
			{# if $pages>1 #}
			<ul class="nav-pages">
				<li class="first"><a class="left"></a></li>
				{# section name=p loop=$pages+1 start=1 step=1 #}
				{# if $smarty.section.p.index==$page #}
				<li class="current">{# $smarty.section.p.index #}</li>
				{# else #}
				<li><a href="/products/{# $cat_id #}/{# $smarty.section.p.index #}/">{# $smarty.section.p.index #}</a></li>
				{# /if #}
				{# /section #}
				<li><a class="right"></a></li>
			</ul>
			{# /if #}
									
		</div>	
		
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}