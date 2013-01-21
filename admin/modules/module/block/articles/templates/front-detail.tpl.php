<div class="left-column">
			<h3 class="news">Другие статьи</h3>
			{# if $articles #}
			{# foreach from=$articles item=Item #}
			<div class="date no-float">{# $Item.date|month #}</div>
			<div class="news-text"><a href="/articles/{# $Item.year #}/{# $Item.month #}/{# $Item.id_article #}/">{# $Item.title #}</a></div>	
			{# /foreach #}
			{# /if #}
		</div>
		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/articles/">Статьи</a> / <a href="/articles/{# $Article.year #}/">{# $Article.year #}</a> / <span>{# $Article.title #}</span></div>
			<h1>Статьи</h1>
			<div class="date no-float">{# $Article.date|month #}</div>
			<div class="topic">{# $Article.title #}</div>
			<div class="news-text">{# $Article.text #}</div>

			<div class="project-navigation">
				{# if $Prev #}
				<a class="previous" href="/articles/{# $Prev.year #}/{# $Prev.month #}/{# $Prev.id_article #}/">Предыдущая статья</a>
				{# /if #}
				<a class="all" href="/articles/">Все статьи</a>
				{# if $Next #}
				<a class="next" href="/articles/{# $Next.year #}/{# $Next.month #}/{# $Next.id_article #}/">Следующая статья</a>
				{# /if #}
			</div>	

		</div>