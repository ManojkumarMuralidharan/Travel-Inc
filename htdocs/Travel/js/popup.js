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
	}else if(type=="informationDisplay"){
	//loads popup only if it is disabled
	if(popupDisplayInformation==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupInformation").fadeIn("slow");
		popupDisplayInformation = 1;
	}
	}else if(type=="reportComments"){
	//loads popup only if it is disabled
	if(popupDisplayReportCommentStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupDisplayReportComments").fadeIn("slow");
		popupDisplayReportCommentStatus = 1;
	}
	}else if(type=="editrequest"){
	//loads popup only if it is disabled
	if(popupEditRequestStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupEditContact").fadeIn("slow");
		popupEditRequestStatus = 1;
	}
	}else if(type=="makerequest"){
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
	
	}else if(type=="displayaddnewuser"){
	if(popupDisplayAddNewUser==0){
		$("#backgroundPopupNewUser").css({
			"opacity": "0.7"
		});
		$("#backgroundPopupNewUser").fadeIn("slow");
		$("#popupAddNewUser").fadeIn("slow");
		popupDisplayAddNewUser = 1;
	
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
	if(popupDisplayInformation==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupInformation").fadeOut("slow");
		popupDisplayInformation = 0;
	}
	if(popupDisplayReportCommentStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupDisplayReportComments").fadeOut("slow");
		popupDisplayReportCommentStatus = 0;
	}
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
	if(popupDisplayAddNewUser==1){
	$("#backgroundPopupNewUser").fadeOut("slow");
		$("#popupAddNewUser").fadeOut("slow");
		popupDisplayAddNewUser = 0;
	}
	if(popupEditRequestStatus==1){
	$("#backgroundPopup").fadeOut("slow");
		$("#popupEditContact").fadeOut("slow");
		popupEditRequestStatus = 0;
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
	 }else if(type=="reportComments"){
	var popupHeight = $("#popupDisplayReportComments").height();
	var popupWidth = $("#popupDisplayReportComments").width();
	//centering
	
	$("#popupDisplayReportComments").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	 }else if(type=="editrequest"){
	var popupHeight = $("#popupEditContact").height();
	var popupWidth = $("#popupEditContact").width();
	//centering
	$("#popupEditContact").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	 }else if(type=="makerequest"){
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
	}else if(type=="displayaddnewuser"){
	var popupHeight = $("#popupAddNewUser").height();
	var popupWidth = $("#popupAddNewUser").width();
	//centering
	$("#popupAddNewUser").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundPopupNewUser").css({
		"height": windowHeight
	});
	}else if(type=="informationDisplay"){
	var popupHeight = $("#popupInformation").height();
	var popupWidth = $("#popupInformation").width();
	//centering
	$("#popupInformation").css({
		"position": "absolute",
		"top": windowHeight/2-popupHeight/2,
		"left": windowWidth/2-popupWidth/2
	});
	$("#backgroundpopupInformation").css({
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

	 M7 = function () {
	//alert();
	 //LOADING POPUP
	//Click the button event!
	
/*	$('#approveButton').click(function(){
	//alert();	
	 var checkValues = [];
	 $('input[name=userRecordsCheckbox]:checked').each(function() {
      //alert($(this).parent().parent().find('td a').attr('id'));
      checkValues.push($(this).parent().parent().find('td a').attr('id'));
    });
	alert(checkValues);
	});*/
	
	$('#approveButton').click(function(){
	 var checkValues = [];
	 $('input[name=supervisorRecordsCheckbox]:checked').each(function() {
//	 alert($(this).parent().parent().find('td span').attr('id'));
	 //alert($(this).parent().parent().find('td span').attr('text'));
     checkValues.push($(this).parent().parent().find('td span').attr('id'));
    });
	if(checkValues.length==0){
	return;
	}
	centerPopup('loading');
		//load popup
	loadPopup('loading');
	$("#loading").show();
	//alert(checkValues);
	
		$.ajax({
		type: "POST",
		url: "supervisorActionOnRequest.php",
		data: { id: checkValues, action: 'Approved' },
		}).done(function(data) { 
		//alert(data);
		disablePopup();
		$("#loading").hide();
		Notifier.success(data);
		window.location.href="home.php";
//		$("#loading").hide();
		});
	});
	
	
	$('#declineButton').click(function(){
	 var checkValues = [];
	 $('input[name=supervisorRecordsCheckbox]:checked').each(function() {
      checkValues.push($(this).parent().parent().find('td span').attr('id'));
    });
	if(checkValues.length==0){
	return;
	}
	centerPopup('loading');
		//load popup
	loadPopup('loading');
	
	$("#loading").show();
	//alert(checkValues);
	
		$.ajax({
		type: "POST",
		url: "supervisorActionOnRequest.php",
		data: { id: checkValues, action: 'Declined' },
		}).done(function(data) { 
		//alert(data);
		disablePopup();
		Notifier.success(data);
		window.location.href="home.php";
		$("#loading").hide();
		});
	});
	
	
	$('#onHoldButton').click(function(){
	 var checkValues = [];
	 $('input[name=supervisorRecordsCheckbox]:checked').each(function() {
      checkValues.push($(this).parent().parent().find('td span').attr('id'));
    });
	if(checkValues.length==0){
	return;
	}
	centerPopup('loading');
		//load popup
	loadPopup('loading');

	$("#loading").show();
	//alert(checkValues);
	
		$.ajax({
		type: "POST",
		url: "supervisorActionOnRequest.php",
		data: { id: checkValues, action: 'On Hold' },
		}).done(function(data) { 
		
		disablePopup();	
		//alert(data);
		Notifier.success(data);
		window.location.href="home.php";
		$("#loading").hide();
		});
	});
	
	
	
	$('#cancelRequestButton').click(function(){
	 var checkValues = [];
	 $('input[name=userRecordsCheckbox]:checked').each(function() {
      checkValues.push($(this).parent().parent().find('td span').attr('id'));
    });
	if(checkValues.length==0){
	return;
	}
	centerPopup('loading');
		//load popup
	loadPopup('loading');

	$("#loading").show();
	
		$.ajax({
		type: "POST",
		url: "cancelRequest.php",
		data: { id: checkValues },
		}).done(function(data) { 
		//alert(data);
		disablePopup();
		Notifier.success(data);
		
		$("#loading").hide();		
		setTimeout(function(){ window.location.href="home.php"; }, 500);
		});
	});
	
	
$('#userRecordsPaginationElement a').click(function(e) {
 e.preventDefault();
 });
 $('#supervisorRecordsPaginationElement a').click(function(e) {
 e.preventDefault();
 });
 $('#reportRecordsPaginationElement a').click(function(e) {
 e.preventDefault();
 });
 
 	
		
	$( "#newRequestFromDate" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#newRequestToDate" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});	
		$( "#editRequestFromDate" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});
		$( "#editRequestToDate" ).datepicker({
			showOn: "button",
			buttonImage: "Images/calendar.gif",
			buttonImageOnly: true
		});	
		
		
		 $("#clearPassword").click(function(){
			 $("#currentPassword").val("");
			 $("#newPassword").val("");
			 $("#reNewPassword").val("");
		 });	
		
		
		$('#securityQuesConfirm').click(function() {
		//alert();
		if($('#securityAnswer').val()==''){
		Notifier.warning('Please enter a answer');
		return;
		}
		centerPopup('loading');
		//load popup
		loadPopup('loading');
		$("#loading").show();
		$.ajax({
		type: "POST",
		url: "changeSecurityQuestion.php",
		data: { securityQuestionId: securityQuestionId, answer: $('#securityAnswer').val()},
		}).done(function(data) { 
		disablePopup();
		$("#loading").hide();
	//	alert(data);
		$('#securityAnswer').val("");
		if(data=='wrongPassword'){
		Notifier.warning('Wrong password');
		}else if(data=='success'){
		Notifier.success('Security Question changed');
		//alert(securityQuestionId);
        disablePopup();
		}else if(data=='fail')
		Notifier.error('Security Question change failed');
		});
				
			
		});
		
		
		$('#securityQuesSelect').change(function() 
		{
			//$('#securityQuesSelect').attr('value', 'asd');
			securityQuestionId=$(this).attr('value');
			//alert(securityQuestionId);
		   //alert('Value change to ' + $(this).attr('value'));
		});
		 
	 $("#updatePassword").click(function(){
		
		if($('#newPassword').val()==''||$('#newPassword').val()==''||$('#reNewPassword').val()==''){
		Notifier.warning('Please enter all values');
		return;
		}
		
		if($('#newPassword').val()!=$('#reNewPassword').val()){
		Notifier.warning('Passwords doesn`t match');
		return;
		}
		centerPopup('loading');
		//load popup
		loadPopup('loading');
		$("#loading").show();
		$.ajax({
		type: "POST",
		url: "changeUserPassword.php",
		data: { currentPassword: $('#currentPassword').val(), newPassword: $('#newPassword').val()},
		}).done(function(data) { 
		disablePopup();
		$("#loading").hide();
	
		//alert(data);
		if(data=='wrongPassword'){
		Notifier.warning('Wrong password');
		}else if(data=='success'){
		Notifier.success('Password changed successfully');
        //disablePopup();
		$("#currentPassword").val("");
		$("#newPassword").val("");
		$("#reNewPassword").val("");
		
		}else if(data=='fail')
		Notifier.error('Password change failed');
		});
		//centering with css
		//centerPopup('displayaddnewuser');
		//load popup
		//loadPopup('displayaddnewuser');
	});
		
		
	
	 $("#createNewUserButton").click(function(){
	if($('#addNewUserName').val()=='' ){
	Notifier.warning("Please enter a user name");
	return;
	}
	if($('#addNewPsid').val()=='' ){
	Notifier.warning("Please enter a valid PSID");
	return;
	}
 	if($('#newSupervisor').val()==''){
	Notifier.warning("Please enter a supervisor name");
	return;
	}
	if($('#addNewUserFirstName').val()=='' ){
	Notifier.warning("Please enter a valid First Name");
	return;
	}
	if($('#addNewUserLastName').val()=='' ){
	Notifier.warning("Please enter a valid Last Name");
	return;
	}
	centerPopup('loading');
		//load popup
	loadPopup('loading');
	$("#loading").show();
	//	
	//	
		
		$.ajax({
		type: "POST",
		url: "addNewUser.php",
		data: { firstName: $('#addNewUserFirstName').val(),lastName:$('#addNewUserLastName').val(),userName: $('#addNewUserName').val(), supervisor: $('#newSupervisor').val() ,userType: newUserType, psid: $('#addNewPsid').val() },
		}).done(function(data) {
		disablePopup();
		$("#loading").hide();		
		//alert(data);
		if(data=='supervisorError'){
		Notifier.warning('Supervisor does not exist or user is not supervisor');
		}else if(data=='userexists'){
		Notifier.warning('User already exists');
		}else if(data=='success'){
		Notifier.success('User created');
        disablePopup();
		}else if(data=='fail')
		Notifier.error('User creation failed');
		});
		//centering with css
		//centerPopup('displayaddnewuser');
		//load popup
		//loadPopup('displayaddnewuser');
	});
	
	$("#createNewRequestButton").click(function(){
	disablePopup();
	
	if($('#newRequestSource').val() ==''){
	Notifier.warning("Please enter value for Source");
	return;
	}	
	
	if($('#newRequestDestination').val()==''){
	Notifier.warning("Please enter value for Destination");
	return;
	}
	
	if($('#newRequestFromDate').val()==''){
	Notifier.warning("Please enter value for From date");
	return;
	}
	
	if($('#newRequestToDate').val()==''){
	Notifier.warning("Please enter value for Todate");
	return;
	}
	
	if( (new Date($('#newRequestFromDate').val()).getTime() > new Date($('#newRequestToDate').val()).getTime()))
	{
	Notifier.warning("Start Date is after End Date");
	return;
	}
	
	if($('#newRequestPurpose').val()==''){
	Notifier.warning("Please enter value for purpose");
	return;
	}
	
	if($('#newRequestCost').val()==''){
	Notifier.warning("Please enter value for Cost");
	return;
	}else{
	
	var match =$('#newRequestCost').val().match(/(\d$)/);
		if(!match){
		Notifier.warning("Please enter a numeric value without '$'");
		return;}
	}
	
	if($('#newRequestComments').val()==''){
	Notifier.warning("Please enter value for comments");
	return;
	}
	centerPopup('loading');
		//load popup
	loadPopup('loading');
	$("#loading").show();
		$.ajax({
		type: "POST",
		url: "addNewRequest.php",
		data: { travelType: travelType, source: $('#newRequestSource').val() , destination: $('#newRequestDestination').val(),
		fromDate: $('#newRequestFromDate').val(),ToDate: $('#newRequestToDate').val() , purpose:$('#newRequestPurpose').val() ,
		cost:$('#newRequestCost').val() , comments:$('#newRequestComments').val()},
		}).done(function(data) { 
		//alert(data);
		$("#loading").hide();
		disablePopup();
		if(data=='recordexists'){
		Notifier.warning('Duplicate record');
		Notifier.warning('Please Update already existing record');
		}else if(data=='success'){
		disablePopup();
		Notifier.success('Request submitted');
		
		setTimeout(function(){ window.location="home.php";}, 700);
										
		
		
		
		}else if(data=='fail'){
		disablePopup();
		Notifier.error('Request creation failed');
		}
		
		});
		//centering with css
		//centerPopup('displayaddnewuser');
		//load popup
		//loadPopup('displayaddnewuser');
	});
	$("#duplicateRequestButton").click(function(){
	//alert();
	disablePopup();
	$("#newRequestSource").val($("#editRequestSource").val());
	$("#newRequestDestination").val($("#editRequestDestination").val());
	//$("#newRequestFromDate").val($("#editRequestFromDate").val());
	//$("#newRequestToDate").val($("#editRequestToDate").val());
	$("#newRequestPurpose").val($("#editRequestPurpose").val());
	$("#newRequestCost").val($("#editRequestCost").val());
	$("#newRequestComments").val($("#editRequestComments").val());
	$('#travelTypeFormElement').text(travelType);
		//centering with css
		centerPopup('makerequest');
		//load popup
		loadPopup('makerequest');
	});
	
	$("#editRequestButton").click(function(){
		//alert();
		$.ajax({
		type: "POST",
		url: "updateRequest.php",
		data: { id: $('#editRequestid').val(), travelType: travelType, source: $('#editRequestSource').val() , destination: $('#editRequestDestination').val(),
		fromDate: $('#editRequestFromDate').val(),ToDate: $('#editRequestToDate').val() , purpose:$('#editRequestPurpose').val() ,
		cost:$('#editRequestCost').val() , reason:$('#editRequestComments').val()},
		}).done(function(data) { 
		//alert(data);
		
		if(data=='success'){
		Notifier.success('Request Updated');
		disablePopup();
		window.location="home.php";
		}else if(data=='fail')
		//disablePopup();
		Notifier.error('Request update failed');
		});
		//centering with css
		//centerPopup('displayaddnewuser');
		//load popup
		//loadPopup('displayaddnewuser');
	});
	
	
	$("#clearButton").click(function(){
		//alert();
		});
		
	//Report Generation

	$("#createNewUser").click(function(){
	//alert();
		//centering with css
		centerPopup('displayaddnewuser');
		//load popup
		loadPopup('displayaddnewuser');
	});
	
	
	
	
	$(".reasonsDisplay").click(function(){
	
//	alert($(this).attr('id'));
	$('#popupCommentsTitle').text('Reason');
		$.ajax({
		type: "POST",
		url: "fetchComments.php",
		data: { id: $(this).attr('id'), type: 'comments' },
		}).done(function(data) { 
		//alert(data);
		
		if(data=='fail')
		Notifier.error('User creation failed');
		else
		$('#supervisor_comments').text(data);
		
		});
	
	
	
		//centering with css
		centerPopup('displaycomments');
		//load popup
		loadPopup('displaycomments');
	});
	
	
	$(".commentsDisplay").click(function(){
	$('#popupCommentsTitle').text('Comments');
	//alert($(this).attr('id'));
	
		$.ajax({
		type: "POST",
		url: "fetchComments.php",
		data: { id: $(this).attr('id'), type: 'comments'  },
		}).done(function(data) { 
		//alert(data);
		
		if(data=='fail')
		Notifier.error('User creation failed');
		else
		$('#supervisor_comments').text(data);
		
		});
	
	
	
		//centering with css
		centerPopup('displaycomments');
		//load popup
		loadPopup('displaycomments');
	});
	$(".requestInformation").click(function(){
	//$('#popupCommentsTitle').text('Comments');
	//alert($(this).find('span').text());

	
			$.getJSON('fetchUserRecordsWithId.php', {id: $(this).find('span').text() }, function(data) {
		  //var items = [];

		$.each(data, function(key, val) {
		//	items.push('<li id="' + key + '">' + val + '</li>');
			if(key=='id'){
			$('#RequestInformationid').val(val);
			}
			if(key=='datefrom'){
			$('#RequestInformationFromDate').val(val);
			}
			if(key=='dateto'){
			$('#RequestInformationToDate').val(val);
			}
			if(key=='placefrom'){
			$('#RequestInformationSource').val(val);
			}
			if(key=='placeto'){
			$('#RequestInformationDestination').val(val);
			}
			if(key=='traveltype'){
			travelType=val;
			$('#RequestInformationTravel1').val(val);
			//alert(val);
			}
			if(key=='cost'){
			$('#RequestInformationCost').val(val);
			}
			if(key=='reason'){
			$('#').val(val);
			}
			if(key=='purpose'){
			$('#RequestInformationPurpose').val(val);
			}
			
			
		  });
		
			//alert(data);
		});
	
	
	
	
		/*$.ajax({
		type: "POST",
		url: "fetchComments.php",
		data: { id: $(this).attr('id'), type: 'comments'  },
		}).done(function(data) { 
		//alert(data);
		
		if(data=='fail')
		Notifier.error('User creation failed');
		else
		$('#supervisor_comments').text(data);
		
		});
		*/
		
	
		//centering with css
		centerPopup('informationDisplay');
		//load popup
		loadPopup('informationDisplay');
	});
	
	
	
	/*$("#popupOnHold").click(function(){
	if($("#supervisor_comments_popup").val()==""){
	Notifier.error('Please enter a comment');
	return;
	}
	});*/
	
	
	$(".del").click(function(){
	//alert( $(this).parent().parent().find(".reasonsDisplay").attr('id'));
	var id=$(this).parent().parent().find(".reasonsDisplay").attr('id');
	$.ajax({
		type: "POST",
		url: "fetchComments.php",
		data: { id:  $(this).parent().parent().find(".reasonsDisplay").attr('id'), type: 'comments'  },
		}).done(function(data) { 
		//alert(data);
		
		if(data=='fail')
		Notifier.error('Retriving reason failed');
		else{
		$('#reasonRequest').text(data);
		
				$("#popupOnHold").click(function(){
				if($("#supervisor_comments_popup").val()==""){
				Notifier.error('Please enter a comment');
				return;
				}
				$.ajax({
					type: "POST",
					url: "updateComments.php",
					data: { id:  id, comments: $("#supervisor_comments_popup").val(), action: 'On Hold'  },
					}).done(function(data) { 
					//alert(data);
					
					if(data=='fail')
					Notifier.error('Request action failed');
					else if(data=='success')
					Notifier.success('Request On Hold');
					window.location="home.php";
					disablePopup();
					
					});
		
		
				});
		
			$("#popupOnDecline").click(function(){
				if($("#supervisor_comments_popup").val()==""){
				Notifier.error('Please enter a comment');
				return;
				}
				$.ajax({
					type: "POST",
					url: "updateComments.php",
					data: { id:  id, comments: $("#supervisor_comments_popup").val(), action: 'declined'  },
					}).done(function(data) { 
					//alert(data);
					
					if(data=='fail')
					Notifier.error('Request action failed');
					else if(data=='success')
					Notifier.success('Request Declined');
					window.location="home.php";
					disablePopup();
					
					});
		
		
				});
				
		}
		
		});
	
		//centering with css
		centerPopup('comments');
		//load popup
		loadPopup('comments');
	});
	
	$("#createRequest").click(function(){
	$('#travelTypeFormElement').text(travelType);
		//centering with css
		centerPopup('makerequest');
		//load popup
		loadPopup('makerequest');
	});
	
	$(".editRequest").click(function(){
	var id=$(this).parent().parent().find(".commentsDisplay").attr('id');
	//alert(id);
	

			$.getJSON('fetchUserRecordsWithId.php', {id: $(this).parent().parent().find(".commentsDisplay").attr('id')}, function(data) {
		  //var items = [];

		$.each(data, function(key, val) {
		//	items.push('<li id="' + key + '">' + val + '</li>');
			if(key=='id'){
			$('#editRequestid').val(val);
			}
			if(key=='datefrom'){
			$('#editRequestFromDate').val(val);
			}
			if(key=='dateto'){
			$('#editRequestToDate').val(val);
			}
			if(key=='placefrom'){
			$('#editRequestSource').val(val);
			}
			if(key=='placeto'){
			$('#editRequestDestination').val(val);
			}
			if(key=='traveltype'){
			travelType=val;
			$('#travelTypeEditFormElement').text(val);
			
			}
			if(key=='cost'){
			$('#editRequestCost').val(val);
			}
			if(key=='reason'){
			$('#editRequestComments').val(val);
			}
			if(key=='purpose'){
			$('#editRequestPurpose').val(val);
			}
			
			
		  });
		
			//alert(data);
		});
		//centering with css
		centerPopup('editrequest');
		//load popup
		loadPopup('editrequest');
	});
				
	//CLOSING POPUP
	//Click the x event!
	$("#popupDisplayReportCommentsClose").click(function(){
	//alert();
			$("#1").show();
			$("#2").show();
			$("#travelTypeLocal").show();
			$("#travelTypeInternational").show();
			$("#travelTypeBoth").show();
			$(".NFCheck").show();
			$(".NFCheck NFh").show();
				$(".NFSelect").show();
		disablePopup();
	});
	$("#popupInformationClose").click(function(){
		disablePopup();
	});
	$("#popupContactClose").click(function(){
		disablePopup();
	});
	$("#popupEditContactClose").click(function(){
		disablePopup();
	});
	
	$("#popupCommentsClose").click(function(){
		disablePopup();
	});
	$("#popupDisplayCommentsClose").click(function(){
		disablePopup();
	});
	$("#popupAddNewUserClose").click(function(){
		disablePopup();
	});
	$("#cancelNewUserButton").click(function(){
		disablePopup();
	});
	disablePopup();
	//Click out event!
	$("#backgroundPopup").click(function(){
	
	if(popupLoading==1){
	return;
	}
			$("#1").show();
			$("#2").show();
			$("#travelTypeLocal").show();
			$("#travelTypeInternational").show();
			$("#travelTypeBoth").show();
			$(".NFCheck").show();
			$(".NFCheck NFh").show();
			$(".NFSelect").show();
		disablePopup();
	});
	
	$("#backgroundPopupNewUser").click(function(){
		disablePopup();
	});
	
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
	}; 
    M7();
});