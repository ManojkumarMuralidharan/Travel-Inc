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

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name

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
			$sql="SELECT `idsecurityquestion` FROM $tbl_name WHERE username='".$userName."';";
								$result=mysql_query($sql);
								$count=mysql_num_rows($result);
								if($count==1){
									$securityid=mysql_result($result,0,"idsecurityquestion");
									//$result=mysql_query($sql);
									//echo $profile;
									//$_SESSION['securityId']=$securityid;
									
										$sql="SELECT `securityquestion` FROM securityquestion WHERE idsecurityquestion ='".$securityid."';";
										$result=mysql_query($sql);
										$count=mysql_num_rows($result);
										if($count==1){
											$securityQuestionContent=mysql_result($result,0,"securityquestion");
											
											
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
												<img class="NFButtonLeft" src="img/0.png"><input type="button" name="submit" style="width:150px" id="resetPassword" value="ResetPassword" class="NFButton"><img src="img/0.png" class="NFButtonRight">
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