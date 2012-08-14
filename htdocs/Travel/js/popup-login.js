/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com	
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupRequestStatus = 0;
var popupEditRequestStatus = 0;
var popupCommentStatus = 0;
var popupDisplayCommentStatus = 0;
var popupDisplayReportCommentStatus = 0;
var popupDisplayAddNewUser=0;
var popupDisplayInformation=0;
var popupLoading=0;
//loading popup with jQuery magic!
function loadPopup(type){

	if(type=="loading"){
	//loads popup only if it is disabled
	if(popupLoading==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupLoading").fadeIn("slow");
		popupLoading = 1;
	}
	}	
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupLoading==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupLoading").fadeOut("slow");
		popupLoading = 0;
	}
	}

//centering popup
function centerPopup(type){
//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	 if(type=="loading"){
	var popupHeight = $("#popupLoading").height();
	var popupWidth = $("#popupLoading").width();
	//centering
	
	$("#popupLoading").css({
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

function setupPopup(){

}



var M7 = {}; 

//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){

	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupDisplayReportCommentStatus==1){
	//	alert();
			$("#1").show();
			$("#2").show();
			$("#travelTypeLocal").show();
			$("#travelTypeInternational").show();
			$("#travelTypeBoth").show();
			$(".NFCheck").show();
			$(".NFCheck NFh").show();
			$(".NFSelect").show();
			disablePopup();
		}
		if(e.keyCode==27 && popupRequestStatus==1){
			disablePopup();
		}
		if(e.keyCode==27 && popupCommentStatus==1){
			disablePopup();
		}
		if(e.keyCode==27 && popupDisplayCommentStatus==1){
			disablePopup();
		}
		if(e.keyCode==27 && popupDisplayAddNewUser==1){
			disablePopup();
		}
		
	});

    
});