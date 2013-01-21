<div class="useful">
            		<div class="useful-capt"></div>
                	<ul>
						{# foreach from=$Advices item=Item #}
                		<li><a href="/advices/id/{# $Item.id_content #}/">{# $Item.name #}</a></li>
                		{# /foreach #}
                	</ul>
					<a href="/advices/" style="color: #025C79; margin-left: 23px;">Посмотреть другие</a>
            	</div>