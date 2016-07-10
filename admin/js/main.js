var array;

function getPocketList(){
	// for(var i = 0; i < 4; i++){
	// 	$("#pocketTitle").append("<div id='pocket"+i+"'></div>");
	// 	$("#pocket"+i).load("pocket.html",function(){
	// 			$('#pocket'+  i  +  ' .title').html("bhanu");
	// 			console.log(i);
	// 			alert(i);
	// 	});
	// }

	$.ajax({
		type	: "GET",
		url 	: "php/getPockets.php",
		success	: function(data) {
					var pocketList = JSON.parse(data);
					array = pocketList;
					for(var i = 0; i < data.length; i++) {
							if(pocketList[i] != null){
							var id = pocketList[i].id;
							var category = pocketList[i].category;
							$("#pocketTitle").append('<button onclick="getDetails('+i+')" type="button" id=pocket"'+id+'" class="btn btn-default btn-lg col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 col-xs-10 col-xs-offset-1" style="margin-top:10px"" data-toggle="modal" data-target="#pocket" >'+category+'</button>');
						}
					}

		} 
	});
}



function getDetails(id){
	console.log(pocketId);
	console.log(array[id]);
	if(array[id]["image_url"] != null){
		var img_url = array[id]["image_url"].split(",");
		console.log(img_url[0]);
		for(i = 0;i < img_url.length; i++){
			img_url[i] = '<a href='+img_url[i]+' target="_blank">Image-'+(i+1)+'</a>';
			console.log(img_url[i]);
		}
	}	
	$('#pocketId').html(array[id]["id"]);
	// $('#image_url').html(img);
	$('#price').html(array[id]["price"]);
	$('#title').html(decodeURIComponent(array[id]["title"]));
	$('#description').html(decodeURIComponent(array[id]["description"]));
	$('#image').html(decodeURIComponent(img_url));
	$('#category').html(array[id]["category"]);
	$('#subcategory').html(array[id]["subcategory"]);
	$('#days').html(array[id]["days"]);
	$('#instruction').html(decodeURIComponent(array[id]["instruction"]));
	$('#shifting_charges').html(array[id]["shifting_charges"]);
	$('#tags').html(array[id]["tags"]);
	$('#youtube_url').html(array[id]["youtube_url"]);
	$('#owner_id').html('<button type="button" onclick="getUserDetails('+array[id]["owner_id"]+')" class="btn btn-default" data-target="#user" data-toggle="modal">'+array[id]["owner_id"]+ '</button>');
	$('#tags').html(decodeURIComponent(array[id]["tags"]));
	$('#youtube_url').html(decodeURIComponent(array[id]["youtube_url"]));
	$('#english_article').html(decodeURIComponent(array[id]["english_article"]));
	$('#hindi_article').html(decodeURIComponent(array[id]["hindi_article"]));
}

function approve(){
	var pocketId = $("#pocketId").html();
	var ownerId = $("#owner_id").html();
	$.get("php/approvePocket.php?pocketId="+pocketId,function(data){
		alert(data);
		location.reload();
	});
	
}

function sendFeedback(){
	var pocketId = $("#pocketId").html();
	var ownerId = $("#owner_id").html();
	var feedback = $("#feedbackText").val();
	 $.ajax({
		  	method: "POST",
		  	url: "../sendpush.php",
		  	data: { data1 : "feedbackPocketOwner", data2: feedback , data5: pocketId}
		  })
		  .done(function( msg ) {
		    //$('#loader').hide();
		    //$('#container').css({ opacity: 1 });
		     alert( "Data Saved: " + msg );
		  });
	console.log(feedback);
}

function logout() {
	document.location.href="php/logout.php";	
}
function feedback(){
	window.location.replace("./feedback");
}

function getUserDetails(userId){
	$.get("php/getUserDetails.php?userId="+userId,function(data){
		var userDetails = JSON.parse(data);
		$("#user #image").attr("src",userDetails.image_url);
		$("#user #name").html(userDetails.name);
		$("#user #about_me").html(userDetails.about_me);
		$("#user #email_id").html(userDetails.email_id);
		$("#user #contact_no").html(userDetails.contact_no);
		console.log(userDetails);
	});
}

$('.edit').click(function(){
    var $div=$('#description'), isEditable=$div.is('.editable');
    $div.prop('contenteditable',!isEditable).toggleClass('editable');
    var $div=$('#tags'), isEditable=$div.is('.editable');
    $div.prop('contenteditable',!isEditable).toggleClass('editable');
    var $div=$('#instruction'), isEditable=$div.is('.editable');
    $div.prop('contenteditable',!isEditable).toggleClass('editable');
    $("#sendFeedback").toggleClass("btnVisibility");
    $("#approve").toggleClass("btnVisibility");
    $("#update").toggleClass("btnVisibility");

});

$("#update").click(function(){
	$.ajax({
		type	: "POST",
		url 	: "php/updatePocket.php", 
		data 	: {
					id:$('#pocketId').html(),
				  	description:$('#description').html(),
				  	instruction:$('#instruction').html(),
				  	tags:$('#tags').html()
				  },
		success : function(result){
					alert(result);
				} 
	});
});
