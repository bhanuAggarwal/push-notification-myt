var userFeedback;
function getUserFeedback() {
	var feedbackArray;
	$.ajax({
		method : "GET",
		url : "../php/getUserFeedback.php",
		success : function(data){
						userFeedback = JSON.parse(data);
						
						for(i = 0; i < userFeedback.length; i++)
						$("#feedbackTable").append('<div class="row feedbackEntry'
							+'" id='+i+'>'
							+'<div class="col-md-2">'
							+'<button id="imp" onclick="markImportant('+i+','+userFeedback[i].id+')" class="btn btn-primary col-md-offset-3" style="width:100px; visibility:hidden">Important</button>'
							+'<button onclick="deleteFeedback('+userFeedback[i].id+')" class="btn btn-default col-md-offset-3" style="width:100px">Delete</button></div>'
							+'<div class="col-md-2 text-center" id="userId">'
								+'<h4>'+userFeedback[i]["user_id"]+'</h4>'
							+'</div>'
							+'<div class="col-md-3 text-center" id="feedback">'
								+'<h4>'+userFeedback[i]["feedback"]+'</h4>'
							+'</div>'
							+'<div class="col-md-2 text-center" id="emotion">'
								+'<h4>'+userFeedback[i]["emotion"]+'</h4>'
							+'</div>'
							+'<div class="col-md-3 text-center" id="date">'
								+'<h4>'+userFeedback[i]["date"]+'</h4>'
							+'</div>'
							+'</div>');
						
				}
	});
	return feedbackArray;
}
function showImportant(){
	if($("#show").html() == "Mark Important"){
		for(i = 0; i <userFeedback.length; i++){
			if(userFeedback[i].status == "important"){
				if(!$("#"+i).hasClass("impFeed")){
					$("#"+i).addClass("impFeed");
					$("#"+i + " #imp").css("visibility","hidden");			
				}

			}
			 else{
				$("#"+i + " #imp").css("visibility","visible");			
			}
		}
		$("#show").html("Hide Important");

	}else{
		for(i = 0; i <userFeedback.length; i++){
			$("#"+i).removeClass("impFeed");
			$("#"+i + " #imp").css("visibility","hidden");
		}
		$("#show").html("Mark Important")
	}
	
}
function markImportant(i,id){
	$("#"+i).addClass("impFeed");
	$.ajax({
		type	: "GET",
		url		: "../php/markImportant.php?id="+id,
		success : function(data){
					alert(data);
				}
	});
	$("#"+i + " #imp").css("visibility","hidden");
	userFeedback[i].status = "important";
}

function deleteFeedback(id){
	$.get("../php/deleteFeedback.php?id="+id,function(data){alert(data)});
	location.reload();
}

function logout(){
	window.location.replace("../php/logout.php");
}

function pockets(){
	window.location.replace("../pockets.php");
}