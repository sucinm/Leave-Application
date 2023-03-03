<?php 
include '../config.php';
$emp_no=$_POST['emp_no'];
$name=$_POST['name'];
$id_department=$_POST['id_department'];
$design_grade=$_POST['design_grade'];
$date_of_join=$_POST['date_of_join'];
$days=$_POST['total_days'];
$date=$_POST['skrg'];

$cek=mysql_query("select * from employee where emp_no='$emp_no'");
if(mysql_num_rows($cek)>=1){
	header("location:index.php?message=failed");
} else{
	mysql_query("insert into employee values('$emp_no','$name','$id_department','$design_grade','$date_of_join')")or die(mysql_error());
	mysql_query("insert into leave_ values('','$emp_no','$date','','d','$days','$date','$date','')")or die(mysql_error());
	header("location:index.php?message=created");
} 
 ?>