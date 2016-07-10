<?php
  header('Content-Type:charset=UTF-8');
  session_start();
  if(!isset($_SESSION['username']))
    header("Location:./");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
    <meta http-equiv="Content-Type" content="charset=UTF-8">
		<title>Admin Panel</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row header">
        <div class="col-md-4 col-sm-4 col-xs-8"><h1>Pocketing</h1></div>
        <div class="col-md-offset-11 col-xs-offset-8 col-sm-offset-8">
              <button class="btn btn-primary btn-lg logout" style="width:110px" onclick="logout()">Logout</button>
              <button class="btn btn-default btn-lg logout" style="width:110px" onclick="feedback()">Feedbacks</button>  
            </div>
      </div>
			<div class="row" id="pocketTitle">
				
			</div>
		</div>
		

<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="pocket" tabindex="-1" role="dialog" aria-labelledby="Pocket">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button class="edit btn btn-default" style="float:right "><span class="glyphicon glyphicon-pencil" aria-hidden="true"> Edit</span></button>
        <h4 class="modal-title" id="myModalLabel">Pocket</h4>
      </div>
      <div class="modal-body">

        <!--Pocket ID-->
      	<div class="row element">
        	<div class="col-md-2">Pocket ID </div>
        	<div id="pocketId" class="col-md-10 text-justify">
        		
        	</div>
        </div>
      <!--Title-->
      	<div class="row element">
        	<div class="col-md-2">Title </div>
        	<div id="title" class="col-md-10 text-justify">
        		
        	</div>
        </div>

        <!--Owner Id-->
      	<div class="row element">
        	<div class="col-md-2">Owner ID </div>
        	<div id="owner_id" class="col-md-10 text-justify">
        	
        	</div>
        </div>

      <!--Images-->
      	<div class="row element">
        	<div class="col-md-2">Images</div>
        	<div id="image" class="col-md-10 text-justify">
        		
        	</div>
        </div>

      <!--Category-->
      	<div class="row element">
        	<div class="col-md-2">Category</div>
        	<div id="category" class="col-md-10 text-justify">
        		
        	</div>
        </div>


      <!--Sub Category-->
      	<div class="row element">
        	<div class="col-md-2">SubCategory</div>
        	<div id="subcategory" class="col-md-10 text-justify">
        		<br/>
        	</div>
        </div>


      <!--Description-->
      	<div class="row element">
        	<div class="col-md-2">Description </div>
        	<div id="description" class="col-md-10 text-justify">
        		
        	</div>
        </div>

      <!--Days-->
      	<div class="row element">
        	<div class="col-md-2">Days </div>
        	<div id="days" class="col-md-10 text-justify">
        		<br/>
        	</div>
        </div>

      <!--Instruction-->
      	<div class="row element">
        	<div class="col-md-2">Instruction </div>
        	<div id="instruction" class="col-md-10 text-justify">
        		
        	</div>
        </div>

      <!--Shipping Charges-->
      	<div class="row element">
        	<div class="col-md-2">Shipping Changes</div>
        	<div id="shifting_charges" class="col-md-10 text-justify">
        		
        	</div>
        </div>

      <!--Price-->
      	<div class="row element">
        	<div class="col-md-2">Price </div>
        	<div id="price" class="col-md-10 text-justify">
        		
        	</div>
        </div>

      <!--Tags-->
      	<div class="row element">
        	<div class="col-md-2">Tags </div>
        	<div id="tags" class="col-md-10 text-justify">
        		
        	</div>
        </div>

      <!--Youtube Link-->
      	<div class="row element">
        	<div class="col-md-2">YouTube Link </div>
        	<div id="youtube_url" class="col-md-10 text-justify">
        		<br/>
        	</div>
        </div>

      <!--English Writing-->
      	<div class="row element">
        	<div class="col-md-2">English Writing </div>
        	<div id="english_article" class="col-md-10 text-justify">
        		<br/>
        	</div>
        </div>

      <!--Hindi Writing-->
        <div class="row element">
          <div class="col-md-2">Hindi Writing </div>
          <div id="hindi_article" class="col-md-10 text-justify" >
            <br/>
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#feedback" id="sendFeedback">Send FeedBack</button>
        <button type="button" class="btn btn-primary" onclick="approve()" id="approve">Approve Pocket</button>
         <button type="button" class="btn btn-primary btnVisibility" id="update">Update</button>
      </div>
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send FeedBack</h4>
      </div>
      <div class="modal-body">
        <textarea id="feedbackText" class="form-control" rows="3" placeholder="Enter the Feedback" style="resize:none"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="sendFeedback()">Send</button>

      </div>
    </div>
  </div>
</div>


<!-- User Modal -->
<div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">User Info</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
          <img src="" width="100%" id="image"/>
          </div>
          <div class="col-md-8">
            <!--Name-->
            <div class="row element">
              <div class="col-md-5">Name</div>
              <div id="name" class="col-md-7 text-justify">
                <br/>
              </div>
            </div>
            <!--Email-->
            <div class="row element">
              <div class="col-md-5">Email</div>
              <div id="email_id" class="col-md-7 text-justify">
                <br/>
              </div>
            </div>
            <!--Contact No.-->
            <div class="row element">
              <div class="col-md-5">Contact No.</div>
              <div id="contact_no" class="col-md-7 text-justify">
                <br/>
              </div>
            </div>
            <!--Description-->
            <div class="row element">
              <div class="col-md-5">Description</div>
              <div id="about_me" class="col-md-7 text-justify">
                <br/>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
	</body>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
  <script type="text/javascript">
    $(document).ready(getPocketList());
  </script>
</html>