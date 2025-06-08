<?php
// DB connection params
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $student_id = intval($_POST["student_id"]);

  if ($student_id > 0) {
    // Check if payment already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM payments WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($count);                       
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
      // Insert payment record
      $stmt2 = $conn->prepare("INSERT INTO payments (student_id) VALUES (?)");
      $stmt2->bind_param("i", $student_id);
      $stmt2->execute();
      $stmt2->close();

      header("Location: students_payment_list.php?success=1");
      exit();
    } else {
      echo "Payment already recorded for this student.";
    }
  } else {
    echo "Invalid student ID.";
  }
}

$conn->close();
?>
