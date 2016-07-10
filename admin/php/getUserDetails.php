<?php
	require_once("../../loader.php");
	$userId = $_REQUEST["userId"];
	$userDetail = getUserDetails($userId);
	echo json_encode($userDetail);
?>