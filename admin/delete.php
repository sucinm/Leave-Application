<?php 
include '../config.php';
$emp_no=$_GET['emp_no'];
mysql_query("delete from employee where emp_no='$emp_no'");
header("location:index.php");

?>