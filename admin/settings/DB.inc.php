<?php
$cfg['DB']['Host'] 	= "localhost";
//$cfg['DB']['Host'] 	= "www.eleks73.ru";
$cfg['DB']['Name'] 	= "eleks-group";
$cfg['DB']['User'] 	= "root";
$cfg['DB']['Pass'] 	= "toor";
$cfg['DB']['cls']  	= "SYS_DB";
$cfg['DB']['debug'] = 0;

$cfg['SETTINGS']['PAGER']['NEWS'] 	= 50;         // ��� ������� / �������� ��������� ��� ������� �� ��� (������� �� ��������), ������� ����� �.�. ������� ��������
$cfg['SETTINGS']['PAGER']['ARTICLES'] 	= 5;

$_MONTHS[1]['name'] 	= "������";
$_MONTHS[2]['name'] 	= "�������";
$_MONTHS[3]['name'] 	= "����";
$_MONTHS[4]['name'] 	= "������";
$_MONTHS[5]['name'] 	= "���";
$_MONTHS[6]['name'] 	= "����";
$_MONTHS[7]['name'] 	= "����";
$_MONTHS[8]['name'] 	= "������";
$_MONTHS[9]['name'] 	= "��������";
$_MONTHS[10]['name'] 	= "�������";
$_MONTHS[11]['name'] 	= "������";
$_MONTHS[12]['name'] 	= "�������";

for ($i=1; $i<=12; $i++) {	
	$_MONTHS[$i]['active'] = false;
	$_MONTHS[$i]['num'] = ($i>9) ? $i : ("0".$i);
}

// �������������� ����������, ������������ �����
//$cfg['GENERAL']['title_prefix'];      // ������� � ��������� ����
?>