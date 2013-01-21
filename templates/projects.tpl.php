{# include file='include/header.tpl.php' #}
	  
	<div class="content">
		
		<div class="regions png" style="display: none;"></div>
		
		<div class="left-column">
			<h1 style="font-size: 18px;">Направления работы</h1>
			<div class="circle png">
				<a class="first{# if $DOCUMENT_SECTION == 'projects/asu' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/asu' #}href="/projects/asu/"{# /if #}>&nbsp;</a>
				<a class="second{# if $DOCUMENT_SECTION == 'projects/montage' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/montage' #}href="/projects/montage/"{# /if #}>&nbsp;</a>
				<a class="fourth{# if $DOCUMENT_SECTION == 'projects/safety' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/safety' #}href="/projects/safety/"{# /if #}>&nbsp;</a>
				<a class="third{# if $DOCUMENT_SECTION == 'projects/construction' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/construction' #}href="/projects/construction/"{# /if #}>&nbsp;</a>
				<a class="fifth{# if $DOCUMENT_SECTION == 'projects/node' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/node' #}href="/projects/node/"{# /if #}>&nbsp;</a>
				{# if $DOCUMENT_SECTION == 'projects/asu' #}
				<div class="ball png"></div>
				{# elseif $DOCUMENT_SECTION == 'projects/montage' #}
				<div class="ball png" style="left: 85px; top: 120px;"></div>
				{# elseif $DOCUMENT_SECTION == 'projects/construction' #}
				<div class="ball png" style="left: 89px; top: 165px;"></div>
				{# elseif $DOCUMENT_SECTION == 'projects/safety' #}
				<div class="ball png" style="left: 125px; top: 194px;"></div>
				{# elseif $DOCUMENT_SECTION == 'projects/node' #}
				<!--<div class="ball png" style="left: 170x; top: 194px;"></div>-->
				{# /if #}
				<div class="description png">{# $projects[0].type #}</div>
			</div>	
			
			<div class="key-projects">
			<!--	<p>Ключевые проекты <a class="dotted">в регионах</a></p> -->
				<p>Ключевые проекты в регионах:</p>
				<ul>
					{# foreach from=$primary_projects item=Item #}
					<li>
						<a href="/projects/{# $Item.id_object #}/">{# $Item.name #}</a>
						<span>{# $Item.town #}</span>
					</li>
					{# /foreach #}
				</ul>	
			</div>	
			
		</div>

		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/projects/asu/">Проекты</a> / <span>{# $projects[0].type #}</span></div>
			<h1>Проекты</h1>
			<h2 class="product">{# $projects[0].type #}</h2>
			{# foreach from=$projects key=key item=Item #}
			<div class="project">
				{# if $key!=1 #}
				<div class="inform">
					<a class="project-name" href="/projects/{# $Item.id_object #}/">{# $Item.name #}</a>
					{# $Item.short_description #}
				</div>
				{# /if #}
				<div class="image">
					<a href="/projects/{# $Item.id_object #}/">
						<img class="png" src="{# $Item.picture #}" alt="{# $Item.name #}" />
					</a>
				</div>
				{# if $key==1 #}
				<div class="inform">
					<a class="project-name" href="/projects/{# $Item.id_object #}/">{# $Item.name #}</a>
					{# $Item.short_description #}
				</div>
				{# /if #}
			</div>
			{# /foreach #}			
			
			{# if $pages>1 #}
			<ul class="nav-pages margin-bottom">
				<li class="first"><a class="left"></a></li>
				{# section name=p loop=$pages+1 start=1 step=1 #}
				{# if $smarty.section.p.index==$page #}
				<li class="current">{# $smarty.section.p.index #}</li>
				{# else #}
				<li><a href="/{# $DOCUMENT_SECTION #}/{# $smarty.section.p.index #}/">{# $smarty.section.p.index #}</a></li>
				{# /if #}
				{# /section #}
				<li><a class="right"></a></li>
			</ul>
			{# /if #}
		</div>	
		
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}