<?php 
include '../config.php';
$emp_no=$_POST['emp_no'];
$date=$_POST['date'];
$type_of_leave='Off-in-Lieu';
$job=$_POST['job'];
$hour=$_POST['hour'];
$from=$_POST['from'];
$to=$_POST['to'];
$reason=$_POST['reason'];

mysql_query("insert into leave_ values('','$emp_no','$date','$type_of_leave','d_o','$hour','$from','$to','$job')");
header("location:additional_leave.php?additional=oil&message=success");

 ?>