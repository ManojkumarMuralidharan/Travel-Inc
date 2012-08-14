<?php

//require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();
/*echo "<tr>
        	<td><input type="checkbox" name=""' /></td>
            <td>#12345</td>
            <td>12/05/2010</td>
            <td>12/05/2010</td>
            <td>Mumbai,India</td>
			<td>Washington</td>
			<td>International</td>
            <td>1500$</td>
            <td>12/05/2010</td>
            <td><a href='#' class='commentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td><a href='#'><img src='images/user_edit.png' alt='' title='' border='0' /></a></td>
           
        </tr>";
<<<<<<< HEAD

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name
=======
*/
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$recordType=$_GET[
$userName=$_POST["userName"];
$_SESSION['username']=$userName;
//$supervisor=$_SESSION["supervisor"];
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."'; ";
error_log($sql);

$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
<<<<<<< HEAD
			$sql="SELECT `idsecurityquestion` FROM $tbl_name WHERE username='".$userName."';";
								$result=mysql_query($sql);
								$count=mysql_num_rows($result);
								if($count==1){
									$securityid=mysql_result($result,0,"idsecurityquestion");
=======
			$sql="SELECT securityid FROM $tbl_name WHERE username='".$userName."';";
								$result=mysql_query($sql);
								$count=mysql_num_rows($result);
								if($count==1){
									$securityid=mysql_result($result,0,"securityid");
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
									//$result=mysql_query($sql);
									//echo $profile;
									//$_SESSION['securityId']=$securityid;
									
<<<<<<< HEAD
										$sql="SELECT `securityquestion` FROM securityquestion WHERE idsecurityquestion ='".$securityid."';";
										$result=mysql_query($sql);
										$count=mysql_num_rows($result);
										if($count==1){
											$securityQuestionContent=mysql_result($result,0,"securityquestion");
											
=======
										$sql="SELECT questions FROM securityquestions WHERE securityId='".$securityid."';";
										$result=mysql_query($sql);
										$count=mysql_num_rows($result);
										if($count==1){
											$securityQuestionContent=mysql_result($result,0,"questions");
											
											//echo '<table><tr><td>Question</td><td>'.$securityQuestionContent.'</td></tr><tr><td></td><td><input type="button" name="submit" id="resetPassword" value="ResetPassword" /></td></tr></table>';
											
/*										echo '<fieldset>
											<dl>
												<dt><label for="email">SecurityQuestion:</label></dt>
												<dd><span>'.$securityQuestionContent.'</span></dd>
											</dl>
											<dl>
												<dt><label for="Answer">Answer:</label></dt>
												<dd><input type="text" name="text" id="passwordAnswer" size="54" /></dd>
											</dl>
											
											 <dl class="submit">
											<input type="button" name="submit" id="resetPassword" value="ResetPassword" />
											 </dl>
											<dl class="" style="color:red;font-size:13px;padding-left:300px;">
											<span name="loginComment" id="loginComment" value="" />
											 </dl>
                    
											</fieldset>'; */
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
											
										echo '<fieldset>
												<dl>
													<dt><label for="email">SecurityQuestion:</label></dt>
													<dd><img src="img/0.png" class="NFSpanLeft"><label class="check_label">'.$securityQuestionContent.'</label><img src="img/0.png" class="NFSpanRight"></dd>
												</dl>
												<dl>
													<dt><label for="Answer">Answer:</label></dt>
													<dd><img src="img/0.png" class="NFTextLeft"><div class="NFTextCenter"><input type="text" name="text" id="passwordAnswer" size="54" class="NFText" /></div><img src="img/0.png" class="NFTextRight"></dd>
												</dl>
												
												 <dl class="submit">
<<<<<<< HEAD
												<img class="NFButtonLeft" src="img/0.png"><input type="button" name="submit" style="width:150px" id="resetPassword" value="ResetPassword" class="NFButton"><img src="img/0.png" class="NFButtonRight">
=======
												<img class="NFButtonLeft" src="img/0.png"><input type="button" name="submit" id="resetPassword" value="ResetPassword" class="NFButton"><img src="img/0.png" class="NFButtonRight">
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
												 </dl>
												<dl class="" style="color:red;font-size:13px;padding-left:300px;">
												<span name="loginComment" id="loginComment" value="">
												 </span></dl>
												
											</fieldset>';												
											
										}else{
											echo "fail";
										}
									
									
									
								}else{
									mysql_close();
									//`profile` field error
									echo "fail";
								}
}else{
	mysql_close();
	echo "fail";
}

?>