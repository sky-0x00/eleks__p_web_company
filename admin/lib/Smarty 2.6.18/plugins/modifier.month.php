<?php

function smarty_modifier_month($date) {

	$month = array('01'=>'€нвар€','02'=>'феврал€','03'=>'марта','04'=>'апрел€','05'=>'ма€','06'=>'июн€','07'=>'июл€','08'=>'августа','09'=>'сент€бр€','10'=>'окт€бр€','11'=>'но€бр€','12'=>'декабр€');
	$date_str = explode("-", $date);
    if ($date_str[2]{0} == '0')
        $date_str[2] = $date_str[2]{1};
	return $date_str[2]." ".$month[$date_str[1]];

	
}

?>