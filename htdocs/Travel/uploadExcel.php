<?
session_start();

$host="localhost"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
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
    }
	
	
	
}

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



mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
$count=0;
foreach($array_data2 as $array){
$check_sql="SELECT EXISTS(SELECT * FROM `peoplesoftdata` WHERE `jrnlid`='".$array['jrnlid']."' AND `jrnldate`='".$array['jrnldt']."' AND `jrnlln`='".$array['jrnlln']."' ) as Result";
error_log($check_sql);
$result=mysql_query($check_sql);
$count= mysql_result($result, 0);
if($count==1){
continue;
}
error_log('-----result-----'.$result.'---count---'.$count);

$sql="INSERT INTO `db1`.`peoplesoftdata` (`jrnlid`, `jrnldate`, `jrnlln`, `cost`, `psid`) VALUES ('".$array['jrnlid']." ', '".$array['jrnldt']."', '".$array['jrnlln']."', '".$array['cost']."', '".$array['psid']."');";
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
//var_dump($array_data2);
//print_r($array_data);


?>