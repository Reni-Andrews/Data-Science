<?php
session_start();

$host = 'localhost';
$db = 'faculty_portal';
$user = 'root'; // update if needed
$pass = '';     // your MySQL password
$conn = new mysqli($host, $user, $pass, $db);

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $_SESSION['username'];
    $current = $data['current'] ?? '';
    $new = $data['new'] ?? '';

    if (!$current || !$new) {
        echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
        exit;
    }

    // Check current password
    $stmt = $conn->prepare("SELECT password FROM faculty_username_password WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_pass);

    if ($stmt->fetch()) {
        if ($current === $db_pass) { // plain text check; ideally hash
            $stmt->close();
            $stmt = $conn->prepare("UPDATE faculty_username_password SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $new, $username);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Password updated']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Update failed']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect current password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
    $stmt->close();
    $conn->close();
}
?>
