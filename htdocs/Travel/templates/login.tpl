<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IN ADMIN PANEL | Powered by INDEZINER</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="notifier.js"></script>
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



<script>
  NotifierjsConfig.defaultTimeOut = 2000;
  NotifierjsConfig.position = ["bottom", "right"];
</script>

<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />

<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
		 $("#submit").click(function(){
		 if($("#userName").val()==''||$("#password").val() ==''){
		 Notifier.warning("Please enter the credentials");
		 return;
		 }
		 // alert('Submitted');
		  $.ajax({
			type: "POST",
			url: "login_check.php",
			data: { userName: $("#userName").val(), password: $("#password").val() } ,
			success: function(response)
			{
			   // alert(response);
				if(response == 'success'){
				//alert(response);
				//Notifier.success('Login successful');
				setTimeout(function() {
				window.location = "home.php";
				}, 0);
			//	window.location = "home.php";
				}
				else if(response=='fail')
				Notifier.error('Login Failed');
				
				//window.location = "home.php";
					
				
				//alert(response);
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
         
         <h3>Travel Manager </h3>
         
         <a href="forgotPassword.php" class="forgot_pass">Forgot password</a> 
         
         <form action="login_check.php" method="post" class="niceform" method="post" >
         
                <fieldset>
                    <dl>
                        <dt><label for="email">Username:</label></dt>
                        <dd><input type="text" name="userName" id="userName" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">Password:</label></dt>
                        <dd><input type="text" name="password" id="password" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                    <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Remember me</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="button" name="submit" id="submit" value="Login" />
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

</div>		
</body>
</html>