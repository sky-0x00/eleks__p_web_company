{# include file='include/header.tpl.php' #}
	  
	<div class="content" style="border: 1px none gray; margin-top: -40px;">
		
		<div class="regions png" style="display: none;"></div>
		
		<div class="left-column" style="border: 1px none yellow; margin-top: 30px; margin-left: 30px; position: absolute;">
			<h1 style="font-size: 18px;">Направления работ:</h1>
			<div class="circle png">
				<a class="first{# if $DOCUMENT_SECTION == 'projects/asu' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/asu' #}href="/projects/asu/"{# /if #}>&nbsp;</a>
				<a class="second{# if $DOCUMENT_SECTION == 'projects/montage' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/montage' #}href="/projects/montage/"{# /if #}>&nbsp;</a>
				<a class="fourth{# if $DOCUMENT_SECTION == 'projects/safety' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/safety' #}href="/projects/safety/"{# /if #}>&nbsp;</a>
				<a class="third{# if $DOCUMENT_SECTION == 'projects/construction' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/construction' #}href="/projects/construction/"{# /if #}>&nbsp;</a>
				<a class="fifth{# if $DOCUMENT_SECTION == 'projects/node' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/node' #}href="/projects/node/"{# /if #}>&nbsp;</a>
				{# if $DOCUMENT_SECTION == 'projects/asu' #}
				<div class="ball png" style="left: 111px; top: 88px;"></div>
                <div class="description png" style="left: 110px; top: 114px;">{# $projects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'projects/montage' #}
				<div class="ball png" style="left: 85px; top: 120px;"></div>
                <div class="description png" style="left: 120px; top: 126px;">{# $projects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'projects/construction' #}
				<div class="ball png" style="left: 89px; top: 165px;"></div>
                <div class="description png" style="left: 120px; top: 132px;">{# $projects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'projects/safety' #}
				<div class="ball png" style="left: 125px; top: 194px;"></div>
                <div class="description png" style="left: 120px; top: 126px;">{# $projects[0].type #}</div>
				{# elseif $DOCUMENT_SECTION == 'projects/node' #}
				<div class="ball png" style="left: 166px; top: 188px;"></div>
                <div class="description png" style="left: 114px; top: 126px;">{# $projects[0].type #}</div>
				{# /if #}
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

		
		<div class="basic" style="border: 1px none orange;  margin-top: -25px; position: relative;">
			<div id="breadcrumbs"><a href="/">Главная</a> / <a href="/projects/asu/">Проекты</a> / <span>{# $projects[0].type #}</span></div>
			<h1 style="margin-top: 20px;">Проекты</h1>
			<h2 class="product">{# $projects[0].type #}</h2>
			{# foreach from=$projects key=key item=Item #}
			<div class="project" style="border: 1px none red; margin-left: {# if $key==0 #}100px; margin-top: 10px; {# elseif $key==1 #}80px;{# else #}0px; margin-bottom: 20px; {# /if #}">
				{# if $key!=1 #}
				<div class="inform">
					<a class="project-name" href="/projects/{# $Item.id_object #}/">{# $Item.name #}</a>
					<p>{# $Item.short_description #}</p>
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
					<p>{# $Item.short_description #}</p>
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