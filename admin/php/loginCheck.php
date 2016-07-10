<?php
	require_once("../../loader.php");
	session_start();
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	echo $_REQUEST['username'];
	$result = checkAdmin($username,$password);
	if($row = mysql_fetch_array($result)) {
		$_SESSION['username'] = $username;
		echo "Successfull";
		header("Location:../pockets.php");
	}
	else {
		$_SESSION['error'] = "Credentials wrong";
		if(isset($_SESSION['error'])){
			header("Location:../");
		}
			
	}
	
	

?>