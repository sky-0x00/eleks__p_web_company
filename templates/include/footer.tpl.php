{# if $DOCUMENT_SECTION=="" #}
<div class="footer-index">
	<div class="contents">
		<div class="caption">События<a href="/news/">Все события</a></div>
		{# foreach from=$News item=Item #}
		<div class="column">
			<div class="date no-float">{# $Item.date|date_format:"%d.%m.%Y" #}</div>
			<div class="news-name"><a href="/news/{# $Item.year #}/{# $Item.month #}/{# $Item.id_article #}/">{# $Item.title #}</a></div>
			<div class="news-text">{# $Item.annot|truncate:80:"...":false #}</div>
		</div>
		{# /foreach #}
		<div class="search">
			<form method="get" action="/search/">
				<input class="text" type="text" name="text" value="введите текст" />
				<input class="submit" type="submit" value="поиск" />
			</form>
		</div>
		<div class="copyright">
			<div class="year">&copy;&nbsp;ООО&nbsp;&laquo;Группа компаний ЭЛЕКС&raquo;, 2012</div>
		</div>	
	</div>
</div>
{# else #}
    </div></td></tr>
        <tr><td class="footer">
            	<div class="contents">
            		<div class="copyright">
            			<div class="year">&copy;&nbsp;ООО&nbsp;&laquo;Группа компаний ЭЛЕКС&raquo;, 2012</div>
            		</div>	
            	</div>
{# /if #}       
        </td></tr></table>
    </body>
</html>