			{# foreach from=$Events item=Item #}
				<div class="event">
                	<p class="date">{# $Item.date|month #}</p>
                    <p class="name">{# $Item.title #}</p>
                    <a href="/events/{# $Item.year #}/{# $Item.id_event #}/">{# $Item.annot #}</a>
                </div>
			{# /foreach #}