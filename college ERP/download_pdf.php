<?php
require("fpdf/fpdf.php");
$servername="localhost";$username="root";$password="";$dbname="college_erp";
$conn=new mysqli($servername,$username,$password,$dbname);

$date=$_GET['date'];$search=$_GET['search'];
$sql="SELECT * FROM attendance WHERE DATE(datetime)='$date'";
if(!empty($search)) $sql.=" AND (student_id LIKE '%$search%' OR student_name LIKE '%$search%')";
$result=$conn->query($sql);

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial","B",14);
$pdf->Cell(0,10,"Attendance Report - ".$date,0,1,"C");
$pdf->Ln(5);

$pdf->SetFont("Arial","B",10);
$pdf->Cell(10,8,"ID",1);
$pdf->Cell(30,8,"Student ID",1);
$pdf->Cell(50,8,"Student Name",1);
$pdf->Cell(40,8,"DateTime",1);
$pdf->Cell(60,8,"Snapshot Path",1);
$pdf->Ln();

$pdf->SetFont("Arial","",10);
while($row=$result->fetch_assoc()){
  $pdf->Cell(10,8,$row['id'],1);
  $pdf->Cell(30,8,$row['student_id'],1);
  $pdf->Cell(50,8,$row['student_name'],1);
  $pdf->Cell(40,8,$row['datetime'],1);
  $pdf->Cell(60,8,$row['snapshot_path'],1);
  $pdf->Ln();
}
$pdf->Output("D","Attendance_Report_$date.pdf");
$conn->close();
?>