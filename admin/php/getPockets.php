<?php
	require_once("../../loader.php");
	header('Content-Type:charset=UTF-8');
	$pocketList = getPocketList();
	$i = 0;
	while ($rowUsers = mysql_fetch_array($pocketList)){
		$list[$i] = $rowUsers;
		$i++;
	}
	//echo json_encode($pocketList);
	echo json_encode($list);
?>