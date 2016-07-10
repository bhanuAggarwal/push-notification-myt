<?php
	require_once('loader.php');

	//$data = json_decode($HTTP_RAW_GET_DATA,true);
	$order_id = $_REQUEST['order_id'];
	//file_put_contents('php://stderr', print_r($order_id, TRUE));
	//$order_id 		= 	stripUnwantedHtmlEscape($data['id']);

	$orderDetails = getOrderDetailsById($order_id);

	$message = "You have a new order";
	$UserName = getDealerUserNameById($orderDetails["dealer_id"]);
	$tsi = getTSIById($orderDetails["tsi_id"]);
	$tsi_gcm = $tsi["gcm_regid"];
	$tsi_imei = $tsi["imei"];
	$pushMessage = $UserName["name"]."^".$tsi_imei."^".$message;
	//file_put_contents('php://stderr', print_r($tsi_gcm, TRUE));
	if(isset($tsi_gcm)){
		$registatoin_ids = array($tsi_gcm);
		file_put_contents('php://stderr', print_r($registatoin_ids, TRUE));
		$messageSend = array("message" => $pushMessage);
		$result = send_push_notification($registatoin_ids, $messageSend);
		    
			echo $result;
	}
	else{
		print "Data not found.";
	}
?>