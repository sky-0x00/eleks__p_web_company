{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}
{# literal #}
<script type="text/javascript" src="/admin/lib/calendar/calendar.js"></script>
<script type="text/javascript" src="/admin/lib/calendar/calendar-setup.js"></script>
<script type="text/javascript" src="/admin/lib/calendar/lang/calendar-rus.js"></script>
<style type="text/css">@import url("/admin/lib/calendar/styles/calendar-green.css"); </style>
{# /literal #}
<tr>
		<td id="td_body" align="center">
		
		<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		
			<tr>
				<td class="main-menu">
				{# include file = "$root/admin/modules/cms/templates/left_menu.tpl.php"  #}
				</td>
				
				<td class="vertical">
				
					<h3>Статистика посещаемости</h3>
					
					<ul class="drop-menu">
						<div onmouseover="ShowLayer('drop_1')" onmouseout="HideLayer('drop_1')">
						<a class="link" >Трафик</a>
					
							<div id="drop_1">
								<ul class="drop-menu-show">
									<a class="drop-menu-a" href="{# $SESS_URL #}section=statistic&filter={#$smarty.get.filter#}&action=traffic">посещаемость</a>
									<a class="drop-menu-a" href="{# $SESS_URL #}section=statistic&filter={#$smarty.get.filter#}&action=hourly">по времени суток</a>
								</ul>
							</div>
					
						</div>
						<div onmouseover="ShowLayer('drop_2')" onmouseout="HideLayer('drop_2')">
						<a class="link">Источники</a>
							
							<div id="drop_2">
								<ul class="drop-menu-show">
									<a class="drop-menu-a" href="{# $SESS_URL #}section=statistic&filter={#$smarty.get.filter#}&action=summary">сводка</a>
									<a class="drop-menu-a" href="">сайты</a>
									<a class="drop-menu-a" href="">поисковые системы</a>
									<a class="drop-menu-a" href="">поисковые фразы</a>
								</ul>
							</div>
						</div>
						
						<div onmouseover="ShowLayer('drop_3')" onmouseout="HideLayer('drop_3')">
							<a class="link" href="">Содержание</a>
							<div id="drop_3">
								<ul class="drop-menu-show">
									<a class="drop-menu-a" href="">популярное</a>
									<a class="drop-menu-a" href="">страницы входа</a>
									<a class="drop-menu-a" href="">страницы выхода</a>
								</ul>
							</div>
						</div>
						<div>
							<a class="link" href="">География</a>
						</div>
					</ul>

				
					<br class="clear">					
					{# include file = "$root/admin/modules/statistic/templates/Statistic_$Template.tpl.php" #}
				</td>
			</tr>
		
		</table>
		
		</td>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}