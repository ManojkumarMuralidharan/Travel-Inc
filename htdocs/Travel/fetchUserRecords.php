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
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name

//$recordType=$_GET[
$userName=$_SESSION["username"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Declined');  ";
error_log($sql);

$result=mysql_query($sql);

$count=mysql_num_rows($result);
$_SESSION['userRecordCount']=$count;

$records="";
$declinedRecords="";
$row_class="";
while($row = mysql_fetch_assoc($result))
{

if($row['approval']=='Declined'){

$declinedRecords=" class='declined'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BBFCD6;color:#FFFFFF'";
}
else{
$declinedRecords="";
}
	
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
} 
mysql_close();
return $records;

?>