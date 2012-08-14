<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IN ADMIN PANEL | Powered by INDEZINER</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="icon" type="image/ico" href="images/favicon.ico"> 
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="js/notifier.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
 
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

<link rel="stylesheet" type="text/css" href="css/ui.theme.css"/>

<script type="text/javascript" src="js/ddaccordion.js"></script>


<script type="text/javascript" src="js/jquery.progressbar.js"></script>


<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>

<script type="text/javascript" src="js/jpaginate.js"></script>

<script type="text/javascript" src="js/jquery.plupload.queue.js"></script>

<<<<<<< HEAD
<script type="text/javascript" src="js/plupload.full.js"></script>
=======
<script type="text/javascript" src="jquery.plupload.queue.js"></script>

<script type="text/javascript" src="plupload.full.js"></script>

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>

<script type="text/javascript" src="js/logout.js"></script>

<script type="text/javascript" src="js/reports.js"></script>



<script type="text/javascript">
	$(window).load(function(){
		$("#loading").hide();		
	})

	$(document).ready(function() {
		$('.ask').jConfirmAction();
		
		
		$('#budgetInfo').click(function(){
			Notifier.warning('You have used '+ $('#currentBudget').text()+' of your total Budget of '+$('#totalBudget').text());
		});
		
		$('#budgetRefresh').click(function(){
			
			$.ajax({
			type: "POST",
			url: "budgetRefresh.php",
			}).done(function(data) { 
				
				var n=data.split(":");
				
		var text="<span id='currentBudget' style='display:none'>";
		text=text+n[0];
				text=text+"</span>";
				text=text+"<span id='totalBudget' style='display:none'>"+n[1]+"</span>";
				text=text+"<div style='padding-left:120px'><table><tr><td>Budget</td></tr><tr><td><div id='progressbar'></div>";
				text=text+"</td><td><img src='images/update.png' id='budgetRefresh' alt='' title='' border='0' style='padding-left:10px;'/>";
				text=text+"</td></tr></table></div>";
				
				/*var text="<span id='currentBudget' style='display:none'>";
				text=text+n[0];
				text=text+"</span>";
				text=text+"<span id='totalBudget' style='display:none'>"+n[1];
				text=text+"</span><img src='images/update.png' id='budgetRefresh'";
				text=text+" alt='' title='' border='0'/> <div id='progressbar'></div>";*/
				
				
				//$('#budgetMeter').replaceWith("<span id='currentBudget' style='display:none'></span> 
				//[Used] / <span id='totalBudget' style='display:none'></span><img src='images/update.png' id='budgetRefresh' alt='' //title='' border='0'/> <div id='progressbar'></div>");
				
				
				
				$("#progressbar").progressBar(n[0],{ max: n[1], textFormat: 'fraction'} );
				
				
			});	
			
			
		});
		setupPagination($('#userRecordBody'),$('#userRecordsPaginationElement'),$('#current_UserRecords_page'),$('#show_UserRecords_per_page'));
		setupPagination($('#supervisorRecordBody'),$('#supervisorRecordsPaginationElement'),$('#current_SupervisorRecords_page'),$('#show_SupervisorRecords_per_page'));
		setupPagination($('#reportsContents'),$('#reportRecordsPaginationElement'),$('#current_ReportsRecords_page'),$('#show_ReportsRecords_per_page'));
	   $('#userRecordsPaginationElement a').click(function(e) {
		 e.preventDefault();
		 });
		 $('#supervisorRecordsPaginationElement a').click(function(e) {
		 e.preventDefault();
		 });
		
	 $("#progressbar").progressBar($('#currentBudget').text(),{ max: $('#totalBudget').text(), textFormat: 'fraction'} );
  
	});
	
</script>
         <script>
		var justLogged=1;
		var newUserType='user';
		var travelType='Domestic';
		var reportsTravelType='local';
		var reportUserName='{$reportUserName}';
		var securityQuestionId={$securityQuestionId};
		var monthlyReportsYear='';
<<<<<<< HEAD
		var budgetYear='2011-2012';
		//$('#travelTypeFormElement').text('Domestic');
=======
	
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
		
		
	   </script>

		
<script>
  NotifierjsConfig.defaultTimeOut = 2000;
  NotifierjsConfig.position = ["bottom", "right"];
</script>

<<<<<<< HEAD
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<script language="javascript" type="text/javascript" src="js/popup.js"></script>
<script language="javascript" type="text/javascript" src="js/datePicker.js"></script>
=======
<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<script language="javascript" type="text/javascript" src="popup.js"></script>
<script language="javascript" type="text/javascript" src="datePicker.js"></script>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

<script type="text/javascript">
//SETTING UP OUR POPUP  
//0 means disabled; 1 means enabled; 
var popupStatus = 0;

</script>
<<<<<<< HEAD
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/popupform-default.css"/>
<link rel="stylesheet" type="text/css" media="all" href="css/jquery.plupload.queue.css"/>
=======
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />
<link rel="stylesheet" type="text/css" media="all" href="popupform-default.css"/>
<link rel="stylesheet" type="text/css" media="all" href="jquery.plupload.queue.css"/>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

</head>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="images/logo.gif" alt="" title="" border="0" /></a></div>
    
    <div class="right_header" id="titleUserName" >Welcome {$userName},<a href="logout.php" class="logout">Logout</a>
		<div id='budgetMeter'> 
		<span id="currentBudget" style="display:none">{$currentBudget}</span> 
		<span id="totalBudget" style="display:none">{$totalBudget}</span>
		<div style='padding-left:90px'>
		<table><tr><td>Budget</td></tr><tr><td>
		<div id="progressbar"></div>
		</td><td>
		<img src="images/update.png" id='budgetRefresh' alt='' title='' border='0' style="padding-left:10px;"/>
		<img src="images/help.png" id='budgetInfo' alt='' title='' border='0' style="padding-left:10px;"/>
		</td></tr>
		</table>
		</div> 
		</div> 
	
	
	</div>
    <div class="right_header" id="titleUserName" > 
		
		
	</div>    
    </div>
    
    <div class="main_content">
    
                    <div class="menu" >
                    <ul>
                    <li><a style="font-size:14px;" class="current" href="#" onClick="ChangePage('home');">Home</a></li>
                    <li><a style="font-size:14px;" href="#" onClick="ChangePage('settings');">Settings</a></li>
                    <li><a style="font-size:14px;" href="#Reports" onClick="ChangePage('reports');">Reports</a></li>
<<<<<<< HEAD
								
					{if {$smarty.session.profile} eq 'finance'}
					
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('uploadExcel');">Upload</a></li>
					{/if}
					
					{if {$smarty.session.profile} eq 'finance'||{$smarty.session.profile} eq 'president'}
					
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('budget');">Budget</a></li>
					{/if}
                    <li><a style="font-size:14px;" href="#" onClick="ChangePage('help');">Help</a></li>
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('contactus');">Contact Us</a></li>
=======
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('uploadExcel');">Upload</a></li>
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('budget');">Budget</a></li>
					
                    <li><a style="font-size:14px;" href="#">Contact Us</a></li>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content"> 
<?php
$page="templates/home.tpl";
?>	
<div id="pageContent">
   {include file="home.tpl"}
</div>
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
    <div class="footer">
    
    	<div class="left_footer">Travel<a href="http://indeziner.com">++</a></div>
    	<div class="right_footer"><a href="http://indeziner.com"><img src="images/indeziner_logo.gif" alt="" title="" border="0" /></a></div>
    
    </div>
</div>		

<input type="hidden" id="current_UserRecords_page"/>
<input type="hidden" id="show_UserRecords_per_page"/>

<input type="hidden" id="current_SupervisorRecords_page"/>
<input type="hidden" id="show_SupervisorRecords_per_page"/>

<input type="hidden" id="current_ReportsRecords_page"/>
<input type="hidden" id="show_ReportsRecords_per_page"/>

<!-- start of Information Popup -->
		<div id="popupLoading">
		<div id="loading" style="color:Black;display:none">	
			Processing your request, please wait..
		<img src="images/loading_animation.gif" alt="loading.." />
		</div>
		</div>
		<div id="popupInformation">  
			<a id="popupInformationClose">x</a>  
			<h1>Your Request</h1>  
			<div class="form">
         <form action="" id="RequestInformationPopupform" method="post" class="niceform">
		   <Table>
		   <tr>
		   <td>ID</td>
		   <td><input type="text" id="RequestInformationid" readonly="readonly" /></td>   
		   </tr>
		   
		   <tr>
				<td>Type of Travel</td>
			   <td>
				<input type="text" id="RequestInformationTravel1" readonly="readonly" />
			   </td>   
		   </tr>
		   
	
		   
		   <tr>
		   <td>Origin</td>
		   <td><input type="text" id="RequestInformationSource" readonly="readonly"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Destination</td>
		   <td><input type="text" id="RequestInformationDestination" readonly="readonly" /></td>   
		   </tr>

		   <tr>
		   <td>From Date</td>
		   <td><p><input type="text" id="RequestInformationFromDate" readonly="readonly"/></p></td>   
		   </tr>
		   
		   <tr>
		   <td>To Date</td>
		   <td><p><input type="text" id="RequestInformationToDate" readonly="readonly"/></p></td>   
		   </tr>
		   
		   <tr>
		   <td>Purpose</td>
		   <td><input type="text" id="RequestInformationPurpose" readonly="readonly"/></td>   
		   </tr>
		   
		   <tr>
		   <td>Cost</td>
		   <td><input type="text" id="RequestInformationCost" readonly="readonly"/></td>   
		   </tr>
		   	   
		   </Table>
		   <Table style="padding-left:50px">
		   <tr>
		   
		  <td></td>
		   
		   </tr>
		   </Table>
         </form>
		 
         </div> 
		</div> 

</body>
</html>