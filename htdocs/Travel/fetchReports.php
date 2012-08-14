<?php
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
require('Smarty.class.php');
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
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
error_log($_SESSION['profile'].'-'.$_POST['reportUserName']);
	if($profile=='user'){
		$reportUserName=$_SESSION['username'];
	}else {
		$reportUserName=$_POST['reportUserName'];
	}
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");


//Get User Id
$sql="SELECT `iduser` FROM user WHERE username='$reportUserName' ";
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");

//Get TravelType Id
if($travelType!='both'){
$sql="SELECT idtraveltype FROM traveltype WHERE `type`='$travelType' ;";
$result=mysql_query($sql);
$traveltypeId=mysql_result($result,0,"idtraveltype");
}


$sql="SELECT * FROM $tbl_name WHERE idUser='".$iduser."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined')  ";

if($fromDate!=''&&$toDate!=''){
if($travelType!='both'){

$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND `idtraveltype` = '.$traveltypeId ;

}else
$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND (`idtraveltype` = 1 OR `idtraveltype` = 2) ';
}

$sql.=" ;";

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

$_SESSION['reportCount']=$count;
$smarty = new Smarty();
$smarty->assign('reportCount',$count);
$records="";
//if($type=='excelReport'){
//$rows=array();
//}
$i=0;
while($row = mysql_fetch_assoc($result))
{

if($row['approval']=='declined'){

$declinedRecords=" class='declined' style='background:#FA5050;color:#FFFFFF'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BEF781;color:#000000'";
}
else{
$declinedRecords="";
}
			
			$records.="<tr> <td ".$declinedRecords.">";
			if($row['approval']=='On Hold'){
			$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}else if($row['approval']=='WIP'){
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}else if($row['approval']=='declined'){
			$records.="<img src='images\denied.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}else{
			$records.="<img src='images\approved.png'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}
            $records.="<td ".$declinedRecords.">".$row['fromdate']."</td>
            <td ".$declinedRecords.">".$row['todate']."</td>
			<td ".$declinedRecords.">".$row['placefrom']."</td>			
			<td ".$declinedRecords.">".$row['placeto']."</td>";
			if($row['idtraveltype']==1){
			$records.="<td ".$declinedRecords.">"."Domestic"."</td>";			
			}else if($row['idtraveltype']==2){
			$records.="<td ".$declinedRecords.">"."International"."</td>";
			}else{
			$records.="<td ".$declinedRecords.">"."Unknown"."</td>";
			}
            $records.="<td ".$declinedRecords.">$".$row['cost']."</td>
            <td ".$declinedRecords.">".$row['comments']."</td>
            <td ".$declinedRecords."><a href='#' id='".$row['idexpenserecords']."' class='reportCommentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            </tr>";

} 
$records.='<tr style="display:none;"><td colspan="8" style="width:835px;display:none" class="rounded-foot-left"><span id="reportCountHidden">Your have '.$count.' results</span></td></tr>';
//if($type=='excelReport'){
//echo $rows;
//}else
echo $records;

?>