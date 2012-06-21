<?php

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
session_start();
header("Content-Type: text/plain");
//$recordType=$_GET[
$userName=$_SESSION['username'];
//$type='jhy';
$type=$_POST['reportType'];

$fromDate=$_POST['fromDate'];
$toDate=$_POST['toDate'];

$fromDate=date("Y-m-d",strtotime($fromDate));
$toDate=date("Y-m-d",strtotime($toDate));


$travelType=$_POST['travelType'];

$profile=$_SESSION['profile'];
$reportUserName='';
	if($profile=='supervisor'){
		$reportUserName=$_POST['reportUserName'];
	}else if($profile=='user'){
		$reportUserName=$_SESSION['username'];
	}
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined')  ";

if($fromDate!=''&&$toDate!=''){
if($travelType!='both')
$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND `traveltype` like "'.$travelType.'" ';
else
$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND (`traveltype` like "local" OR `traveltype` like "international") ';
}

$sql.=" ;";

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

$_SESSION['reportCount']=$count;
$records="";
//if($type=='excelReport'){
//$rows=array();
//}
$i=0;
while($row = mysql_fetch_assoc($result))
{

if($row['approval']=='Declined'){

$declinedRecords=" class='declined' style='background:#FA5050;color:#FFFFFF'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BEF781;color:#000000'";
}
else{
$declinedRecords="";
}
			
			$records.="<tr> <td ".$declinedRecords.">";
			if($row['approval']=='On Hold'){
			$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else if($row['approval']=='WIP'){
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else if($row['approval']=='Declined'){
			$records.="<img src='images\denied.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else{
			$records.="<img src='images\approved.png'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}
            $records.="<td ".$declinedRecords.">".$row['datefrom']."</td>
            <td ".$declinedRecords.">".$row['dateto']."</td>
			<td ".$declinedRecords.">".$row['placefrom']."</td>			
			<td ".$declinedRecords.">".$row['placeto']."</td>
			<td ".$declinedRecords.">".$row['traveltype']."</td>
            <td ".$declinedRecords.">".$row['cost']."$</td>
            <td ".$declinedRecords.">".$row['comments']."</td>
            <td ".$declinedRecords."><a href='#' id='".$row['id']."' class='reportCommentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            </tr>";

} 
//if($type=='excelReport'){
//echo $rows;
//}else
echo $records;

?>