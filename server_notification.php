<!DOCTYPE html>
 <head>
  <meta charset="UTF-8">
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
  <title>server notification</title>
  <style type="text/css">
  	.header{
  		background-color: #ff5252;
  		color: #FFFFFF;
  		font-size: 30px;
  		padding: 15px;
  	}

  	.send_btn{
  		padding: 5px;
  		height: 30px;
  		width: 90px;
  		color: #FFFFFF;
  		background-color: #40AD48;
  		-moz-border-radius: 10px;
        -webkit-border-radius: 10px;
  	}

  	.white_text{
  		color: #FFFFFF;
  	}

  	#loader{
  		position: absolute;
  		margin-left: 50%;
  		font-size: 30px;
  	}

  </style>
  <script type="text/javascript">
  $(document).ready(function(){
  	  $('#loader').hide();
	  function sendNotificationToAll(){
	  	  $('#loader').show();
	  	  $('#container').css({ opacity: 0.5 });
		  $.ajax({
		  	method: "POST",
		  	url: "sendpush.php",
		  	data: { data1 : "All", data2: $("#all_users_message").val(), data7: $("#image_url").val(), data8: $("#general_url").val()}
		  })
		  .done(function( msg ) {
		    $('#loader').hide();
		    $('#container').css({ opacity: 1 });
		    alert( "Data Saved: " + msg );
		  });
	  }

	  function sendNotificationToPocketOwners(){
	  	  $('#loader').show();
	  	  $('#container').css({ opacity: 0.5 });
		  $.ajax({
		  	method: "POST",
		  	url: "sendpush.php",
		  	data: { data1 : "pocketOwners", data2: $("#pocket_owners_message").val() }
		  })
		  .done(function( msg ) {
		    $('#loader').hide();
		    $('#container').css({ opacity: 1 });
		     alert( "Data Saved: " + msg );
		  });


		  
	  }

	  $("#all").click(function(){
	  	 sendNotificationToAll();
	  });

	  $("#owners").click(function(){
	  	 sendNotificationToPocketOwners();
	  });
    });
  </script>

 </head>
 <body>
<div id="container">
	<div class="header"> WELCOME TO NOTIFICATION SENDING INTERFACE OF POCKETING </div>
	<div id="loader"> Request Sending...... </div>

	<div class="all_users">
	 	<h1>Notification to all users</h1>
	 	<textarea rows="4" cols="50" placeholder="Enter your message here!" autofocus="true" id="all_users_message" >
	 	</textarea></br>
	 	Image URL<textarea placeholder="enter image_url:" id="image_url"></textarea></br>
	 	General URL<textarea placeholder="enter general_url:" id="general_url"></textarea></br>
	 	<button type="button" name="Send" class="send_btn" id="all" class="white_text">
	 		Send
	    </button>
	</div>

	<div class="pocket_owners">
		<h1>Notification to pocket owners</h1>
		<textarea rows="4" cols="50" placeholder="Enter your message here!" text="This is for pocket owner only" autofocus="true" id="pocket_owners_message">
	 	</textarea></br>
	 	<button type="button" name="Send" class="send_btn" id="owners" class="white_text">
	 		Send
	 	</button>
	</div>
</div>

 </body>
</html>