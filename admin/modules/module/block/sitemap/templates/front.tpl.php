<div>
					<h4 style="margin-left:0">Карта сайта</h4>
					<ul>
						{# foreach from=$MainMenu item=Item #}
						<li>
							<a href="/{# $Item.url #}/">{# $Item.name #}</a>
							{# if $Item.children #}
							<ul style="margin-left: 30px;">
								{# foreach from=$Item.children item=item #}
								<li><a href="/{# $Item.url #}/{# $item.url #}/">{# $item.name #}</a></li>
								{# /foreach #}
							</ul>
							{# /if #}
						</li>
						{# /foreach #}
					</ul>
				</div>