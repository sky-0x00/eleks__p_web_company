<div id="right">
			<div class="book"></div>
			<div class="menu">
				{# foreach from=$Cats item=Items key=Key #}
				<div class="column">
					<ul>
						{# foreach from=$Items item=Item key=key #}
						{# if ($PARAMS[0] && ($Item.value==$PARAMS[0])) || (!$PARAMS[0] && ($Key==0) && ($key==0)) #}
						<li>{# $Item.caption #}</li>
						{# else #}
						<li><a href="/menu/{# $Item.value #}/">{# $Item.caption #}</a></li>
						{# /if #}
						{# /foreach #}
					</ul>
				</div>
				{# /foreach #}				
			</div>
			<div class="menu-list">
				<h2 style="margin-bottom: 15px">{# $CatName #}</h2>
				{# foreach from=$_Items.items item=Item #}
				<table class="dish" cellspacing="0" cellpadding="0" border="0">
					 <tr>
						<td colspan="3">
							<input type="hidden" name="id_item" value="{# $Item.id_item #}" />
							{# if $Item.recipe > 0 #}
							<a class="menu-item-name">{# $Item.name #}</a>
							{# else #}
							<span>{# $Item.name #}</span>
							{# /if #}
						</td>
					 </tr>
					 <tr>
						<td width="370px" style="padding-right: 15px"><em>{# $Item.annot #}</em></td>
						<td align="right" width="90px">{# $Item.portion #}</td>
						<td align="right" width="80px">{# $Item.price #} руб.</td>
					 </tr>
				</table>
				{# /foreach #}
				{# foreach from=$_Items.cats item=Cat #}
				<h4>{# $Cat.name #}</h4>
				{# foreach from=$Cat.items item=Item #}
				<table class="dish" cellspacing="0" cellpadding="0" border="0">
					 <tr>
						<td colspan="3">
							<input type="hidden" name="id_item" value="{# $Item.id_item #}" />
							{# if $Item.recipe > 0 #}
							<a class="menu-item-name">{# $Item.name #}</a>
							{# else #}
							<span>{# $Item.name #}</span>
							{# /if #}
						</td>
					 </tr>
					 <tr>
						<td width="370px" style="padding-right: 15px"><em>{# $Item.annot #}</em></td>
						<td align="right" width="90px">{# $Item.portion #}</td>
						<td align="right" width="80px">{# $Item.price #} руб.</td>
					 </tr>
				</table>
				{# /foreach #}
				{# /foreach #}				
			</div>
        </div>
		<div id="recipe-window" class="big-form">
			<!--[if IE 6]><div class="big-form-ie"></div><![endif]-->
			<a class="close">ЗАКРЫТЬ</a>
			<img src="" alt="" />
			<div class="dish-desc">
				<p class="name"></p>
				<div class="dish-text"></div>
			</div>
			<!--<a class="print">Распечатать</a>-->
		</div>