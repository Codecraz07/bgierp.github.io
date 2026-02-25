<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college_erp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("DB Error: " . $conn->connect_error); }

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) { die("No data received"); }

$student_id = $data['student_id'];
$student_name = $data['student_name'];
$image = $data['image'];
$datetime = date('Y-m-d H:i:s');

// Save image
$folder = "snapshots/";
if (!file_exists($folder)) mkdir($folder, 0777, true);
$fileName = $folder . "snap_" . time() . ".png";
$image_parts = explode(";base64,", $image);
$image_base64 = base64_decode($image_parts[1]);
file_put_contents($fileName, $image_base64);

// Save record
$sql = "INSERT INTO attendance (student_id, student_name, datetime, snapshot_path)
        VALUES ('$student_id', '$student_name', '$datetime', '$fileName')";
if ($conn->query($sql) === TRUE) {
  echo "✅ Attendance marked successfully!";
} else {
  echo "❌ Error: " . $conn->error;
}
$conn->close();
?>