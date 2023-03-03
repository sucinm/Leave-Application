<?php
include '../config.php';
require('../assets/pdf/fpdf.php');
$tahun=0;
if(isset($_GET['years'])){
    $tahun=mysql_real_escape_string($_GET['years']);
} 
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
$pdf->Cell(25.5,0.7,"Emergency Leave Report",0,10,'C');
$pdf->ln(0.5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(25.5,0.7,"[".$tahun."]",0,10,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Printed on : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Emp No', 1, 0, 'C');
$pdf->Cell(5, 0.8, 'Name', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Department', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'From', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'To', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Total Day(s)', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Reason', 1, 1, 'C');
$pdf->SetFont('Arial','',10);
$no=1;
$debit=0;
$kredit=0;
$query=mysql_query("select * from employee e, department d, leave_ l where date LIKE '$tahun-%-%' and d.id_dept=e.id_department and e.emp_no=l.emp_no and type_of_leave='Emergency' order by d.dept_name, e.name asc");
while($lihat=mysql_fetch_array($query)){
	$id=$lihat['emp_no'];
	$pdf->Cell(1, 0.8, $no , 1, 0, 'C');
	$pdf->Cell(2, 0.8, $lihat['emp_no'],1, 0, 'C');
	$pdf->Cell(5, 0.8, $lihat['name'], 1, 0,'C');
	$pdf->Cell(3, 0.8, $lihat['dept_name'],1, 0, 'C');
	$pdf->Cell(3, 0.8, $lihat['from_date'],1, 0, 'C');
	$pdf->Cell(3, 0.8, $lihat['to_date'],1, 0, 'C');
	$pdf->Cell(3, 0.8, $lihat['total_days'],1, 0, 'C');
	$pdf->Cell(6, 0.8, $lihat['reason'],1, 1, 'C');

	$no++;
}

$pdf->Output("emergency_leave_report.pdf","I");

?>

