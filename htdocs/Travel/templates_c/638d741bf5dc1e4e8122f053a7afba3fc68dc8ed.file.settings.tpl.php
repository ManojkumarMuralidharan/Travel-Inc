<<<<<<< HEAD
<?php /* Smarty version Smarty-3.1.8, created on 2012-08-07 21:42:48
=======
<?php /* Smarty version Smarty-3.1.8, created on 2012-05-31 20:38:14
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
         compiled from ".\templates\settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32624fba6814c82579-32610785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '638d741bf5dc1e4e8122f053a7afba3fc68dc8ed' => 
    array (
      0 => '.\\templates\\settings.tpl',
<<<<<<< HEAD
      1 => 1344368555,
=======
      1 => 1338489488,
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32624fba6814c82579-32610785',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4fba6814cffc87_01685852',
  'variables' => 
  array (
    'securityQuestions' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4fba6814cffc87_01685852')) {function content_4fba6814cffc87_01685852($_smarty_tpl) {?>    
    
    
     
   
	
    <div class="right_content" >   
	   <script>
	  
	   </script>
    
    
<form id="settings" class="niceform">
<<<<<<< HEAD
<table style="padding-left:0px;" border=0>
=======
<table style="padding-left:0px;">
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
<tr style="padding-top:10px;padding-bottom:20px;"><td><h2>Password</h2></td><td></td></tr>
<tr><td>Current Password </td><td><input id="currentPassword" type="password" length="10" /></td></tr>
<tr><td>New Password </td><td><input id="newPassword" type="password" length="10"/> </td></tr>
<tr><td>Re-type Password </td><td><input id="reNewPassword" type="password" length="10"/></td></tr>
<<<<<<< HEAD
<tr><td></td><td >
=======
<tr><td></td><td>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
		   <a href="#" style="position:relative;" id="clearPassword" class="bt_red"><span class="bt_red_lft"></span><strong>Clear</strong><span class="bt_red_r"></span></a> 
		   <a href="#" style="position:relative;" id="updatePassword" class="bt_green"><span class="bt_green_lft"></span><strong>Update</strong><span class="bt_green_r"></span></a> 

</td></tr>
<tr><td style="padding-top:40px;padding-bottom:10px;"><h2>Security Question</h2> </td><td></td></tr>
<tr><td>Question</td><td><select id="securityQuesSelect" >
<?php echo $_smarty_tpl->tpl_vars['securityQuestions']->value;?>


</select></td></tr>
<tr><td>Answer</td><td><input id="securityAnswer" type="text" length="15";/></td></tr>
<tr><td> </td><td>
<<<<<<< HEAD
<div style="align:center;padding-top:0px;">
	 
	 <a href="#" style="position:relative;" id="securityQuesConfirm" class="bt_green"><span class="bt_green_lft"></span><strong>Confirm</strong><span class="bt_green_r"></span></a>
    
 </div> 
</td></tr>

 <?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp4=ob_get_clean();?><?php if ($_tmp1=='supervisor'||$_tmp2=='finance'||$_tmp3=='hr'||$_tmp4=='president'){?>
	 <tr><td style="padding-top:40px;padding-bottom:10px;"><h2>Add new User</h2> </td><td style="padding-top:30px;padding-bottom:10px;">
	
	 <a href="#" id="createNewUser" style="position:relative;" class="bt_green"><span class="bt_green_lft"></span><strong>Add User</strong><span class="bt_green_r"></span></a></td></tr>
	 <?php }?>


=======
<div style="align:center;padding-top:30px;">
	 
	 <a href="#" style="position:relative;" id="securityQuesConfirm" class="bt_green"><span class="bt_green_lft"></span><strong>Confirm</strong><span class="bt_green_r"></span></a>
     <?php ob_start();?><?php echo $_SESSION['profile'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1=='supervisor'){?>
	 <a href="#" id="createNewUser" style="position:relative;" class="bt_green"><span class="bt_green_lft"></span><strong>Add User</strong><span class="bt_green_r"></span></a>
	 <?php }?>
 </div> 
</td></tr>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
</table>
</form>

     
       
     
    
       
     
     </div><!-- end of right content-->

         <div id="popupAddNewUser">  
			<a id="popupAddNewUserClose">x</a>  
			<h1>Add new user</h1>  
			<div class="form">
         <form action="" method="post" class="niceform">
		   <Table>
		   
		   <tr>
		   <td> User Name:</td><td><input type="text" style="width:170px" id="addNewUserName"  /></td>
		   </tr>
		   <tr>
<<<<<<< HEAD
		   <td> First Name:</td><td><input type="text" style="width:170px" id="addNewUserFirstName"  /></td>
		   </tr>
		   <tr>
		   <td> Last Name:</td><td><input type="text" style="width:170px" id="addNewUserLastName"  /></td>
		   </tr>
		   <tr>
           <td> Supervisor Name:</td><td><div class="ui-widget"><input id="newSupervisor" /></div></td>
		   </tr>
		   <tr>
           <td> PSID :</td><td><div class="ui-widget"><input id="addNewPsid" /></div></td>
		   </tr>
		   <tr>
=======
           <td> Supervisor Name:</td><td><div class="ui-widget"><input id="newSupervisor" /></div></td>
		   </tr>
		   <tr>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
		   <td>Role</td>
		   <td>
		   <div>
		  
					<table>
					 <tr>
					 <td><label class="check_label">Regular</label></td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio NFh" id="addNewUserTypeRegular" onclick="$('#addNewUserTypeRegular').toggleClass('NFh');	
					$('#addNewUserTypeSupervisor').toggleClass('NFh');newUserType='user';" id="1"  style="left: 279px; top: 187px; "></div></td>
					 <td><label style="padding-left:30px;" class="check_label">Supervisor</label>	</td>
					 <td><div style="padding-left:30px;margin-top:-10px;" class="NFRadio" id="addNewUserTypeSupervisor" style="left: 355px; top: 187px; "  onclick="$('#addNewUserTypeSupervisor').toggleClass('NFh');	
					$('#addNewUserTypeRegular').toggleClass('NFh');newUserType='supervisor'"></div></td>
					 </tr>
					 </table>

			</div>
		   </td>
		   </tr>
		   <tr>
		    <td>
			
		   <a href="#" style="position:relative;" id="createNewUserButton" class="bt_green"><span class="bt_green_lft"></span><strong>Create</strong><span class="bt_green_r"></span></a> 
		   </td>
		   <td>
		   <a href="#" style="position:relative;" id="cancelNewUserButton" class="bt_red"><span class="bt_red_lft"></span><strong>Cancel</strong><span class="bt_red_r"></span></a> 
		   </td>
		   </tr>
		   </Table>
         </form>
		 
         </div> 
</div>  

	 
	 
	 
	 
	 
<<<<<<< HEAD
      <div id="backgroundPopupNewUser"></div>  
     <div id="backgroundPopup"></div>  
	<?php }} ?>
=======
              
      <div id="backgroundPopupNewUser"></div>  
    <?php }} ?>
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
