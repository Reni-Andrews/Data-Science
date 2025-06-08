<?php
header('Content-Type: application/json');
require 'db.php';

$year = isset($_GET['year']) ? (int)$_GET['year'] : 1;
$today = date('Y-m-d');

$sql = "SELECT s.id, s.register_number, s.name, s.year, a.status, a.reason, a.marked_time 
        FROM students s
        LEFT JOIN attendance a ON s.id = a.student_id AND a.date = :today
        WHERE s.year = :year
        ORDER BY s.register_number";

$stmt = $pdo->prepare($sql);
$stmt->execute(['today' => $today, 'year' => $year]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($students);
?>
