<div class="left-column">
			<h3 class="news">Другие события</h3>
			{# if $articles #}
			{# foreach from=$articles item=Item #}
			<div class="date no-float">{# $Item.date|month #}</div>
			<div class="news-text"><a href="/news/{# $Item.year #}/{# $Item.month #}/{# $Item.id_article #}/">{# $Item.title #}</a></div>	
			{# /foreach #}
			{# /if #}
		</div>
		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/news/">События</a> / <a href="/news/{# $Article.year #}/">{# $Article.year #}</a> / <span>{# $Article.title #}</span></div>
			<h1>События</h1>
			<div class="date no-float">{# $Article.date|month #}</div>
			<div class="topic">{# $Article.title #}</div>
			<div class="news-text">{# $Article.text #}</div>

			<div class="project-navigation">
				{# if $Prev #}
				<a class="previous" href="/news/{# $Prev.year #}/{# $Prev.month #}/{# $Prev.id_article #}/">Предыдущее событие</a>
				{# /if #}
				<a class="all" href="/news/">Все события</a>
				{# if $Next #}
				<a class="next" href="/news/{# $Next.year #}/{# $Next.month #}/{# $Next.id_article #}/">Следующее событие</a>
				{# /if #}
			</div>	

		</div>