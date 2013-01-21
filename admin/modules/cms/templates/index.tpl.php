{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}
	<tr>
		<td id="td_body" align="center">

			<div id="index">
				<div class="index-title"><a>Управление сайтом</a></div>
				<div id="navigation">
				
				<div id="block_str">
					<div class="icon_str"></div>
					<div id="pos_title">Управление и структура</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=domain">Управление сайтом</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=structure">Управление структурой</a></div>
				</div>
				
				<div id="block_str">
					<div class="icon_user"></div>
					<div id="pos_title">Пользователи и группы</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=users">Список пользователей</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=group">Группы пользователей</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=group">Уровни доступа</a></div>-->
				</div>
				
				<div id="block_str">
					<div class="icon_tpl"></div>
					<div id="pos_title">Шаблоны дизайнов</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=template">Шаблоны дизайна</a></div>
				</div>
				
				<div id="block_str">
					<div class="icon_module"></div>
					<div id="pos_title">Модули и данные</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=module">Модули и данные</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=iblock">Информационные блоки</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=navigation">Навигация и меню</a></div>-->
					<div id="pos_menu"><a href="{# $SESS_URL #}section=filemanager">Файловый менеджер</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=list">Справочники, списки</a></div>-->
				</div>
				
				<!--<div id="block_str">
					<div class="icon_stat"></div>
					<div id="pos_title">Статистика и отчеты</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=statistic">Статистика посещений</a></div>
					<div id="pos_menu"><a href="">Статистика изменений</a></div>
					<div id="pos_menu"><a href="">Доступность сайта</a></div>
				</div>-->
				
				<div id="block_str">
					<div class="icon_setting"></div>
					<div id="pos_title">Настройки</div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=setting">Настройки системы</a></div>-->
					<div id="pos_menu"><a href="{# $SESS_URL #}section=page_error">Обработка ошибок</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=tools">Инструменты</a></div>-->
					
				</div>
				
				<!--<div id="block_str">
					<div class="icon_user"></div>
					<div id="pos_title">Обновления</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=archive">Резервное копирование</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=update">Обновления</a></div>
				</div>-->
				
				</div>
				
				<!--<div id="stat">
					<div class="index-title"><a >Посещаемость</a></div>
					<table class="index-stat">
						<tr>
							<td style="width: 15%;"></td><td><a class="under">Сегодня</a></td><td><a class="under">Вчера</a></td><td><a class="under">Неделя</a></td><td><a class="under">Месяц</a></td><td><a class="under">Всего</a></td>
						</tr>
						<tr>
							<td>Хосты</td><td>{# $Stat.hosts_1[0].count #}</td><td>{# $Stat.hosts_2[0].count #}</td><td>{# $Stat.hosts_7[0].count #}</td><td>{# $Stat.hosts_30[0].count #}</td><td>{# $Stat.hosts_all[0].count #}</td>
						</tr>
						<tr>
							<td>Просмотры</td><td>{# $Stat.hits_1[0].count #}</td><td>{# $Stat.hits_2[0].count #}</td><td>{# $Stat.hits_7[0].count #}</td><td>{# $Stat.hits_30[0].count #}</td><td>{# $Stat.hits_all[0].count #}</td>
						</tr>
						<tr>
							<td>Посетители</td><td>{# $Stat.visits_1[0].count #}</td><td>{# $Stat.visits_2[0].count #}</td><td>{# $Stat.visits_7[0].count #}</td><td>{# $Stat.visits_30[0].count #}</td><td>{# $Stat.visits_all[0].count #}</td>
						</tr>
						<tr>
							<td colspan="6">
								<div align="right" class="index-stat-detail">
									<a href="{# $SESS_URL #}section=statistic">Перейти к статистике</a>
									<a >Показать график</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div id="stat">
					<div class="index-title"><a>График посещаемости</a></div>
				</div>-->
				<br class="clear">
							
			</div>
		
		</td>
	</tr>
	
{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}