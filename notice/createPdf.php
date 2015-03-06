<?php
require_once '../fpdf.php';
session_start();
require_once '../config.php';
require_once '../function.php';

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];


$notice_id = $_GET['id'];
$sql="select * from notice where notice_id='$notice_id'";
$sql=@mysql_fetch_array(@mysql_query($sql));
if($user_type==$sql['user_type'] || $sql['user_type']=='al'){
	$pdf = new FPDF();
	$pdf -> AddPage();
	$pdf -> SetFont('Arial', '', 20);
	$pdf -> Cell(0, 25,get_ins_name(), 0, 1, 'C');
	
	$pdf -> SetFont('Arial', '', 17);
	$pdf -> Cell(0, 10,$sql['notice_heading'], 0, 1, 'C');
	
	$pdf -> SetFont('Arial', '', 10);
	$pdf -> Cell(0, 7,'Issued By : '.getUserName($sql['from_id']), 0, 1, 'C');
	
	$pdf -> SetFont('Arial', '', 10);
	$pdf -> Cell(0, 7,$sql['notice_date'], 0, 1, 'C');
	
	$pdf -> Cell(0, 20,'', 0, 1, 'C');
	
	$pdf -> SetFont('Arial', '', 13);
	$text=str_ireplace('<br />', '', $sql['notice_body']);
	$pdf -> MultiCell(0, 7,$text, 0, 'L');
	
	if(isset($_GET['output']) && $_GET['output']=='d')
	$pdf -> Output($sql['notice_heading'].'.pdf','D');
	else {
		$pdf -> Output($sql['notice_heading'].'.pdf','I');
	}
}else{
	echo('No Notice Found');
}
?>