<div class="chooser-panel">
	<ul>
		<li><a href="{#$SESS_URL#}section=users&action=create">Добавить пользователя</a></li>
	</ul>
</div>
<br class="clear">


<table class="users-list" cellpadding="0" cellspacing="0">
<tbody>	
	<tr>
		<th></th>
		<th>Информация</th>
		<th>Комментарий</th>
		<th></th>
	</tr>
	<tr class="spacer"><td></td><td></td><td></td><td></td></tr>
{# foreach from=$UsersArray item=Item key=id #}	
{# if $id % 2 #} {# assign var=style value="item-odd" #} {# else #} {# assign var=style value="item" #} {# /if #}
	<tr class="{# $style #}" width="100%">
		<td class="logo">
			<img src=""> 
		</td>
		<td class="info">
			<input type="hidden" name="id_user" value="{# $Item.user_id #}" />
			<div><a class="name" href="{# $SESS_URL #}section=users&action=edit&id={# $Item.user_id #}">{# $Item.name #}</a></div>
			<div class="group">администратор</div>
			<div class="mail"><a class="under">{# $Item.email #}</a></div>
			<div class="phone">{# $Item.phone #}</div>
			<div class="icq">{# $Item.icq #}</div>
		</td>
		<td class="comment">
			<div>{# $Item.comment #}</div>
		</td>
		<td class="action">
			<div class="action-panel">
				<button class="edit"></button>
				<button class="drop"></button>
			</div>
		</td>
	</tr>
{# /foreach #}
</tbody>

</div>