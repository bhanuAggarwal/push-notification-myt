<?php

	require_once('loader.php');
	$data = json_decode($HTTP_RAW_POST_DATA,true);
	$reference_id 	= stripUnwantedHtmlEscape($data['reference_id']);
	$image_url 		= stripUnwantedHtmlEscape($data['image_url']);
	$message 		= stripUnwantedHtmlEscape($data['message']);
	$type			= stripUnwantedHtmlEscape($data['user_type']);
	$sendToIMEI 	= stripUnwantedHtmlEscape($data['imei']);


	//file_put_contents('php://stderr', print_r($reference_id, TRUE));
	 $UserName = getIMEIUserName($sendToIMEI);
	  $message = $UserName."^".$sendToIMEI."^".$message."^".$image_url;
	  file_put_contents('php://stderr', print_r($message, TRUE));
	  file_put_contents('php://stderr', print_r($type, TRUE));
	 switch ($type) {
	 	case 'RM':
	 		$resultUsers =  getAllAMByRM($reference_id);

	 		break;
	 	case 'AM':
	 		$resultUsers =  getAllTSIByAM($reference_id);
	 		break;
	 	case 'TSI':
	 		$resultUsers =  getAllDealerByTSI($reference_id);
	 		file_put_contents('php://stderr', print_r($resultUsers, TRUE));
	 		break;
	 	case 'CA':
	 		$resultUsers =  getAllRMByCA($reference_id);
	 		break;
	 	default:
	 		# code...
	 		break;
	 }
		
	if ($resultUsers != false)
		$NumOfUsers = mysql_num_rows($resultUsers);
	else
		$NumOfUsers = 0;
	if ($NumOfUsers > 0) {
						
	 while ($rowUsers = mysql_fetch_array($resultUsers)) {
		$gcmRegID    = $rowUsers["gcm_regid"]; // GCM Registration ID got from device
		$pushMessage = $message;
		file_put_contents('php://stderr', print_r("GCM : " . $gcmRegID, TRUE));
		if (isset($gcmRegID) && isset($pushMessage)) {
			
			
			$registatoin_ids = array($gcmRegID);
			$messageSend = array("message" => $pushMessage);
		
			$result = send_push_notification($registatoin_ids, $messageSend);
		    
			echo $result;
			//echo "Message sent.";
		}
	   }
	}
	else
	  print "Data not found.";

?>
