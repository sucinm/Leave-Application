<?php 
include '../config.php';
$emp_no=$_POST['emp_no'];
$date=$_POST['date'];
$type_of_leave=$_POST['type_of_leave'];
$days=$_POST['days'];
$from=$_POST['from'];
$to=$_POST['to'];
$reason=$_POST['reason'];
$d_o_k="";
if($type_of_leave=="Off-in-Lieu"){
	$d_o_k="k_o";
} else {
	$d_o_k="k";
}

// echo $emp_no."---".$date."---".$type_of_leave."---".$days."---".$from."---".$to."---".$reason."---".$d_o_k;

mysql_query("insert into leave_ values('','$emp_no','$date','$type_of_leave','$d_o_k','$days','$from','$to','$reason')");
header("location:leave_app.php?emp_no=$emp_no&message=success");

 ?>