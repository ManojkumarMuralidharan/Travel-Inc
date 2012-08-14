    
    
    
     
   
	
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
{$securityQuestions}

</select></td></tr>
<tr><td>Answer</td><td><input id="securityAnswer" type="text" length="15";/></td></tr>
<tr><td> </td><td>
<<<<<<< HEAD
<div style="align:center;padding-top:0px;">
	 
	 <a href="#" style="position:relative;" id="securityQuesConfirm" class="bt_green"><span class="bt_green_lft"></span><strong>Confirm</strong><span class="bt_green_r"></span></a>
    
 </div> 
</td></tr>

 {if {$smarty.session.profile} eq 'supervisor' || {$smarty.session.profile} eq 'finance' || {$smarty.session.profile} eq 'hr' || {$smarty.session.profile} eq 'president'}
	 <tr><td style="padding-top:40px;padding-bottom:10px;"><h2>Add new User</h2> </td><td style="padding-top:30px;padding-bottom:10px;">
	
	 <a href="#" id="createNewUser" style="position:relative;" class="bt_green"><span class="bt_green_lft"></span><strong>Add User</strong><span class="bt_green_r"></span></a></td></tr>
	 {/if}


=======
<div style="align:center;padding-top:30px;">
	 
	 <a href="#" style="position:relative;" id="securityQuesConfirm" class="bt_green"><span class="bt_green_lft"></span><strong>Confirm</strong><span class="bt_green_r"></span></a>
     {if {$smarty.session.profile} eq 'supervisor'}
	 <a href="#" id="createNewUser" style="position:relative;" class="bt_green"><span class="bt_green_lft"></span><strong>Add User</strong><span class="bt_green_r"></span></a>
	 {/if}
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
	
=======
              
      <div id="backgroundPopupNewUser"></div>  
    
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
