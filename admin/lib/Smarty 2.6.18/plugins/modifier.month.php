<?php

function smarty_modifier_month($date) {

	$month = array('01'=>'������','02'=>'�������','03'=>'�����','04'=>'������','05'=>'���','06'=>'����','07'=>'����','08'=>'�������','09'=>'��������','10'=>'�������','11'=>'������','12'=>'�������');
	$date_str = explode("-", $date);
    if ($date_str[2]{0} == '0')
        $date_str[2] = $date_str[2]{1};
	return $date_str[2]." ".$month[$date_str[1]];

	
}

?>