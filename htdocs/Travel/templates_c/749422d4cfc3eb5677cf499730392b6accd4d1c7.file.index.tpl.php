<?php /* Smarty version Smarty-3.1.8, created on 2012-06-18 21:02:20
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:228624fb40c7e6398b3-47310342%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1340046076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '228624fb40c7e6398b3-47310342',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fb40c7e6cbdb0_53961752',
  'variables' => 
  array (
    'securityQuestionId' => 0,
    'userName' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fb40c7e6cbdb0_53961752')) {function content_4fb40c7e6cbdb0_53961752($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IN ADMIN PANEL | Powered by INDEZINER</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" type="image/ico" href="Images/favicon.ico"> 
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="notifier.js"></script>
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

<script type="text/javascript" src="jpaginate.js"></script>

<script type="text/javascript" src="jquery.plupload.queue.js"></script>

<script type="text/javascript" src="plupload.full.js"></script>

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>

<script type="text/javascript" src="logout.js"></script>

<script type="text/javascript" src="reports.js"></script>


<script type="text/javascript">
	

	$(document).ready(function() {
		$('.ask').jConfirmAction();
	
		setupPagination($('#userRecordBody'),$('#userRecordsPaginationElement'),$('#current_UserRecords_page'),$('#show_UserRecords_per_page'));
		setupPagination($('#supervisorRecordBody'),$('#supervisorRecordsPaginationElement'),$('#current_SupervisorRecords_page'),$('#show_SupervisorRecords_per_page'));
		setupPagination($('#reportsContents'),$('#reportRecordsPaginationElement'),$('#current_ReportsRecords_page'),$('#show_ReportsRecords_per_page'));
	   $('#userRecordsPaginationElement a').click(function(e) {
		 e.preventDefault();
		 });
		 $('#supervisorRecordsPaginationElement a').click(function(e) {
		 e.preventDefault();
		 });

 
	});
	
</script>
         <script>
		var justLogged=1;
		var newUserType='user';
		var travelType='local';
		var reportsTravelType='local';
		var reportUserName='';
		var securityQuestionId=<?php echo $_smarty_tpl->tpl_vars['securityQuestionId']->value;?>
;
		var monthlyReportsYear='';
	
		
		
	   </script>

		
<script>
  NotifierjsConfig.defaultTimeOut = 2000;
  NotifierjsConfig.position = ["bottom", "right"];
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
<link rel="stylesheet" type="text/css" media="all" href="jquery.plupload.queue.css"/>

</head>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="#"><img src="images/logo.gif" alt="" title="" border="0" /></a></div>
    
    <div class="right_header" id="titleUserName" >Welcome <?php echo $_smarty_tpl->tpl_vars['userName']->value;?>
, <a href="#" class="messages">(3) Messages</a>|<a href="logout.php" class="logout">Logout</a></div>
    
    </div>
    
    <div class="main_content">
    
                    <div class="menu" >
                    <ul>
                    <li><a style="font-size:14px;" class="current" href="#" onClick="ChangePage('home');">Home</a></li>
                    <li><a style="font-size:14px;" href="#" onClick="ChangePage('settings');">Settings</a></li>
                    <li><a style="font-size:14px;" href="#Reports" onClick="ChangePage('reports');">Reports</a></li>
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('uploadExcel');">Upload</a></li>
					<li><a style="font-size:14px;" href="#" onClick="ChangePage('budget');">Budget</a></li>
					
                    <li><a style="font-size:14px;" href="#">Contact Us</a></li>
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content"> 
<<?php ?>?php
$page="templates/home.tpl";
?<?php ?>>	
<div id="pageContent">
   <?php echo $_smarty_tpl->getSubTemplate ("home.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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

</body>
</html><?php }} ?>