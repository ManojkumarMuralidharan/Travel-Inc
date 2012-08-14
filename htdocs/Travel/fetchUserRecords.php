<?php

<<<<<<< HEAD
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
=======
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
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$recordType=$_GET[
$userName=$_SESSION["username"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

<<<<<<< HEAD


$sql="SELECT iduser FROM user WHERE username='$userName' ";
$result=mysql_query($sql);

$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");

$sql="SELECT * FROM $tbl_name WHERE iduser='".$iduser."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'declined') ORDER BY `idexpenserecords` DESC ;  ";
=======
$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Declined');  ";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
error_log($sql);

$result=mysql_query($sql);

$count=mysql_num_rows($result);
$_SESSION['userRecordCount']=$count;

$records="";
$declinedRecords="";
$row_class="";
while($row = mysql_fetch_assoc($result))
{

<<<<<<< HEAD
if($row['approval']=='declined'){
=======
if($row['approval']=='Declined'){
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$declinedRecords=" class='declined'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BBFCD6;color:#FFFFFF'";
}
else{
$declinedRecords="";
}
<<<<<<< HEAD
	error_log($row['idexpenserecords']);
        $records.="<tr style='display' >"."<td ".$declinedRecords." ><input type='checkbox' name='userRecordsCheckbox' /></td>
            <td ".$declinedRecords." class='requestInformation' >";
			if($row['approval']=='declined'){
			$records.="<img src='images\denied.gif'  alt='' title='' border='0' />#<span style='text-decoration:underline;'  id='".$row['idexpenserecords']."'>".$row['idexpenserecords']."</span></td>";
			}else{
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' />#<span style='text-decoration:underline;'  id='".$row['idexpenserecords']."'>".$row['idexpenserecords']."</span></td>";
			}
			$records.="<td ".$declinedRecords." >".$row['fromdate']."</td>
            <td  ".$declinedRecords. ">".$row['todate']."</td>
			<td ".$declinedRecords." >".$row['placefrom']."</td>			
			<td ".$declinedRecords." >".$row['placeto']."</td>";
			if($row['idtraveltype']==1){
			$records.="<td ".$declinedRecords.">"."Domestic"."</td>";			
			}else if($row['idtraveltype']==2){
			$records.="<td ".$declinedRecords.">"."International"."</td>";
			}else{
			$records.="<td ".$declinedRecords.">"."Unknown"."</td>";
			}
            $records.="<td ".$declinedRecords." >$".$row['cost']."</td>
            <td ".$declinedRecords." >".substr($row['comments'], 0, 10)."...</td>";
			/*if($row['approval']=='declined'){
			$records.="<td ".$declinedRecords." ><a href='#' id='".$row['idexpenserecords']."' class='commentsDisplay' ><img  src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td ".$declinedRecords." ><a href='#'></a></td></tr>";
			}else{*/
            $records.="<td ".$declinedRecords." ><a href='#' id='".$row['idexpenserecords']."' class='commentsDisplay' ><img  src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td ".$declinedRecords." ><a href='#' class='editRequest'><img  src='images/user_edit.png' alt='' title='' border='0' /></a></td></tr>";
			//}
=======
	
        $records.="<tr style='display' >"."<td ".$declinedRecords." ><input type='checkbox' name='userRecordsCheckbox' /></td>
            <td ".$declinedRecords." >";
			if($row['approval']=='Declined'){
			$records.="<img src='images\denied.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else{
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}
			$records.="<td ".$declinedRecords." >".$row['datefrom']."</td>
            <td  ".$declinedRecords. ">".$row['dateto']."</td>
			<td ".$declinedRecords." >".$row['placefrom']."</td>			
			<td ".$declinedRecords." >".$row['placeto']."</td>
			<td ".$declinedRecords." >".$row['traveltype']."</td>
            <td ".$declinedRecords." >".$row['cost']."$</td>
            <td ".$declinedRecords." >".$row['purpose']."</td>";
			if($row['approval']=='Declined'){
			$records.="<td ".$declinedRecords." ><a href='#' id='".$row['id']."' class='commentsDisplay' ><img  src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td ".$declinedRecords." ><a href='#'></a></td></tr>";
			}else{
            $records.="<td ".$declinedRecords." ><a href='#' id='".$row['id']."' class='commentsDisplay' ><img  src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td ".$declinedRecords." ><a href='#' class='editRequest'><img  src='images/user_edit.png' alt='' title='' border='0' /></a></td></tr>";
			}
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
} 
mysql_close();
return $records;

?>