<?php 
session_start();
include 'config.php';
$uname=$_POST['uname'];
$pass=$_POST['pass'];
$pas=md5($pass);
$query1=mysql_query("select * from admin where username='$uname' and password='$pas'")or die(mysql_error());

if(mysql_num_rows($query1)==1){
	$_SESSION['uname']=$uname;
	header("location:admin/index.php");
} else {
	if($uname==$pass){
		$query2=mysql_query("select * from employee where emp_no='$uname'")or die(mysql_error());		
		if(mysql_num_rows($query2)==1){
			$_SESSION['uname']=$uname;
			header("location:officer/index.php?report=annual");
		}
	} else {
		header("location:index.php?pesan=gagal")or die(mysql_error());		
	}
}
 ?>