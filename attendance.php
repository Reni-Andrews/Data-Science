<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['attendance']) || !is_array($data['attendance'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$today = date('Y-m-d');
$now = date('Y-m-d H:i:s');

try {
    $pdo->beginTransaction();

    foreach ($data['attendance'] as $record) {
        $student_id = (int)$record['student_id'];
        $status = ($record['status'] === 'Present') ? 'Present' : 'Absent';
        $reason = isset($record['reason']) ? $record['reason'] : '';
        $marked_time = $now;

        // Insert or update attendance with reason and marked_time
        $sql = "INSERT INTO attendance (student_id, status, reason, marked_time, date)
                VALUES (:student_id, :status, :reason, :marked_time, :date)
                ON DUPLICATE KEY UPDATE 
                    status = :status,
                    reason = :reason,
                    marked_time = :marked_time";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'student_id' => $student_id,
            'status' => $status,
            'reason' => $reason,
            'marked_time' => $marked_time,
            'date' => $today,
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save attendance']);
}
?>
