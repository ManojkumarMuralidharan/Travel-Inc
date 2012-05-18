<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IN ADMIN PANEL | Powered by INDEZINER</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" type="image/ico" href="Images/favicon.ico"> 

<script type="text/javascript" src="jquery.min.js"></script>

<script type="text/javascript" src="jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="jquery-ui.css"/>

<link rel="stylesheet" type="text/css" href="ui.theme.css"/>

<script type="text/javascript" src="ddaccordion.js"></script>
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

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>

<script type="text/javascript" src="logout.js"></script>

<script type="text/javascript" src="reports.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>

<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<script language="javascript" type="text/javascript" src="popup.js"></script>
<script language="javascript" type="text/javascript" src="datePicker.js"></script>
<script type="text/javascript">
//SETTING UP OUR POPUP  
//0 means disabled; 1 means enabled; 
var popupStatus = 0;

</script>
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />
<link rel="stylesheet" type="text/css" media="all" href="popupform-default.css"/>
</head>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="images/logo.gif" alt="" title="" border="0" /></a></div>
    
    <div class="right_header" >Welcome {$userName}, <a href="#" class="messages">(3) Messages</a>|<a href="logout.php" class="logout">Logout</a></div>
    
    </div>
    
    <div class="main_content">
    
                    <div class="menu" >
                    <ul>
                    <li><a style="font-size:14px;" class="current" href="#" onClick="ChangePage('home');">Home</a></li>
                    <li><a style="font-size:14px;" href="#">Settings</a></li>
                    <li><a style="font-size:14px;" href="#" onClick="ChangePage('reports');">Reports</a></li>
                    <li><a style="font-size:14px;" href="#">Contact Us</a></li>
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
    
    	<div class="left_footer">IN ADMIN PANEL | Powered by <a href="http://indeziner.com">INDEZINER</a></div>
    	<div class="right_footer"><a href="http://indeziner.com"><img src="images/indeziner_logo.gif" alt="" title="" border="0" /></a></div>
    
    </div>
</div>		
<div id="popupDisplayComments">  
			<a id="popupDisplayCommentsClose">x</a>  
			<h1>Comments</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   
		   <tr>
		   
		   <td><textarea name="comments" id="supervisor_comments" rows="5" cols="36"></textarea></td>
		   </tr>
		   </Table>
         </form>
		 
         </div> 
</div>  
	<div id="popupComments">  
			<a id="popupCommentsClose">x</a>  
			<h1>Decline / On Hold</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   
		   <tr>
		   <td>Comments</td>
		   <td><textarea name="comments" id="supervisor_comments" rows="5" cols="36"></textarea></td>
		   </tr>
		   <tr>
		   <td>Reasons</td>
		   <td><textarea name="Reasons" id="reasonRequest" rows="5" cols="36"></textarea></td>
		   </tr>
		   
		   </Table>
		   <Table style="padding-left:70px"><tr><td>
		   <a href="#" style="position:relative;" class="bt_blue"><span class="bt_blue_lft"></span><strong>OnHold</strong><span class="bt_blue_r"></span></a>
		   </td>
		   

		   <td>
		   <a href="#" style="position:relative;"  class="bt_red ask"><span class="bt_red_lft"></span><strong>Decline</strong><span class="bt_red_r"></span></a> 
		   </td>
		   </tr>
		   </Table>
         </form>
		 
         </div> 
		</div>  
		<div id="popupContact">  
			<a id="popupContactClose">x</a>  
			<h1>Create your Request</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   <tr>
		   <td>Name</td>
		   <td><input type="text" /></td>   
		   </tr>
		   
		   <tr>
		   <td>Type of Travel</td>
		   <td>
		   
		   <div class="NewSelect" onClick="newSelect();"> 
		   <img src="img/0.png" class="NewSelectLeft">
		   <div class="NewSelectRight">Local</div>
			   <div class="NewSelectTarget" id="123" style="display: none; ">
				   <ul class="NewSelectOptions">
				   <li><a href="javascript:;">Local</a></li>
				   <li><a href="javascript:;">International</a></li>
				   </ul>
			   </div>
		   </div>
		 
		  
		   
		   </td>   
		   </tr>
		   
		   <tr>
		   <td>From</td>
		   <td><input type="text" /></td>   
		   </tr>
		   
		   <tr>
		   <td>To</td>
		   <td><input type="text" /></td>   
		   </tr>
		   
		   <tr>
		   <td>Purpose</td>
		   <td><input type="text" /></td>   
		   </tr>
		   
		   <tr>
		   <td>Cost</td>
		   <td><input type="text" /></td>   
		   </tr>
		   
		   <tr>
		   <td>Comments</td>
		   <td><textarea name="comments" id="comments" rows="5" cols="36"></textarea></td>
		   </tr>
		   
		   
		   </Table>
		   <Table style="padding-left:150px"><tr><td>
		   <input type="submit" name="submit" id="submit" value="Submit" /></td>
		   </td></tr>
		   </Table>
         </form>
		 
         </div> 
		</div>  
	<div id="backgroundPopup"></div>  
</body>
</html>