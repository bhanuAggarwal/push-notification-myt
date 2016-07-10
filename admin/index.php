<?php
	session_start();
	if(isset($_SESSION["username"])){
		header("Location:pockets.php");
	}

?>
<html>
	<head>	
		<title>Admin Login</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	</head>
	<body class="login">
		<div class="container-fluid">
			<div class="row header">
				<div class="col-md-4 col-sm-4 col-xs-8"><h1>Pocketing</h1></div>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<form class="form" method="post" role="form" action="php/loginCheck.php">
					  <div class="form-group">
					    <label for="username">Username</label>
					    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
					  </div>
					  <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
					  </div>
					  <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
								  <?php 
				  			if(isset($_SESSION['error'])){
								echo "<div class='col-md-4 col-md-offset-4 text-center'>'$_SESSION[error]'</div>";
							}
					  ?>
		</div>
	</body>
</html>