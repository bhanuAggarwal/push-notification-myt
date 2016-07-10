<?php
	require_once("../../loader.php");

	$userFeedback = getUserFeedback();
	$i = 0;
	while($row = mysql_fetch_array($userFeedback)){
		$list[$i++] = $row;
	}

	echo json_encode($list);

?>