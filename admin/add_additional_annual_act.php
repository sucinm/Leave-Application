<?php 
include '../config.php';
$date=$_GET['date']; 
$y=$_GET['y']; 
$tahun_seb=0;
$tanggal_terakhir='';
$emp_no=0;
$tahun_sebelumnya=mysql_query("SELECT last_day(date) AS tgl, year(date) AS tahun FROM `leave_` ORDER BY id_leave DESC LIMIT 1")or die(mysql_error());	
while($d=mysql_fetch_array($tahun_sebelumnya)){
	$tahun_seb=$d['tahun'];
	$tanggal_terakhir=$d['tgl'];
}
$total_tahun=$tahun_seb+1;
if($total_tahun==$y){
	$emp=mysql_query("SELECT emp_no FROM employee")or die(mysql_error());
	while ($e=mysql_fetch_array($emp)) {
		$emp_no=$e['emp_no'];
		$cek_kredit=mysql_query("select * from leave_ where emp_no='$emp_no' and d_o_k='k'")or die(mysql_error());
		if(mysql_num_rows($cek_kredit)>=1){
			$kalkulasi=mysql_query("SELECT e.emp_no, debit.d-kredit.k AS total
			FROM leave_ l
			INNER JOIN (SELECT emp_no, SUM(total_days) AS d FROM leave_ WHERE d_o_k='d' AND emp_no='$emp_no' GROUP BY emp_no) AS debit on debit.emp_no=l.emp_no
			INNER JOIN (SELECT emp_no, SUM(total_days) AS k FROM leave_ WHERE d_o_k='k' AND emp_no='$emp_no' AND NOT type_of_leave='Maternity' GROUP BY emp_no) AS kredit on kredit.emp_no=l.emp_no 
			INNER JOIN employee e on l.emp_no=e.emp_no 
			WHERE l.emp_no='$emp_no'
			GROUP BY e.emp_no")or die(mysql_error());
			while($emp_arr=mysql_fetch_array($kalkulasi)){
			$balance=$emp_arr['total'];
				if($balance>12){
					$jumlah=abs(12-$balance);
					// echo 'bag1--'.$jumlah.'--'.$emp_no.'----------------';
					mysql_query("insert into leave_ values('','$emp_no','$tanggal_terakhir','Reduction of leave','k','$jumlah','$tanggal_terakhir','$tanggal_terakhir','')");
				}
			}
		} else {
			$kalkulasi2=mysql_query("SELECT e.emp_no,sum(l.total_days) AS total 
			FROM employee e,leave_ l 
			WHERE e.emp_no=l.emp_no
			AND l.emp_no='$emp_no' 
			AND l.d_o_k='d' GROUP BY e.emp_no")or die(mysql_error());	
			while($emp_arr=mysql_fetch_array($kalkulasi2)){
				$balance=$emp_arr['total'];
				if($balance>12){
					$jumlah=abs(12-$balance);
					// echo 'bag2--'.$jumlah.'--'.$emp_no.'----------------';
					mysql_query("insert into leave_ values('','$emp_no','$tanggal_terakhir','Reduction of leave','k','$jumlah','$tanggal_terakhir','$tanggal_terakhir','')");
				}
			}
		}
	}
	
}
$det=mysql_query("select * from employee")or die(mysql_error());	
while($d=mysql_fetch_array($det)){
	$id=$d['emp_no'];
	mysql_query("insert into leave_ values('','$id','$date','','d','1','$date','$date','')");
}
header("location:additional_leave.php?additional=annual&message=success");

 ?>