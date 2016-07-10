<?php
	require_once("../../loader.php");
	$id = $_REQUEST["id"];
	$status = deleteFeedback($id);
	if($status == 1)
		echo "Deleted";
	else
		echo "Can't Delete";

?>