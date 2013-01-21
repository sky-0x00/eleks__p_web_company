<?php
session_start();
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/functions_lib.inc.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/DB.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Path.inc.php");
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/settings/Table.inc.php");
DirInclude ( $cfg['PATH']['core'] );
DirInclude ( $cfg['PATH']['admin_classes']);
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/lib/Smarty 2.6.18/Smarty.class.php" );
include_once ( $_SERVER['DOCUMENT_ROOT'] . "/admin/global/local.inc.php" );
//////////////////////////////////////////////////////////////////////////////////////
include_once ( $cfg['PATH']['admin_modules_path']."catalog/classes/Catalog.class.php" );
include_once ( $cfg['PATH']['admin_modules_path']."feedback/classes/FeedBack.class.php" );

$Catalog = new Catalog();

if (isset($_POST['org']) && !empty($_POST['org']) &&
	isset($_POST['name']) && !empty($_POST['name']) &&
	isset($_POST['phone']) && !empty($_POST['phone'])) {
	
	if (!empty($_SESSION['CART'])) {
		
		foreach ($_POST as $key => $value) {
			$_POST[$key] 	= validateForm(utf8($value));
			$feedback[$key] = $_POST[$key];
		}
		
		$response = $Catalog->AddOrder ($_POST['org'], $_POST['name'], $_POST['town'], $_POST['phone'], 
										$_POST['email'], $_POST['comment'], $_SESSION['CART']);
		
		//////////////////////////////////////////////////////////////////////////////////////
		
		if ($response['result']=="success") {
		
			$items = $Catalog -> GetCartItems($_SESSION['CART']);			
						
			$feedback['amount'] = 0;
			$feedback['weight'] = 0;
			
			if ($items) {
				
				for ($i=0; $i<count($items); $i++) {
					$items[$i]['total_weight'] = $items[$i]['amount']*$items[$i]['weight'];
					$feedback['amount'] += $items[$i]['amount'];
					$feedback['weight'] += $items[$i]['total_weight'];
				}
			}
			
			$FeedBackClass = new FeedBack();
			$tpl = new Smarty_Admin();

			$feedback_param = $FeedBackClass -> getModuleParam ();
			
			$feedback['items'] = $items;
			$feedback['order'] = $response['text'];
			
			$feedback_headers  = "MIME-Version: 1.0" . "\r\n";
			$feedback_headers .= "Content-type: text/html; charset=windows-1251" . "\r\n";
			$feedback_headers .= "From: " . $feedback['org'] . " <" . $feedback['email'] . ">" . "\r\n";

			$tpl -> assign ( "feedback_params", 	$feedback );
			
			$feedback_content = $tpl->fetch($cfg['PATH']['admin_modules'] . "module/block/feedback/templates/order.tpl.php");
			
			mail($feedback_param[0]['feedback_mails'], "Заявка с сайта goldenglobe.ru", $feedback_content, $feedback_headers);		
			
		//////////////////////////////////////////////////////////////////////////////////////
			
			if (isset($_POST['email']) && is_email($_POST['email'])) {				
				
				$properties = $Catalog -> GetCartItemsProperties($_SESSION['CART']);
			
				if ($filename = $Catalog -> GetExcelCart($items, $properties, $response['text'])) {
					
					$mails 		= explode(",", $feedback_param[0]['feedback_mails']);
					$subj 		= "Информация о заказе №" . $response['text'] . ".";
					$message 	= "Заказ №" . $response['text'] . " от " . date("d.m.Y.");
					
					xmail(trim($mails[0]), $_POST['email'], $subj, $message, $filename);
				}
			}
		}
		
		//////////////////////////////////////////////////////////////////////////////////////
		
		print win(array2json($response));
	}
	else {
		$result = "error";
		$text	= "Ваша корзина пуста.";
		print win(array2json(array("result" => $result, "text" => $text)));
	}
}
else {
	$result = "error";
	$text	= "Неверные параметры.";
	print win(array2json(array("result" => $result, "text" => $text)));
}

?>