{# foreach from=$SubStructureList item=SubStructureItem key=id #}
{# if $id % 2 #} {# assign var=style value="tr1" #} {# else #} {# assign var=style value="tr2" #} {# /if #}
<table class="table" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tr3">
			{# if $SubStructureItem.cntSubItems>0 #}
				<a id="StructureNode_{# $SubStructureItem.page_id #}"  class="tree_arrow_close" style="margin-left:20px;" onClick="StructureWindow({# $SubStructureItem.page_id #}, 'structure-sub-nodes_{# $SubStructureItem.page_id #}')">{# $SubStructureItem.name #}</a>
			{# else #}	
				<a class="margin_20">{# $SubStructureItem.name #}</a>
			{# /if #}
		</td>	
		<td class="tr3" style="width: 360px;">
			<div class="list-menu">
				<input type="hidden" name="id_page" value="{# $SubStructureItem.page_id #}" />
				<a href="{# $SESS_URL #}section=structure&action=setting&id={# $SubStructureItem.page_id #}">Настройки</a>
				<a class="under">Редактировать контент</a>
				<a class="structure-page-delete">Удалить</a>
			</div>
		</td>
	</tr>
</table>
<div id="structure-sub-nodes_{# $SubStructureItem.page_id #}" class="margin_20"></div>
{# /foreach #}