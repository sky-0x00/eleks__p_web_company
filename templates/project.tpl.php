{# include file='include/header.tpl.php' #}
	
	<div class="content">
		
		<div class="left-column">
			<h1 style="font-size: 18px">Направления работы</h1>
			<div class="circle png">
				<a class="first{# if $Project.alias == 'asu' #}-active{# /if #} png" href="/projects/asu/">&nbsp;</a>
				<a class="second{# if $Project.alias == 'montage' #}-active{# /if #} png" href="/projects/montage/">&nbsp;</a>
				<a class="third{# if $Project.alias == 'construction' #}-active{# /if #} png" href="/projects/construction/">&nbsp;</a>
				<a class="fourth{# if $Project.alias == 'safety' #}-active{# /if #} png" href="/projects/safety/">&nbsp;</a>
				<a class="fifth{# if $DOCUMENT_SECTION == 'projects/node' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/node' #}href="/projects/node/"{# /if #}>&nbsp;</a>				
				{# if $Project.alias == 'asu' #}
				<div class="ball png"></div>
				{# elseif $Project.alias == 'montage' #}
				<div class="ball png" style="left: 85px; top: 120px;"></div>
				{# elseif $Project.alias == 'construction' #}
				<div class="ball png" style="left: 89px; top: 165px;"></div>
				{# elseif $Project.alias == 'safety' #}
				<div class="ball png" style="left: 125px; top: 194px;"></div>
				{# elseif $DOCUMENT_SECTION == 'projects/node' #}
				<!--<div class="ball png" style="left: 170x; top: 194px;"></div>				-->
				{# /if #}
				<div class="description">{# $Project.type #}</div>
			</div>	
				
		</div>

		
		<div class="basic">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/projects/asu/">Проекты</a> / <span>{# $Project.type #}</span></div>
			<h1>Проекты</h1>
			<h2 class="product">{# $Project.name #}</h2>

			<div class="project-gallery png">
				
				{# if $photo_count>0 #}
				<div class="photo-number">фото <span>1</span> из {# $photo_count #}</div>
				{# /if #}
				
				<div class="full-image">
					<img src="{# $Project.photos[0].photo #}" alt="{# $Project.name #}" />
				</div>
				<div class="desc">{# $Project.short_description #}</div>
				<div class="slider">
					<ul>
						{# foreach from=$Project.photos key=key item=Item #}
						<li>
							<input type="hidden" name="index" value="{# $key+1 #}" />
							<input type="hidden" name="photo" value="{# $Item.photo #}" />
							<img src="{# $Item.thumb #}" alt="{# $Project.name #}" />
						</li>
						{# /foreach #}
					</ul>
				</div>
				<div class="slider-wrap" style="top: -20px; left: 58px; width: 478px;"></div>
			</div>	
	
			<div class="project-description">
				{# $Project.description #}
			</div>	
			
			<div class="project-navigation">
				{# if ($Project.prev) #}
				<a class="previous" href="/projects/{# $Project.prev #}/">Предыдущий проект</a>
				{# /if #}
				<a class="all" href="/projects/{# $Project.alias #}/">Все проекты</a>
				{# if ($Project.next) #}
				<a class="next" href="/projects/{# $Project.next #}/">Следующий проект</a>
				{# /if #}
			</div>	
		</div>	
		
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}