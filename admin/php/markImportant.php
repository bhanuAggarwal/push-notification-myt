<?php
	require_once("../../loader.php");
	$id = $_REQUEST["id"];
	$flag = markImportant($id);
	if($flag == 1)
		echo "Marked Important";
	else
		echo "Can't Mark Important";
?>