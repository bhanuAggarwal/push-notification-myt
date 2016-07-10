<?php
	session_start();
	if(!isset($_SESSION["username"])){
		header("Location:../");
	}
?>
<html>
	<head>
		<title>Feedbacks</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row header">
				<div class="col-md-4 col-sm-4 col-xs-8"><h1>Pocketing</h1></div>
				<div class="col-md-offset-11 col-xs-offset-8 col-sm-offset-8">
		          <button class="btn btn-primary btn-lg logout" style="width:110px" onclick="logout()">Logout</button>
		          <button class="btn btn-default btn-lg logout" style="width:110px" onclick="pockets()">Pockets</button>  
		        </div>
			</div>			
			<div class="row" id="feedbackTable">
				<div class="col-md-2 text-center back"><h4 id="show" style="border:1px solid white; padding:7px;background:#3071A9" onclick="showImportant()">Mark Important</h4></div>
				<div class="col-md-2 text-center back" id="userId">
					<h3>User-ID</h3>
				</div>
				<div class="col-md-3 text-center back" id="feedback">
					<h3>Feedback</h3>
				</div>
				<div class="col-md-2 text-center back" id="emotion">
					<h3>Emotion</h3>
				</div>
				<div class="col-md-3 text-center back" id="date">
					<h3>Date</h3>
				</div>

			</div>
		</div>
	</body>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getUserFeedback();
		});
	</script>
</html>