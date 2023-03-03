<?php 
include '../config.php';
$user=$_POST['user'];
$lama=md5($_POST['lama']);
$baru=$_POST['baru'];
$ulang=$_POST['ulang'];

$cek=mysql_query("select * from admin where password='$lama' and username='$user'");
if(mysql_num_rows($cek)==1){
	if($baru==$ulang){
		$b = md5($baru);
		mysql_query("update admin set password='$b' where username='$user'");
		header("location:change_password.php?message=oke");
	}else{
		header("location:change_password.php?message=different");
	}
}else{
	header("location:change_password.php?message=failed");
}

 ?>