<div id="results">
				<p>Вы искали: <strong>{# $smarty.get.text #}</strong></p>
				<p>&nbsp;</p>
				<p>Результаты поиска </p>
				{# if $SearchArray #}
				<ul class="search-list">
				{# foreach from=$SearchArray key=Key item=Item #}
					<li>
						<span style="font-weight: bold; width: 20px; display: inline-block;">{# $Key #}.</span>
						<a href="{# $Item.href #}">{# $Item.title #}</a>
					</li>
				{# /foreach #}
				</ul>
				{# /if #}
				<div class="pages">
				{# foreach name=pages from=$PageArray item=Item #}
					{# if ($smarty.get.page==$Item) or (!isset($smarty.get.page) and $Item==1) #}
					<span style="font-size: 10pt; font-family: Tahoma;">{# $Item #}</span>
					{# else #}
					<a href="?{# if $smarty.get.mode #}mode={# $smarty.get.mode #}&{# /if #}text={# $smarty.get.text #}&page={# $Item #}">{# $Item #}</a>
					{# /if #}
					{# if not $smarty.foreach.pages.last #}|{# /if #}
				{# /foreach #}					
				</div>
			</div>