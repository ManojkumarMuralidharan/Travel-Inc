<<<<<<< HEAD
<?php /* Smarty version Smarty-3.1.8, created on 2012-07-31 23:26:09
=======
<?php /* Smarty version Smarty-3.1.8, created on 2012-05-31 23:10:46
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
         compiled from ".\templates\forgotPassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:216474fbe8bafc02c80-85033361%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54fd4ba794faf2120633406a773728ddd79c9184' => 
    array (
      0 => '.\\templates\\forgotPassword.tpl',
<<<<<<< HEAD
      1 => 1343769965,
=======
      1 => 1338498643,
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
      2 => 'file',
    ),
  ),
  'nocache_hash' => '216474fbe8bafc02c80-85033361',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fbe8bafc83ae0_14782686',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fbe8bafc83ae0_14782686')) {function content_4fbe8bafc83ae0_14782686($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IN ADMIN PANEL | Powered by INDEZINER</title>
<<<<<<< HEAD
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/notifier.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>
=======
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="notifier.js"></script>
<script type="text/javascript" src="ddaccordion.js"></script>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
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

<<<<<<< HEAD
<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
=======
<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e



<script>
  NotifierjsConfig.defaultTimeOut = 2000;
  NotifierjsConfig.position = ["bottom", "right"];
</script>

<<<<<<< HEAD

<script language="javascript" type="text/javascript" src="js/popup-login.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/popupform-default.css" />


<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<script language="javascript" type="text/javascript" src="js/reports.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />
=======
<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<script language="javascript" type="text/javascript" src="reports.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
		
		
		
		 $("#getSecurityQuestion").click(function(){
		 // alert('Submitted');
		  $.ajax({
			type: "POST",
			url: "fetchSecurityIdNoSession.php",
			data: { userName: $("#userName").val(), } ,
			success: function(response)
			{
			    //alert(response);
				if(response == 'success'){
					 $.ajax({
					type: "POST",
					url: "fetchSecurityQuestionNoSession.php",
					data: { userName: $("#userName").val(), } ,
					success: function(response)
					{
						//alert(response);
						if(response=='fail')
						Notifier.error('Username does not exist');
						else{
						$('#securityQuestionContent').replaceWith(response);
						var NF = new niceform($('#securityQuestionContent'));
<<<<<<< HEAD
						//  return true;
						//	alert(NF);
						}
							  $("#resetPassword").click(function(){
								  Notifier.success('Please wait, password Resetting');
								 // $('#resetPassword').attr("disabled", true);
								  	centerPopup('loading');
										//load popup
									loadPopup('loading');
																  
								  $.ajax({
									type: "POST",
									url: "resetPassword.php",
									data: { answer: $('#passwordAnswer').val(),  } ,
									success: function(response)
									{
									disablePopup();
									$("#loading").hide();									


									//$('#resetPassword').attr("disabled", false);
										//alert(response);
										if(response == 'success'){
										Notifier.success('Password reset');
										Notifier.success('A e-mail notification has been sent');
										setTimeout(function(){ Notifier.success('Please wait while we redirect you to our site');}, 1000);
										
										
										
										setTimeout(function(){ window.location = "index.php";}, 5000);
										
										}
										else if(response=='wrongAnswer')
										Notifier.error('Password reset failed');
										
									}
								   });

									 return false;
=======
						//	alert(NF);
						}
							  $("#resetPassword").click(function(){
							 // Notifier.success('password Resetting');
							  $.ajax({
								type: "POST",
								url: "resetPassword.php",
								data: { answer: $('#passwordAnswer').val(),  } ,
								success: function(response)
								{
									//alert(response);
									if(response == 'success'){
									Notifier.success('Password reset');
									Notifier.success('A e-mail notification has been sent');
									setTimeout(function(){ Notifier.success('Please wait while we redirect you to our site');}, 1000);
									
									
									
									setTimeout(function(){ window.location = "index.php";}, 5000);
									
									}
									else if(response=='wrongAnswer')
									Notifier.error('Password reset failed');
									
								}
							   });

							     return false;
							  
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
							  });
					}
					});
				
				}
				else if(response=='fail')
				Notifier.error('Username does not exist');
				
			}
		});

		return false;
		  
		  });
		  
		 
		  
		  
		  
		  
	});
	
</script>

</head>
<body>
<div id="main_container">

	<div class="header_login">
    <div class="logo"><a href="#"><img src="images/logo.gif" alt="" title="" border="0" /></a></div>
    
    </div>

     
         <div class="login_form">
         
         <h3>Travel Manager - Retrive Password </h3>
         
         <form action="" method="post" id="securityQuestionContent" class="niceform" method="post" >
         
                <fieldset >
                    <dl>
                        <dt><label for="email">Username:</label></dt>
                        <dd><input type="text" name="userName" id="userName" size="54" /></dd>
                    </dl>

                     <dl class="submit">
<<<<<<< HEAD
					<input type="button" name="submit" id="getSecurityQuestion" style="width:150px;" value="Security Question " />
=======
					<input type="button" name="submit" id="getSecurityQuestion" value="AnswerSecurityQuestion" />
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
                     </dl>
					<dl class="" style="color:red;font-size:13px;padding-left:300px;">
                    <span name="loginComment" id="loginComment" value="" />
                     </dl>
                    
                </fieldset>
                
         </form>
         </div>  
          <script>
		 
		  </script>
	
    
    <div class="footer_login">
    
    	<div class="left_footer_login">Travel <a href="">Travel</a></div>
    	<div class="right_footer_login"><a href="http://indeziner.com"><img src="images/indeziner_logo.gif" alt="" title="" border="0" /></a></div>
    
    </div>

<<<<<<< HEAD
	
<!-- start of Information Popup -->
		<div id="popupLoading">
		<div id="loading" style="color:black;display:BLOCK">	
			Processing your request, please wait..
		<img src="images/loading_animation.gif" alt="loading.." />
		</div>
		</div>
</div>	

	
	
	<div id="backgroundPopup"></div>  
	
=======
</div>		
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
</body>
</html><?php }} ?>