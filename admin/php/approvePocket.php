<?php
	require_once("../../loader.php");
	$pocketId = $_REQUEST["pocketId"];
	$message = approvePocket($pocketId);
	if($message == "Pocket Approved"){
		$notification_message = "Your pocket has been approved";
		$pushMessage =  $UserName."^".$sendToIMEI."^".$notification_message;
		$resultImei = getUserImei($pocketId);
		while($row = mysql_fetch_array($resultImei)){
			$imei= $row["imei"];
		}
		$resultUsers =   getIMEIUser($imei);
		if ($resultUsers != false)
			$NumOfUsers = mysql_num_rows($resultUsers);
		else
			$NumOfUsers = 0;
		if ($NumOfUsers > 0) {
	 		while ($rowUsers = mysql_fetch_array($resultUsers)) { 
				$gcmRegID    = $rowUsers["gcm_regid"]; // GCM Registration ID got from device
				if (isset($gcmRegID) && isset($pushMessage)) {			
					$registatoin_ids = array($gcmRegID);
					$messageSend = array("message" => $pushMessage);
					$result = send_push_notification($registatoin_ids, $messageSend);
					//print $result;
					//echo "Message sent.";
				}
	   		}
		}
		else
	  		print "Data not found.";
	}
	echo json_encode($message);
?>