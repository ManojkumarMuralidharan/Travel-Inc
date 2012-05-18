/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupRequestStatus = 0;
var popupCommentStatus = 0;
var popupDisplayCommentStatus = 0;
//loading popup with jQuery magic!
function loadPopup(type){
 
    if(type=="makerequest"){
	//loads popup only if it is disabled
	if(popupRequestStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupRequestStatus = 1;
	}
	}else if(type=="comments"){
	if(popupCommentStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupComments").fadeIn("slow");
		popupCommentStatus = 1;
	}
	}else if(type=="displaycomments"){
	if(popupDisplayCommentStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupDisplayComments").fadeIn("slow");
		popupDisplayCommentStatus = 1;
	}
	
	}
	
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupRequestStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		popupRequestStatus = 0;
	}
	if(popupCommentStatus==1){
	    $("#backgroundPopup").fadeOut("slow");
		$("#popupComments").fadeOut("slow");
		popupCommentStatus = 0;
	}
	if(popupDisplayCommentStatus==1){
	$("#backgroundPopup").fadeOut("slow");
		$("#popupDisplayComments").fadeOut("slow");
		popupDisplayCommentStatus = 0;
	}
}

//centering popup
function centerPopup(type){
//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
     if(type=="makerequest"){
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
	//centering
	$("#popupContact").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	 }else if(type=="comments"){
	var popupHeight = $("#popupComments").height();
	var popupWidth = $("#popupComments").width();
	//centering
	$("#popupComments").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	}else if(type=="displaycomments"){
	var popupHeight = $("#popupDisplayComments").height();
	var popupWidth = $("#popupDisplayComments").width();
	//centering
	$("#popupDisplayComments").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	}
	
	
	//only need force for IE6
	
	
	
}


//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	
	//LOADING POPUP
	//Click the button event!
	$(".commentsDisplay").click(function(){
		//centering with css
		centerPopup('displaycomments');
		//load popup
		loadPopup('displaycomments');
	});
	$(".del").click(function(){
		//centering with css
		centerPopup('comments');
		//load popup
		loadPopup('comments');
	});
	
	$("#createRequest").click(function(){
		//centering with css
		centerPopup('makerequest');
		//load popup
		loadPopup('makerequest');
	});
				
	//CLOSING POPUP
	//Click the x event!
	$("#popupContactClose").click(function(){
		disablePopup();
	});
	
	$("#popupCommentsClose").click(function(){
		disablePopup();
	});
	$("#popupDisplayCommentsClose").click(function(){
		disablePopup();
	});
	
	
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupRequestStatus==1){
			disablePopup();
		}
		if(e.keyCode==27 && popupCommentStatus==1){
			disablePopup();
		}
		if(e.keyCode==27 && popupDisplayCommentStatus==1){
			disablePopup();
		}
	});

});