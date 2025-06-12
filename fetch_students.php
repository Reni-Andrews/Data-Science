<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$year = isset($_GET['year']) ? intval($_GET['year']) : 1;
$today = date('Y-m-d');

$host = 'https://reni-andrews.github.io/Data-Science';
$db = 'attendance_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $stmt = $pdo->prepare("
        SELECT s.id, s.register_number, s.name,
               a.status, a.reason, a.date
        FROM students s
        LEFT JOIN attendance a ON s.id = a.student_id AND a.date = :today
        WHERE s.year = :year
        ORDER BY s.register_number
    ");
    $stmt->execute(['today' => $today, 'year' => $year]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'date' => $today,
        'students' => $students
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error', 'details' => $e->getMessage()]);
}
?>
