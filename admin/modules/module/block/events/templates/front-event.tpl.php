<div class="events">
                <div class="event">
                	<p class="date">{# $Event.date|month #}</p>
                    <p class="name">{# $Event.title #}</p>
					<p>&nbsp;</p>
                    {# $Event.text #}
                </div>
				<div class="album">
					<ul>
						{# foreach from=$Event.photos item=Item #}
						<li class="photo">
							<a class="highslide" href="{# $Item.photo #}" onclick="return hs.expand(this, {  })">
								<img src="{# $Item.thumb #}" alt="" />
							</a>
						</li>
						{# /foreach #}
					<ul>	
				</div>
				<div class="navigate">
					<div class="all-events"><a href="/events/">Все мероприятия</a></div>
					{# if $Prev #}<div class="previous"><a href="/events/{# $Prev.year #}/{# $Prev.id_event #}/">Предыдущее мероприятие</a></div>{# /if #}
					{# if $Next #}<div class="next"><a href="/events/{# $Next.year #}/{# $Next.id_event #}/">Следующее мероприятие</a></div>{# /if #}
				</div>
			</div>