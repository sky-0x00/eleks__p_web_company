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
				
				<td style="padding-top: 40px; vertical-align: top;">
				
					<div class="menu">
						<a href="">Интерфейс системы</a>
						<a href="">Настройка БД</a>
					</div>
				
					<br class="clear">					
					{# include file = "$Template.tpl.php" #}
				</td>
			</tr>
		
		</table>
		
		</td>

{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}