{# include file='include/header.tpl.php' #}
	
	<div class="content">
			
		<div class="basic">
			<h1>Карта сайта</h1>
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
		
	</div>	
	
</div>
	
{# include file='include/footer.tpl.php' #}