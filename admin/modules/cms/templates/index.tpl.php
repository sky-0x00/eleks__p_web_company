{# include file = "$root/admin/modules/cms/templates/top.tpl.php" #}
	<tr>
		<td id="td_body" align="center">

			<div id="index">
				<div class="index-title"><a>���������� ������</a></div>
				<div id="navigation">
				
				<div id="block_str">
					<div class="icon_str"></div>
					<div id="pos_title">���������� � ���������</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=domain">���������� ������</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=structure">���������� ����������</a></div>
				</div>
				
				<div id="block_str">
					<div class="icon_user"></div>
					<div id="pos_title">������������ � ������</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=users">������ �������������</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=group">������ �������������</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=group">������ �������</a></div>-->
				</div>
				
				<div id="block_str">
					<div class="icon_tpl"></div>
					<div id="pos_title">������� ��������</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=template">������� �������</a></div>
				</div>
				
				<div id="block_str">
					<div class="icon_module"></div>
					<div id="pos_title">������ � ������</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=module">������ � ������</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=iblock">�������������� �����</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=navigation">��������� � ����</a></div>-->
					<div id="pos_menu"><a href="{# $SESS_URL #}section=filemanager">�������� ��������</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=list">�����������, ������</a></div>-->
				</div>
				
				<!--<div id="block_str">
					<div class="icon_stat"></div>
					<div id="pos_title">���������� � ������</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=statistic">���������� ���������</a></div>
					<div id="pos_menu"><a href="">���������� ���������</a></div>
					<div id="pos_menu"><a href="">����������� �����</a></div>
				</div>-->
				
				<div id="block_str">
					<div class="icon_setting"></div>
					<div id="pos_title">���������</div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=setting">��������� �������</a></div>-->
					<div id="pos_menu"><a href="{# $SESS_URL #}section=page_error">��������� ������</a></div>
					<!--<div id="pos_menu"><a href="{# $SESS_URL #}section=tools">�����������</a></div>-->
					
				</div>
				
				<!--<div id="block_str">
					<div class="icon_user"></div>
					<div id="pos_title">����������</div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=archive">��������� �����������</a></div>
					<div id="pos_menu"><a href="{# $SESS_URL #}section=update">����������</a></div>
				</div>-->
				
				</div>
				
				<!--<div id="stat">
					<div class="index-title"><a >������������</a></div>
					<table class="index-stat">
						<tr>
							<td style="width: 15%;"></td><td><a class="under">�������</a></td><td><a class="under">�����</a></td><td><a class="under">������</a></td><td><a class="under">�����</a></td><td><a class="under">�����</a></td>
						</tr>
						<tr>
							<td>�����</td><td>{# $Stat.hosts_1[0].count #}</td><td>{# $Stat.hosts_2[0].count #}</td><td>{# $Stat.hosts_7[0].count #}</td><td>{# $Stat.hosts_30[0].count #}</td><td>{# $Stat.hosts_all[0].count #}</td>
						</tr>
						<tr>
							<td>���������</td><td>{# $Stat.hits_1[0].count #}</td><td>{# $Stat.hits_2[0].count #}</td><td>{# $Stat.hits_7[0].count #}</td><td>{# $Stat.hits_30[0].count #}</td><td>{# $Stat.hits_all[0].count #}</td>
						</tr>
						<tr>
							<td>����������</td><td>{# $Stat.visits_1[0].count #}</td><td>{# $Stat.visits_2[0].count #}</td><td>{# $Stat.visits_7[0].count #}</td><td>{# $Stat.visits_30[0].count #}</td><td>{# $Stat.visits_all[0].count #}</td>
						</tr>
						<tr>
							<td colspan="6">
								<div align="right" class="index-stat-detail">
									<a href="{# $SESS_URL #}section=statistic">������� � ����������</a>
									<a >�������� ������</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div id="stat">
					<div class="index-title"><a>������ ������������</a></div>
				</div>-->
				<br class="clear">
							
			</div>
		
		</td>
	</tr>
	
{# include file = "$root/admin/modules/cms/templates/bottom.tpl.php" #}