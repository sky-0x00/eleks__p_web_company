<div class="useful-capt"></div>
			{# foreach from=$Advices item=Item #}
            <div class="event">
              	<p class="name">{# $Item.name #}</p>
                <a href="/advices/id/{# $Item.id_content #}/">{# $Item.content.short_annot #}</a>
            </div>
            {# /foreach #}
			{# if $Pages #}
			<div class="pages">Страница:
				<ul>
					{# if isset($PARAMS[0]) && ($PARAMS[0]>1) #}
					<li><a class="left" href="/advices/{# $PARAMS[0]-1 #}/"></a></li>
					{# /if #}
					{# foreach from=$Pages item=Item #}
					{# if (!isset($PARAMS[0]) && $Item == 1) || ($PARAMS[0] == $Item) #}
					<li>{# $Item #}</li> 
					{# else #}
					<li><a href="/advices/{# $Item #}/">{# $Item #}</a></li>
					{# /if #}
					{# /foreach #}
					{# if !isset($PARAMS[0]) || ($PARAMS[0] < $Count) #}
					<li><a class="right" href="/advices/{# if isset($PARAMS[0]) #}{# $PARAMS[0]+1 #}{# else #}2{# /if #}/"></a></li>
					{# /if #}
				</ul>
			</div>
			{# /if #}