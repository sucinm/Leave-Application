<?php 
include '../config.php';
$emp_no=$_POST['emp_no'];
$name=$_POST['name'];
$id_leave=$_POST['id_leave'];
$date=$_POST['date'];
$type_of_leave='Off-in-Lieu';
$days=$_POST['days'];
$from=$_POST['from'];
$to=$_POST['to'];
$reason=$_POST['reason'];

mysql_query("update leave_ set date='$date', type_of_leave='$type_of_leave', total_days='$days', from_date='$from', to_date='$to', reason='$reason' where id_leave='$id_leave'");
header("location:detail_oil.php?emp_no=$emp_no&name=$name");
?>