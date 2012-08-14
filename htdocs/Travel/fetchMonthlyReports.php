<?php
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';

//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
session_start();
//$recordType=$_GET[
$userName=$_SESSION['username'];
//$type='jhy';
$type=$_POST['reportType'];

$profile=$_SESSION['profile'];
$reportUserName=$_SESSION['username'];
	
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");


//Get User Id
$sql="SELECT iduser FROM user WHERE username='$reportUserName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");

$sql="SELECT * FROM $tbl_name WHERE iduser='".$iduser."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'declined')   ;";
  $addQuery='';
$months=array();
if($type=='monthly'){
$year=$_POST['year'];
$checkedMonths=$_POST['months'];
$months= explode(";", $checkedMonths);

$str_months="(";
foreach ($months as $i) {
   // unset($array[$i]);
   if($i!=''){
   $str_months.="(MONTH(`fromdate`)=".$i.")||";
	error_log("Months=".$i);
	}
}
$str_months = substr($str_months, 0, -2);
$str_months.=")";


error_log("Months=".$str_months);

/*foreach ($months as $value) {
    $addQuery.=' AND MONTH(  `datefrom` ) ='.$value.' AND MONTH(  `dateto` ) ='.$value;
}*/
$str=substr_replace(implode("||", $months) ,"",-2);
$sql="SELECT * FROM $tbl_name WHERE iduser='".$iduser."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'declined') AND ".$str_months." AND (YEAR(`fromdate`)=".$year.")  order by MONTH(`fromdate`);";
//$sql.=$addQuery;
}

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

//$_SESSION['reportsCount']=$count;
$records="";

$i=0;
while(false!==($row = mysql_fetch_assoc($result)))
{

if($row['approval']=='declined'){

$declinedRecords=" class='declined' style='background:#FA5050;color:#FFFFFF'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BEF781;color:#000000'";
}
else{
$declinedRecords="";
}

		error_log($row['fromdate']."-----".$row['todate']);
		

			$records.="<tr><td ".$declinedRecords.">";
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

echo $records;

?>