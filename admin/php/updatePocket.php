<?php
	require_once("../../loader.php");
	$pocket['id'] = $_REQUEST["id"];
	$pocket['description'] = $_REQUEST["description"];
	$pocket['instruction'] = $_REQUEST["instruction"];
	$pocket['tags'] = $_REQUEST["tags"];
	$flag = updatePocket($pocket);
	if($flag > 0)
		$result = "Pocket Updated";
	else
		$result = "Pocket Can't Updated";
	echo json_encode($result);
?>