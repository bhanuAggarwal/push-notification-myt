<?php
require_once('loader.php');

// return json response 
$json = array();

$nameUser  = stripUnwantedHtmlEscape($_POST["name"]);
$emailUser = stripUnwantedHtmlEscape($_POST["email"]);
$gcmRegID  = stripUnwantedHtmlEscape($_POST["regId"]); // GCM Registration ID got from device
$imei      = stripUnwantedHtmlEscape($_POST["imei"]);

// Send this message to device
$message = $nameUser."^".$imei."^Registered on server.";

/**
 * Registering a user device in database
 * Store reg id in users table
 */
if (isset($nameUser) && isset($emailUser) && isset($gcmRegID) && $nameUser!="" && $imei!="" && $gcmRegID!="" && $emailUser!="") {
   /*if(!isUserExisted($emailUser,$gcmRegID))
   {*/
	// Store user details in db
    if(getPreviousIMEIUser($imei)){
      $res1 =updatePreviousUsers($imei);
      $res  =updateUser($nameUser, $emailUser, $gcmRegID,$imei);
    }else{
      $res = storeUser($nameUser, $emailUser, $gcmRegID,$imei);
    }
    $registatoin_ids = array($gcmRegID);
    file_put_contents('php://stderr', print_r($registatoin_ids, TRUE));
    $messageSend = array("message" => $message);
    file_put_contents('php://stderr', print_r($messageSend, TRUE));
    $result = send_push_notification($registatoin_ids, $messageSend);
    file_put_contents('php://stderr', print_r($result, TRUE));
   //}//echo $result;
} else {
    // user details not found
	echo "Wrong values.";
}
?>