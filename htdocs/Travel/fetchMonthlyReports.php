<?php

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
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

$sql="SELECT * FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined')   ;";
  $addQuery='';
$months=array();
if($type=='monthly'){
$year=$_POST['year'];
$checkedMonths=$_POST['months'];
$months= explode(";", $checkedMonths);
/*foreach ($months as $value) {
    $addQuery.=' AND MONTH(  `datefrom` ) ='.$value.' AND MONTH(  `dateto` ) ='.$value;
}*/
$str=substr_replace(implode("||", $months) ,"",-2);
$sql="SELECT * FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined') AND (MONTH(`fromdate`)=".$str.") AND (YEAR(`fromdate`)=".$year.")  order by MONTH(`fromdate`);";
//$sql.=$addQuery;
}

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

//$_SESSION['reportsCount']=$count;
$records="";
//if($type=='excelReport'){
//$rows=array();
//}
$i=0;
while(false!==($row = mysql_fetch_assoc($result)))
{

if($row['approval']=='Declined'){

$declinedRecords=" class='declined' style='background:#FA5050;color:#FFFFFF'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BEF781;color:#000000'";
}
else{
$declinedRecords="";
}
				//	if($type=='excelReport'){
		//	rows[$i]=row;
		//	$i++;
		//	}
		error_log($row['datefrom']."-----".$row['dateto']);
		
	//	$datefrom=explode("-",$row['datefrom']);
	//	$dateto=explode("-",$row['dateto']);
	//	error_log($datefrom[2]."-----".$dateto[2]);
		//	if(((in_array($datefrom[1], $months))&&$datefrom[2]==$year)||((in_array($dateto[0], $months))&&$dateto[2]==$year)){
			$records.="<tr><td ".$declinedRecords.">";
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
            <td ".$declinedRecords.">".$row['purpose']."</td>
            <td ".$declinedRecords."><a href='#' id='".$row['id']."' class='reportCommentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            </tr>";
		//	}
		/*	$records.="<tr>
            <td>#".$row['id']."</td>
            <td>".$row['datefrom']."</td>
            <td>".$row['dateto']."</td>
			<td>".$row['placefrom']."</td>			
			<td>".$row['placeto']."</td>
			<td>".$row['traveltype']."</td>
            <td>".$row['cost']."$</td>
            <td>".$row['comments']."</td>
            <td><a href='#' id='".$row['id']."' class='reportCommentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            </tr>";*/

} 
//if($type=='excelReport'){
//echo $rows;
//}else
echo $records;

?>