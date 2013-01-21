{# include file='include/header.tpl.php' #}
	
	<div class="content">
			
		<div class="basic">
			<h1>Результаты поиска</h1>
			<p>Вы искали: <strong>&laquo;{# $smarty.get.text #}&raquo;</strong></p>
			<p>&nbsp;</p>
			
			{# if $SearchArray #}
			<p>По вашему запросу были найдены следующие страницы:</p>
			<br>
			<ul class="search-list">
			{# foreach from=$SearchArray key=Key item=Item #}
				<li>
					<span style="font-weight: bold; width: 20px; display: inline-block;">{# $Key #}.</span>
					<a href="{# $Item.href #}">{# $Item.title #}</a>
				</li>
			{# /foreach #}
			</ul>
			{# else #}
			<p>К сожалению, по Вашему запросу ничего не найдено.</p>
			{# /if #}
			<div class="pages">
			{# foreach name=pages from=$PageArray item=Item #}
				{# if ($smarty.get.page==$Item) or (!isset($smarty.get.page) and $Item==1) #}
				<span style="font-size: 10pt; font-family: Tahoma;">{# $Item #}</span>
				{# else #}
				<a href="?{# if $smarty.get.mode #}mode={# $smarty.get.mode #}&{# /if #}text={# $smarty.get.text #}&page={# $Item #}">{# $Item #}</a>
				{# /if #}
				{# if not $smarty.foreach.pages.last #}|{# /if #}
			{# /foreach #}					
			</div>
		
		</div>
		
	</div>	
	
</div>
	
{# include file='include/footer.tpl.php' #}