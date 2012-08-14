<?
<<<<<<< HEAD
//session_start();
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/

include 'DB_details.php';
//$db_name="travel"; // Database name
=======
session_start();

$host="localhost"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
$tbl_name="peoplesoftdata"; // Table name


/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');


include 'PHPExcel.php';


/** PHPExcel_Writer_Excel2007 */
include 'PHPExcel/Reader/Excel2007.php';

//echo getcwd() ;
$objPHPExcel = new PHPExcel();

$objReader = new PHPExcel_Reader_Excel5();
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load( 'xls\\'. $_SESSION['filename'] );

$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();

$array_data = array();
foreach($rowIterator as $row){
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true); // Loop all cells, even if it is not set
    if(1 == $row->getRowIndex ()||2 == $row->getRowIndex ()||3 == $row->getRowIndex ()) continue;//skip first row
    $rowIndex = $row->getRowIndex ();
    $array_data[$rowIndex] = array('jrnlln'=>'', 'jrnlid'=>'','jrnldt'=>'','cost'=>'','psid'=>'');
 
    foreach ($cellIterator as $cell) {
	
        if('E' == $cell->getColumn()){
            $array_data[$rowIndex]['jrnlln'] = $cell->getCalculatedValue();
        } else if('B' == $cell->getColumn()){
            $array_data[$rowIndex]['jrnlid'] = $cell->getCalculatedValue();
        } else if('C' == $cell->getColumn()){
            $array_data[$rowIndex]['jrnldt'] = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'YYYY-MM-DD');
        } else if('N' == $cell->getColumn()){
            $array_data[$rowIndex]['cost'] = $cell->getCalculatedValue();
        }else if('Y' == $cell->getColumn()){
            $array_data[$rowIndex]['psid'] = $cell->getCalculatedValue();
        }
<<<<<<< HEAD
			
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
    }
	
	
	
}
<<<<<<< HEAD
error_log("Row Index is".$rowIndex);
//error_log( print_r($array_data));
$array_data2=array();
	$rowCount=0;
	foreach ($array_data as $array) {
		if($array['psid']!=""){
			$array_data2[$rowCount++]=$array;
		}
		error_log("copied".$array_data2[$rowCount-1]['psid']."org:".$array['psid']);
	}
error_log("done");
	//print_r($array_data2);
=======

$array_data2=array();
	$rowCount=0;
	foreach ($array_data as $array) {
	if($array['psid']!=""){
	$array_data2[$rowCount++]=$array;
//	unset($array);
//	echo "unset";
	}
//	var_dump($array);
	}
print_r($array_data2);
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e



mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
$count=0;
<<<<<<< HEAD

error_log("Row count is".$rowCount);

while($rowCount>0){
error_log("this is ".$array_data2[$rowCount]['jrnlid'].$array_data2[$rowCount]['jrnlln'].$array_data2[$rowCount]['jrnldt'].$array_data2[$rowCount]['psid']);
$rowCount--;
}


foreach($array_data2 as $array){

=======
foreach($array_data2 as $array){
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
$check_sql="SELECT EXISTS(SELECT * FROM `peoplesoftdata` WHERE `jrnlid`='".$array['jrnlid']."' AND `jrnldate`='".$array['jrnldt']."' AND `jrnlln`='".$array['jrnlln']."' ) as Result";
error_log($check_sql);
$result=mysql_query($check_sql);
$count= mysql_result($result, 0);
if($count==1){
continue;
}
error_log('-----result-----'.$result.'---count---'.$count);

<<<<<<< HEAD
$sql="INSERT INTO `peoplesoftdata` (`jrnlid`, `jrnldate`, `jrnlln`, `cost`, `psid`) VALUES ('".$array['jrnlid']." ', '".$array['jrnldt']."', '".$array['jrnlln']."', '".$array['cost']."', '".$array['psid']."');";

$sql="INSERT INTO `peoplesoftdata` (`jrnlid`, `jrnldate`, `jrnlln`, `cost`, `psid`) VALUES ('".$array['jrnlid']." ', '".$array['jrnldt']."', '".$array['jrnlln']."', '".$array['cost']."', '".$array['psid']."');";

$sql2="INSERT INTO `budget` (`iduser`,`proposedbudget`,`actuabudget`,`fiscalyear`,`psid`) VALUES (1, 2, 3) ON DUPLICATE KEY UPDATE `actuabudget` = `actuabudget` + 1;";

=======
$sql="INSERT INTO `db1`.`peoplesoftdata` (`jrnlid`, `jrnldate`, `jrnlln`, `cost`, `psid`) VALUES ('".$array['jrnlid']." ', '".$array['jrnldt']."', '".$array['jrnlln']."', '".$array['cost']."', '".$array['psid']."');";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
//$sql="SELECT * FROM  $tbl_name WHERE  `username` LIKE  '".$userName."' AND `supervisor` LIKE  '".$supervisor."' AND `datefrom` LIKE  '".$requestTravelFromDate."' AND `dateto` LIKE  '".$requestTravelToDate."' AND `placefrom` LIKE  '".$requestTravelSource."' AND `placeto` LIKE  '".$requestTravelDestination."' AND `purpose` LIKE '".$requestTravelPurpose."' AND `cost` LIKE '".$requestTravelCost."'  AND `traveltype` LIKE '".$requestTravelType."' AND `approval` LIKE 'WIP';";
error_log($sql);
	  if (!mysql_query($sql))
	  {
	  error_log('Error: ' . mysql_error());
	  echo "fail";
	  exit;
	  }else{
	  //echo "success";
	  }
}
echo "success";
<<<<<<< HEAD

=======
//var_dump($array_data2);
//print_r($array_data);
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e


?>