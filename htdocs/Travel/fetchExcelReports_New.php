<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/phpxls/Writer.php');
session_start();


$userName=$_GET['reportUserName'];
if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: login.php");
}
 $filename = $userName."_RegularReports_". date('Ymd').".xls";
 header("Content-Type: application/vnd.ms-excel;");
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
function cleanData($str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // file name for download




$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name


//$recordType=$_GET[

//$type='jhy';
$type=$_GET['reportType'];

$fromDate=$_GET['fromDate'];
$toDate=$_GET['toDate'];
$travelType=$_GET['travelType'];

$profile=$_SESSION['profile'];
$reportUserName='';
	if($profile=='supervisor'){
		$reportUserName=$_GET['reportUserName'];
	}else if($profile=='user'){
		$reportUserName=$_SESSION['username'];
	}
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined')  ";

if($fromDate!=''&&$toDate!=''){
$sql.=' AND datefrom LIKE "'.$fromDate.'" AND dateto LIKE "'.$toDate.'"';
}

$sql.=" ;";

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

//$_SESSION['reportsCount']=$count;
$records="";
//if($type=='excelReport'){
//$rows=array();
//}

$flag = false;
$i=0;


$workbook = new Spreadsheet_Excel_Writer();

$format_und =$workbook->addFormat();
$format_und->setBottom(2);//thick
$format_und->setBold();
$format_und->setColor('black');
$format_und->setFontFamily('Arial');
$format_und->setSize(8);

$format_reg =$workbook->addFormat();
$format_reg->setColor('black');
$format_reg->setFontFamily('Arial');
$format_reg->setSize(8);

$worksheet =$workbook->addWorksheet('RegularReports');

$row_count=0; 

while($row = mysql_fetch_assoc($result))
{
$col_count=0;

 /*if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
	array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
	*/
	if($row_count==0){
	 $fmt  =$format_und;
	}else{
	 $fmt  =$format_reg;
	}

			$worksheet->write($row_count, $col_count++,$row['id'], $fmt);
            $worksheet->write($row_count, $col_count++,$row['datefrom'], $fmt);
            $worksheet->write($row_count, $col_count++,$row['dateto'], $fmt);
			$worksheet->write($row_count, $col_count++,$row['placefrom'], $fmt);
			$worksheet->write($row_count, $col_count++,$row['placeto'], $fmt);
			$worksheet->write($row_count, $col_count++,$row['traveltype'], $fmt);
            $worksheet->write($row_count, $col_count++,$row['cost'], $fmt);
            $worksheet->write($row_count, $col_count++,$row['purpose'], $fmt);
			$worksheet->write($row_count, $col_count++,$row['comments'], $fmt);
			
			/*$records.="<tr>
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

$row_count++;
			
			
}

$workbook->send('test.xls');
$workbook->close(); 
//if($type=='excelReport'){
//echo $rows;
//}else
//echo $records;

?>