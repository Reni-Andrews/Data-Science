<?php
session_start();

// DB config — change these to your database values
$host = "localhost";
$dbname = "faculty_portal";
$dbuser = "root";
$dbpass = "";

// Create connection
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Get username and password from POST
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare query to prevent SQL injection
$sql = "SELECT * FROM faculty_username_password WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password); // You can use hashed passwords here too
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['username'] = $username;

    // Redirect based on username if needed
    switch ($username) {
        case "sandrilla":
            header("Location: faculty1.html");
            break;
        case "vijay":
            header("Location: faculty2.php");
            break;
        case "f3":
            header("Location: faculty3.php");
            break;
        case "f4":
            header("Location: faculty4.php");
            break;
        case "f5":
            header("Location: faculty5.php");
            break;
        default:
            header("Location: faculty.html");
    }
    exit();
} else {
    echo "<script>
        alert('Invalid username or password!');
        window.location.href = 'faculty.html';
    </script>";
}

$stmt->close();
$conn->close();
?>
