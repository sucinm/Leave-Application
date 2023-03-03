<?php 
include '../config.php';
$emp_no=$_POST['emp_no'];
$name=$_POST['name'];
$id_department=$_POST['id_department'];
$design_grade=$_POST['design_grade'];
$date_of_join=$_POST['date_of_join'];


mysql_query("update employee set name='$name', id_department='$id_department', design_grade='$design_grade', date_of_join='$date_of_join' where emp_no='$emp_no'");
header("location:leave_app.php?emp_no=$emp_no");

?>