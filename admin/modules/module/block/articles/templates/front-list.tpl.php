<div class="left-column" style="width: 180px">
			<h3 class="news">Архив статей</h3>
			<ul class="archive">
				{# foreach from=$months item=Item #}
				{# if $Item.active && (!isset($month) || ($month != $Item.num)) #}
				<li><a href="/articles/{# $year #}/{# $Item.num #}/">/{# $Item.name #}</a></li>
				{# elseif (isset($month) && ($month == $Item.num)) #}
				<li class="active">/{# $Item.name #}</li>
				{# /if #}
				{# /foreach #}
			</ul>	
		</div>
		
		<div class="basic" style="margin-left: 180px">
			<div class="margin-left">
				<div id="breadcrumbs"><a href="/">Главная</a> / <span>Статьи</span></div>
				<h1>Статьи</h1>
				<div class="year-nav">
					<ul>
						{# foreach from=$years item=Item key=Key #}
						{# if (isset($year) && ($year != $Item)) #}
						<li><a href="/articles/{# $Item #}/">/{# $Item #}</a></li>
						{# else #}
						<li>/{# $Item #}</li>
						{# /if #}
						{# /foreach #}						
					</ul>
				</div>
			</div>
			
			{# section name=ext loop=$articles step=$pager #}
			<div class="news-page" {# if ($smarty.section.ext.index != 0) #} style="display: none;"{# /if #}>  
				{# section name=int loop=$articles start=$smarty.section.ext.index step=1 max=$pager #}
				<div class="news-block">
					<div class="date">{# $articles[int].date|month #}</div>
					<div class="news-text"><a href="/articles/{# $articles[int].year #}/{# $articles[int].month #}/{# $articles[int].id_article #}/">{# $articles[int].title #}</a></div>
					<div class="news-text">{# $articles[int].annot #}</div>
				</div> 
				{# /section #}
			</div>
			{# /section #}
			
			{# if $pages>1 #}
			<ul class="nav-pages margin-left">
				<li class="first"><a class="left"></a></li>
				<li class="current">1</li>
				{# section name=pages loop=$pages start=1 #}
				<li><a>{# $smarty.section.pages.index+1 #}</a></li>
				{# /section #}
				<li><a class="right"></a></li>
			</ul>
			{# /if #}
			
		</div>