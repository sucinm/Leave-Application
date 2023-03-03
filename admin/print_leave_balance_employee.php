<?php
include '../config.php';
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$pdf->Image('../logo/pt.brc.png',1,1,7,2);
$pdf->SetX(8);            
$pdf->MultiCell(19.5,0.5,'PT. Bintan Resort Cakrawala',0,'L');
$pdf->SetX(8);
$pdf->MultiCell(19.5,0.5,'Jl. Kota Kapur Teluk Sebong , Lagoi',0,'L');    
$pdf->SetFont('Arial','B',10);
$pdf->SetX(8);
$pdf->MultiCell(19.5,0.5,'Northern Bintan Island, Indonesia 29155',0,'L');
$pdf->SetX(8);
$pdf->MultiCell(19.5,0.5,'www.bintan-resorts.com',0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(25.5,0.7,"Leave Balance Employee Report",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Printed on : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Emp No', 1, 0, 'C');
$pdf->Cell(7, 0.8, 'Name', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Department', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Leave Balance', 1, 0, 'C');
$pdf->Cell(4.5, 0.8, 'OIL Balance', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$no=1;
$debit=0;
$kredit=0;
$query=mysql_query("select * from employee e, department d where d.id_dept=e.id_department order by d.dept_name, e.name asc");
while($lihat=mysql_fetch_array($query)){
	$id=$lihat['emp_no'];
	$pdf->Cell(1, 0.8, $no , 1, 0, 'C');
	$pdf->Cell(4, 0.8, $lihat['emp_no'],1, 0, 'C');
	$pdf->Cell(7, 0.8, $lihat['name'], 1, 0,'C');
	$pdf->Cell(4, 0.8, $lihat['dept_name'],1, 0, 'C');
	
	$query1 = mysql_query("SELECT sum(total_days) as d FROM leave_ where emp_no=$id and d_o_k='d'");
    while ($row = mysql_fetch_array($query1)) { $debit=$row['d']; }
    
    $query2 = mysql_query("SELECT sum(total_days) as k FROM leave_ where emp_no=$id and d_o_k='k' and not (type_of_leave='Maternity' OR type_of_leave='Unpaid')");
    while ($row = mysql_fetch_array($query2)) { $kredit=$row['k']; }
    $total_days=$debit-$kredit;
    
    $pdf->Cell(4, 0.8, $total_days, 1, 0,'C');

    $query3 = mysql_query("SELECT sum(total_days) as d FROM leave_ where emp_no=$id and d_o_k='d_o'");
    while ($row = mysql_fetch_array($query3)) { $d_o=$row['d']; }
 
    $query4 = mysql_query("SELECT sum(total_days) as k FROM leave_ where emp_no=$id and d_o_k='k_o'");
    while ($row = mysql_fetch_array($query4)) { $k_o=$row['k']; }
    $total=$d_o-$k_o; 

	$pdf->Cell(4.5, 0.8, $total,1, 1, 'C');
	// $pdf->Cell(2, 0.8, $lihat['jumlah'], 1, 1,'C');

	$no++;
}

$pdf->Output("report_balance_employee.pdf","I");

?>

