<?php 
include '../config.php';
$leave_id=$_GET['leave_id'];
$emp_no;
$name;
$d_o_k;
$det=mysql_query("select * from leave_ l,employee e, department d where l.id_leave=$leave_id and d.id_dept=e.id_department and l.emp_no=e.emp_no")or die(mysql_error());
while($d=mysql_fetch_array($det)){
	$emp_no=$d['emp_no'];
	$name=$d['name'];
	$d_o_k=$d['d_o_k'];
}
if($d_o_k=='d_o' || $d_o_k=='k_o'){
	mysql_query("delete from leave_ where id_leave='$leave_id'");
	header("location:detail_oil.php?emp_no=$emp_no&name=$name");
} else {
	mysql_query("delete from leave_ where id_leave='$leave_id'");
	header("location:detail.php?emp_no=$emp_no&name=$name");
}

?>