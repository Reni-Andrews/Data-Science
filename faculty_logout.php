<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    session_destroy();
    header("Location: index.html");
    exit();
} else {
    http_response_code(405); // Optional: explicitly return 405
    echo "405 Method Not Allowed";
}
?>
