<?php


$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name

//$recordType=$_GET[
$userName=$_SESSION["id"];

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
while($row = mysql_fetch_assoc($result))
{

if($row['approval']=='Declined'){
$records.="<tr class='rounded-corner-declined' >";
}else{
$records.="<tr>";
}
	
        $records.="<td><input type='checkbox' name='' /></td>
            <td>#".$row['id']."</td>
            <td>".$row['datefrom']."</td>
            <td>".$row['dateto']."</td>
			<td>".$row['placefrom']."</td>			
			<td>".$row['placeto']."</td>
			<td>".$row['traveltype']."</td>
            <td>".$row['cost']."$</td>
            <td>".$row['purpose']."</td>
            <td><a href='#' id='".$row['id']."' class='commentsDisplay' ><img  src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td><a href='#' class='editRequest'><img  src='images/user_edit.png' alt='' title='' border='0' /></a></td></tr>";

} 
mysql_close();
return $records;

?>