<?php
$id=$_GET['id'];
require_once '../config.php';
$sql="select * from assignment where assignment_id='$id'";
$sql=@mysql_fetch_array(@mysql_query($sql));
$standard=$sql['standard'];
$class_id=$sql['class_id'];

$file='';

if($standard!=0){
    if($class_id!=0){
        $file = $sql['file_name'];
        $file='../upload/class_id-'.$class_id.'/'.$file;
    }else{
	   $file = $sql['file_name'];
	   $file='../upload/'.$standard.'/'.$file;
    }
}else{
    $file = $sql['file_name'];
    $file='../upload/all/'.$file;
}	
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
echo($file);
?>