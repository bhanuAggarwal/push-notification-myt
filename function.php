
<?php

   /**
     * Storing new user
     * returns user details
     */
   function storeUser($name, $email, $gcm_regid,$imei) {
        // insert user into database
        $result = mysql_query("INSERT INTO gcm_users(name, email, gcm_regid, imei , created_at) VALUES('$name', '$email', '$gcm_regid','$imei', NOW())");
        $result1 = mysql_query("UPDATE users SET imei='$imei' where email_id='$email'");
        // check for successful store
        if ($result && $result1) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
      This is for updating the user value when more than 1 user from a device 
    **/
    function updateUser($name, $email, $gcm_regid, $imei){
        $result = mysql_query("UPDATE gcm_users SET name='$name', email='$email', gcm_regid = '$gcm_regid', created_at=NOW() where imei=$imei");
        $result1 = mysql_query("UPDATE users SET imei='$imei' where email_id='$email'");
        return ($result && $result1);
    }

    /*
       This is for setting IMEI null for previously registered users from this imei 
    **/
    function updatePreviousUsers($imei){
        $result = mysql_query("UPDATE users SET imei=NULL where imei=$imei");
        return $result;
    }

    /**
     * Get user by email
     */
   function getUserByEmail($email) {
        $result = mysql_query("SELECT * FROM gcm_users WHERE email = '$email' LIMIT 1");
        return $result;
    }

    /**
     * Getting all registered users
     */
   function getAllUsers() {
        $result = mysql_query("select * FROM gcm_users");
        return $result;
    }

     /**
     * Getting users detail by IMEI
     */
   function getIMEIUser($imei) {
        $result = mysql_query("select * from gcm_users where imei='$imei'");
        return $result;
    }

    function getUserImei($pocketId){
        $result = mysql_query("select imei from users where id in (select owner_id from pocket where id='$pocketId')");
        return $result;
    }

     /**
     * Getting users detail by IMEI
     */
   function getPreviousIMEIUser($imei) {
        $result = mysql_query("select name from gcm_users where imei='$imei'");
        if(mysql_num_rows($result))
            return true;
        else 
            return false;
    }
	
	/**
     * Getting users detail by REGID
     */
   function getRegIDUser($regID) {
        $result = mysql_query("select * FROM gcm_users where gcm_regid='$regID'");
        return $result;
    }
	
	/**
     * Getting users
     */
   function getIMEIUserName($imei) {
	    $UserName = "";
        $result = mysql_query("select u.name FROM gcm_users gcm JOIN users u ON gcm.email = u.email where imei='$imei'");
		if(mysql_num_rows($result))
		{
		   while($row = mysql_fetch_assoc($result))
		   {
			   $UserName  = $row['name'];
		   }
	    }
        return $UserName;
    }

    /**
     * Validate user
     */
  function isUserExisted($email,$gcmRegID) {
        $result    = mysql_query("SELECT email from gcm_users WHERE email = '$email' and gcm_regid = '$gcmRegID'");
        $NumOfRows = mysql_num_rows($result);
        if ($NumOfRows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }
	
	/**
     * Sending Push Notification
     */
   function send_push_notification($registatoin_ids, $message) {
        
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
		//print_r($headers);
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        file_put_contents('php://stderr', print_r(json_encode($result), TRUE));
        // Close connection
        curl_close($ch);
        echo $result;
    }
	
	
	function stripUnwantedTags($str)
	{
		$tempStr = $str;
		
		$tempStr  = str_replace('script','scriptd',$tempStr);
	    $tempStr  = str_replace('iframe','iframed',$tempStr);
		$tempStr  = str_replace('base64','',$tempStr);
		$tempStr  = str_replace('eval(','',$tempStr);
		$tempStr  = str_replace('data:','',$tempStr);
		//$tempStr  = htmlentities($tempStr, ENT_QUOTES, "UTF-8");
		
		return $tempStr;
	}
    
	function escapeStr($str)
        {
				$tempStr  = htmlentities($str, ENT_QUOTES, "UTF-8");
				return str_replace("'","",$tempStr);
        }
	function escapeStrMysql($str){
		
		 return  mysql_real_escape_string($str);
	 }	
	 
   
  function stripHtmlTags($str){
		
		 return  strip_tags($str);
	 }
	 
  function stripUnwantedHtmlEscape($str)
  {
	  return escapeStrMysql(escapeStr(stripUnwantedTags(stripHtmlTags($str))));  
  }

  function getPocketList(){
    $result = mysql_query("SET NAMES utf8");
    $sql = "SELECT * FROM pocket WHERE status='new'";
    $pocketList = mysql_query($sql);
   // echo $pocketList;
    return $pocketList;
  }

  function approvePocket($pocketId){
    $sql = "UPDATE pocket SET status = 'approved' where id = $pocketId";
    $status = mysql_query($sql);
    if($status)
        $message = "Pocket Approved";
    else
        $message = "Pocket Not Approved";
    return $message;
    }

    function checkAdmin($username,$password) {
        echo $username;
        $sql = "select * from admin where username = '$username' AND password='$password'";
        echo $sql;
        $result = mysql_query($sql);
        echo $result;
        return $result;
    }

    function getUserFeedback(){
      $sql = "SELECT * FROM user_feedback ORDER BY id DESC";
      $result = mysql_query($sql);
      return $result;
    }
    
    function markImportant($id){
      $sql = "UPDATE user_feedback SET status = 'important' WHERE id = '$id'";
      $result = mysql_query($sql);
      return $result;
    }

    function deleteFeedback($id){
      $sql = "DELETE FROM user_feedback WHERE id = '$id'";
      $result = mysql_query($sql);
      return $result;
    }

    function getUserDetails($userId){
      $sql = "SELECT * FROM users WHERE id = '$userId'";
      $result = mysql_query($sql);
      $userDetails = mysql_fetch_array($result);
      return $userDetails;
    }

    function updatePocket($pocket){
      $sql = "UPDATE pocket SET description = '$pocket[description]' , " 
             . " tags = '$pocket[tags]' , instruction = '$pocket[instruction]' "
             . " WHERE id = '$pocket[id]'";
      $result = mysql_query($sql);
      return $result;
    }

    function getAllAMByRM($reference_id){
      $sql = "SELECT am.*, gcm.gcm_regid AS \"gcm_regid\" FROM area_manager am JOIN gcm_users gcm ON am.email = gcm.email WHERE boss_id = '$reference_id'";
      $result = mysql_query($sql);
      return $result;
    }

    function getAllTSIByAM($reference_id){
      $sql = "SELECT tsi.*, gcm.gcm_regid AS 'gcm_regid' FROM tsi JOIN gcm_users gcm ON tsi.email = gcm.email WHERE boss_id = '$reference_id'";
      $result = mysql_query($sql);
      return $result; 
    }

    function getAllDealerByTSI($reference_id){
      $sql = "SELECT d.*,gcm.gcm_regid AS 'gcm_regid' FROM dealer d JOIN gcm_users gcm ON d.email = gcm.email WHERE boss_id = '$reference_id'";
      $result = mysql_query($sql);
      return $result;  
    }

    function getAllRMByCA($reference_id){
      $sql = "SELECT * FROM regional_manager WHERE boss_id = '$reference_id'";
      $result = mysql_query($sql);
      return $result;   
    }

    function getDealerUserNameById($dealer_id){
      $sql = "SELECT name FROM dealer WHERE id = '$dealer_id'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      return $row;
    }

    function getOrderDetailsById($order_id){
      $sql = "SELECT * FROM dealer_order WHERE id = '$order_id'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      return $row;
    }

    function getTSIById($tsi_id){
      $sql = "SELECT gcm_regid,imei FROM gcm_users WHERE email IN  ( SELECT email FROM tsi WHERE id = '$tsi_id')";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      return $row;
    }
?>