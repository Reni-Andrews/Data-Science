<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db = 'attendance_db';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

$year = $_POST['year'];
$today = date('Y-m-d');

$stmt = $pdo->prepare("SELECT id FROM students WHERE year = :year");
$stmt->execute(['year' => $year]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as $student) {
    $id = $student['id'];
    $status = $_POST["status_$id"] ?? 'Present';
    $reason = $_POST["reason_$id"] ?? '';

    $check = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE student_id = :id AND date = :date");
    $check->execute(['id' => $id, 'date' => $today]);
    $exists = $check->fetchColumn();

    if ($exists) {
        $update = $pdo->prepare("UPDATE attendance SET status = :status, reason = :reason WHERE student_id = :id AND date = :date");
        $update->execute(['status' => $status, 'reason' => $reason, 'id' => $id, 'date' => $today]);
    } else {
        $insert = $pdo->prepare("INSERT INTO attendance (student_id, status, reason, date) VALUES (:id, :status, :reason, :date)");
        $insert->execute(['id' => $id, 'status' => $status, 'reason' => $reason, 'date' => $today]);
    }
}

echo "Attendance submitted successfully.";
?>
