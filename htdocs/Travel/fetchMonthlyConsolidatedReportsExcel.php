<?php
session_start();


/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');


include 'PHPExcel.php';


/** PHPExcel_Writer_Excel2007 */
include 'PHPExcel/Writer/Excel2007.php';

$userName=$_SESSION['username'];
if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: login.php");
}
 $filename = $userName."_MonthlyReports_". date('Ymd').".xls";
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 header("Content-Disposition: attachment; filename=\"$filename\"");
 header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    //header("Content-Type: application/force-download");
    //header("Content-Type: application/octet-stream");
    //header("Content-Type: application/download");;
 
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name

//$recordType=$_GET[
//$userName=$_SESSION['username'];
//$type='jhy';
$type=$_GET['reportType'];

//$profile=$_SESSION['profile'];
$reportUserName=$userName;
	
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

//$sql="SELECT MONTH(`fromdate`),sum(cost),traveltype  FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined') AND (MONTH(`fromdate`)=".$str.") AND (YEAR(`fromdate`)=".$year.")   group by MONTH(`fromdate`),traveltype;";
  $addQuery='';
$months=array();
//if($type=='monthly'){
$year=$_GET['year'];
$checkedMonths=$_GET['months'];
$months= explode(";", $checkedMonths);
/*foreach ($months as $value) {
    $addQuery.=' AND MONTH(  `datefrom` ) ='.$value.' AND MONTH(  `dateto` ) ='.$value;
}*/
$str=substr_replace(implode("||", $months) ,"",-2);
$sql="SELECT MONTH(`fromdate`),sum(cost),traveltype  FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined') AND (MONTH(`fromdate`)=".$str.") AND (YEAR(`fromdate`)=".$year.")   group by MONTH(`fromdate`),traveltype;";
//$sql.=$addQuery;
//}

error_log($sql.$months);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

//$_SESSION['reportsCount']=$count;
$records="";
//if($type=='excelReport'){
//$rows=array();
//}

$flag = false;
$i=0;


// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

$default_border = array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb'=>'1006A3') );


$style_header = array( 'borders' => array( 'bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border, ), 'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'E1E0F7'), ), 'font' => array( 'bold' => true, ) ); 
$style_month_header = array( 'borders' => array( 'bottom' => $default_border, 'left' => $default_border, 'top' => $default_border, 'right' => $default_border, ), 'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FC2B43'), ), 'font' => array( 'bold' => true, ) ); 
/*Read more: http://bayu.freelancer.web.id/2010/07/16/phpexcel-advanced-read-write-excel-made-simple/#ixzz1wSKwkctx 
Under Creative Commons License: Attribution*/


// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("ITC Infotech");
$objPHPExcel->getProperties()->setLastModifiedBy($userName);
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Regular Report for Office 2007 XLSX, generated using PHP classes.");


$objPHPExcel->setActiveSheetIndex(0);
$row_count=1; 
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Months');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Cost-Local');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Cost-International');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Total');

$objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray( $style_header );
$objPHPExcel->getActiveSheet()->getStyle('B1:B1')->applyFromArray( $style_header );
$objPHPExcel->getActiveSheet()->getStyle('C1:C1')->applyFromArray( $style_header );
$objPHPExcel->getActiveSheet()->getStyle('D1:D1')->applyFromArray( $style_header );
$format_flag='';
while($row = mysql_fetch_array($result))
{
		$month_current=$row[0];
		if($format_flag!=$month_current){
		$row_count++;
		$format_flag=$month_current;
		
		//$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_count, $month_name[intval($format_flag)]);
		//$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':A'.$row_count)->applyFromArray( $style_month_header );
		}
		//error_log($row['datefrom']."-----".$row['dateto']);
		//$datefrom=explode("-",$row['datefrom']);
		//$dateto=explode("-",$row['dateto']);
			//if(((in_array($datefrom[0], $months))&&$datefrom[2]==$year)||((in_array($dateto[0], $months))&&$dateto[2]==$year)){
			
$month_name=array("","January","Feburary","March","April","May","June","July","August","September","October","November","December");
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_count, $month_name[intval($row[0])]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':A'.$row_count)->applyFromArray( $style_month_header );
					if($row[2]=='local'){
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row_count, $row[1]);
					}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row_count, $row[1]);
					}
					//$row_count++;
			
		//	}

} 

for(;$row_count>=2;$row_count--){
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row_count, $objPHPExcel->getActiveSheet()->getCell('B'.$row_count)->getCalculatedValue()+$objPHPExcel->getActiveSheet()->getCell('C'.$row_count)->getCalculatedValue());
}
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Monthly Reports');

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n";
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);//
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

// Echo done
//echo date('H:i:s') . " Done writing file.\r\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>