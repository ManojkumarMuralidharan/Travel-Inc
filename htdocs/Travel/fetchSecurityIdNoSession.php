<?php

//require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
//session_start();
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
*/
<<<<<<< HEAD
/*
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name
=======
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$recordType=$_GET[
$userName=$_POST["userName"];

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
			error_log($sql);
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
									//echo $profile;
									//$_SESSION['securityId']=$securityid;
									//$result=mysql_query($sql);
									mysql_close();
									echo "success";
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