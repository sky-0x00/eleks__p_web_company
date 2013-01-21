<div class="leave-comment">
					<a id="show-comment-form">Оставить отзыв</a>
					<!--[if IE 6]><div class="comment-bg"></div><![endif]-->
					<div id="comment-form">
						<div class="close"></div>
						<form action="">
							<input type="text" name="name" id="comment-name" value="Ваше имя" />
							<input type="text" name="email" id="comment-email" value="Электронная почта" />
							<select id="comment-cat">
								{# foreach from=$Cats item=Item #}
								<option value="{# $Item.id_cat #}">{# $Item.name #}</option>
								{# /foreach #}
							</select>
							<textarea rows="" cols="" id="comment-text">Текст отзыва</textarea>
							<div align="right">
								<input class="send" type="submit" id="comment-send" value="Отправить" />
							</div>	
						</form>	
					</div>
				</div>
				<div class="all">
					<h3>Все отзывы</h3>
					<ul>
						<li>
							{# if isset($PARAMS[0]) && ($PARAMS[0]>0)  #}
							<a href="/comments/">Все отзывы</a></li>
							{# else #}Все отзывы{# /if #}
						</li>
						{# foreach from=$Cats item=Item #}
						<li>
							{# if (!$PARAMS[0]) || ($PARAMS[0]!=$Item.id_cat)  #}<a href="/comments/{# $Item.id_cat #}/">{# $Item.name #}</a>
							{# else #}{# $Item.name #}{# /if #}
						</li>
						{# /foreach #}
					</ul>
					{# foreach from=$Messages item=Item #}
					<div class="comm-block">
						<div class="item">
							<p class="person">{# $Item.name #}</p>
							<p>{# $Item.text #}</p>
						</div>
					</div>	
					{# /foreach #}
					{# if $Pages #}
					<div class="pages">Страница:
						<ul>
							{# if isset($PARAMS[1]) && ($PARAMS[1]>1) #}
							<li><a class="left" href="/comments/{# $PARAMS[0] #}/{# $PARAMS[1]-1 #}/"></a></li>
							{# /if #}
							{# foreach from=$Pages item=Item #}
							{# if (!isset($PARAMS[1]) && $Item == 1) || ($PARAMS[1] == $Item) #}
							<li>{# $Item #}</li> 
							{# else #}
							<li><a href="/comments/{# if isset($PARAMS[0]) #}{# $PARAMS[0] #}{# else #}0{# /if #}/{# $Item #}/">{# $Item #}</a></li>
							{# /if #}
							{# /foreach #}
							{# if !isset($PARAMS[1]) || ($PARAMS[1] < $Count) #}
							<li><a class="right" href="/comments/{# if isset($PARAMS[0]) #}{# $PARAMS[0] #}{# else #}0{# /if #}/{# if isset($PARAMS[1]) #}{# $PARAMS[1]+1 #}{# else #}2{# /if #}/"></a></li>
							{# /if #}
						</ul>
					</div>
					{# /if #}
				</div>