{# include file='include/header.tpl.php' #}
	
	<div class="content" style="margin-top: -20px; padding-bottom: 0px; border: 0px solid gray;">
		
		<div class="left-column" style="margin-top: 30px; margin-left: 30px; position: absolute; width: auto; border: 0px solid orange;">
			<h1 style="font-size: 18px">Направления работ:</h1>
			<div class="circle png">
				<a class="first{# if $Project.alias == 'asu' #}-active{# /if #} png" href="/projects/asu/">&nbsp;</a>
				<a class="second{# if $Project.alias == 'montage' #}-active{# /if #} png" href="/projects/montage/">&nbsp;</a>
				<a class="third{# if $Project.alias == 'construction' #}-active{# /if #} png" href="/projects/construction/">&nbsp;</a>
				<a class="fourth{# if $Project.alias == 'safety' #}-active{# /if #} png" href="/projects/safety/">&nbsp;</a>
				<a class="fifth{# if $DOCUMENT_SECTION == 'projects/node' #}-active{# /if #} png" {# if $DOCUMENT_SECTION != 'projects/node' #}href="/projects/node/"{# /if #}>&nbsp;</a>				
				
                <!--{# if $Project.alias == 'asu' #}
				<div class="ball png"></div>
				{# elseif $Project.alias == 'montage' #}
				<div class="ball png" style="left: 85px; top: 120px;"></div>
				{# elseif $Project.alias == 'construction' #}
				<div class="ball png" style="left: 89px; top: 165px;"></div>
				{# elseif $Project.alias == 'safety' #}
				<div class="ball png" style="left: 125px; top: 194px;"></div>
				{# elseif $DOCUMENT_SECTION == 'projects/node' #}
				{# /if #}
				<div class="description">{# $Project.type #}</div>-->
                
                {# if $Project.alias == 'asu' #}
				<div class="ball png" style="left: 111px; top: 88px;"></div>
                <div class="description png" style="left: 110px; top: 114px;">{# $Project.type #}</div>
				{# elseif $Project.alias == 'montage' #}
				<div class="ball png" style="left: 85px; top: 120px;"></div>
                <div class="description png" style="left: 120px; top: 126px;">{# $Project.type #}</div>
				{# elseif $Project.alias == 'construction' #}
				<div class="ball png" style="left: 89px; top: 165px;"></div>
                <div class="description png" style="left: 120px; top: 132px;">{# $Project.type #}</div>
				{# elseif $Project.alias == 'safety' #}
				<div class="ball png" style="left: 125px; top: 194px;"></div>
                <div class="description png" style="left: 120px; top: 126px;">{# $Project.type #}</div>
				{# elseif $Project.alias == 'node' #}
				<div class="ball png" style="left: 166px; top: 188px;"></div>
                <div class="description png" style="left: 114px; top: 126px;">{# $Project.type #}</div>
				{# /if #}
                
			</div>	
				
		</div>

		
		<div class="basic" style="border: 0px solid orange;  margin-top: 0px; margin-left: 300px; position: relative;">
			<div id="breadcrumbs"><a href="/">На главную</a> / <a href="/projects/asu/">Проекты</a> / <span>{# $Project.type #}</span></div>
			<h1 style="text-indent: -16px;">Проекты</h1>
			<h2 class="product" style="text-indent: 40px; margin-bottom: 10px;">{# $Project.name #}</h2>

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
	
			<div class="project-description" style="margin-top: -20px;">
				{# $Project.description #}
			</div>
			
			<div class="project-navigation">
				<span class="previous">
                    {# if ($Project.prev) #}<a href="/projects/{# $Project.prev #}/">{# /if #}
                    Предыдущий проект
                    {# if ($Project.prev) #}</a>{# /if #}
                </span>
                <span class="all"><a href="/projects/{# $Project.alias #}/">Все проекты</a></span>
                <span class="next">{# if ($Project.next) #}<a href="/projects/{# $Project.next #}/">{# /if #}
                    Следующий проект
                    {# if ($Project.next) #}</a>{# /if #}				
                </span>
                
			</div>	
		</div>	
		
	</div>	
	
	
	
	
</div>
	
{# include file='include/footer.tpl.php' #}