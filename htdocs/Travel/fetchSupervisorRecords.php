<?php

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

$sql="SELECT * FROM $tbl_name WHERE supervisor='".$userName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold'); ";
error_log($sql);

$result=mysql_query($sql);

$count=mysql_num_rows($result);
$_SESSION['supervisorRecordCount']=$count;

$records="";
while($row = mysql_fetch_assoc($result))
{


	$records.="<tr>
        	<td><input type='checkbox' name='supervisorRecordsCheckbox' /></td><td>";
			if($row['approval']=='On Hold'){
			$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else{
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}
            $records.="<td>".$row['datefrom']."</td>
            <td>".$row['dateto']."</td>
			<td>".$row['placefrom']."</td>			
			<td>".$row['placeto']."</td>
			<td>".$row['traveltype']."</td>
            <td>".$row['cost']."$</td>
            <td>".$row['purpose']."</td>
            <td><a href='#' id='".$row['id']."' class='reasonsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            <td><a href='#' class='del'><img src='images/trash.png' alt='' title='' border='0' /></a></td></tr>";

} 
mysql_close();
return $records;

?>