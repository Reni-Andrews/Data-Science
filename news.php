<?php
// news.php
$servername = "localhost";
$username = "root"; // your DB username
$password = "";     // your DB password
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT content, created_at FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>News and Updates</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-purple-50 to-pink-50 min-h-screen p-6 font-sans">
  <!-- Back Button -->
<div class="mb-4">
  <a href="student_login.html" class="flex items-center text-purple-600 hover:text-purple-800 font-medium">
    <!-- Back arrow icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to Home
  </a>
</div>



  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-700">News and Updates</h1>

    <?php if ($result && $result->num_rows > 0): ?>
      <ul class="space-y-6">
        <?php while($row = $result->fetch_assoc()): ?>
          <li class="border-l-4 border-purple-500 pl-4">
            <time class="text-sm text-gray-500 block mb-1">
              <?php echo date("d M Y, H:i", strtotime($row['created_at'])); ?>
            </time>
            <p class="text-gray-800 whitespace-pre-line"><?php echo htmlspecialchars($row['content']); ?></p>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p class="text-center text-gray-500 mt-10">No news available.</p>
    <?php endif; ?>

    <!--<div class="mt-10 text-center">
      <a href="add_news.php" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">
        Add News
      </a>
    </div>
  </div>--->

</body>
</html>
