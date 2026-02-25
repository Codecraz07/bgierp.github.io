<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report.xls");

$servername="localhost";$username="root";$password="";$dbname="college_erp";
$conn=new mysqli($servername,$username,$password,$dbname);

$date=$_GET['date'];$search=$_GET['search'];
$sql="SELECT * FROM attendance WHERE DATE(datetime)='$date'";
if(!empty($search)) $sql.=" AND (student_id LIKE '%$search%' OR student_name LIKE '%$search%')";
$result=$conn->query($sql);

echo "ID\tStudent ID\tStudent Name\tDateTime\tSnapshot\n";
while($row=$result->fetch_assoc()){
  echo "{$row['id']}\t{$row['student_id']}\t{$row['student_name']}\t{$row['datetime']}\t{$row['snapshot_path']}\n";
}
$conn->close();
?>