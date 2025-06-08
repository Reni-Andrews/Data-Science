<?php
session_start();

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$edit_id = null;
$edit_content = "";

// Handle delete
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $conn->query("DELETE FROM news WHERE id = $del_id");
    $message = "🗑️ News deleted successfully!";
}

// Handle edit request
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM news WHERE id = $edit_id");
    if ($row = $result->fetch_assoc()) {
        $edit_content = $row['content'];
    }
}

// Handle add or update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $news_content = trim($_POST['news_content']);
    $news_id = isset($_POST['news_id']) ? intval($_POST['news_id']) : null;

    if (!empty($news_content)) {
        if ($news_id) {
            // Update
            $stmt = $conn->prepare("UPDATE news SET content = ? WHERE id = ?");
            $stmt->bind_param("si", $news_content, $news_id);
            if ($stmt->execute()) {
                $message = "✅ News updated successfully!";
            } else {
                $message = "❌ Error updating news.";
            }
        } else {
            // Add new
            $stmt = $conn->prepare("INSERT INTO news (content) VALUES (?)");
            $stmt->bind_param("s", $news_content);
            if ($stmt->execute()) {
                $message = "✅ News added successfully!";
            } else {
                $message = "❌ Error adding news.";
            }
        }
    } else {
        $message = "⚠️ Please enter some news content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage News</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-200 to-blue-100 min-h-screen flex items-center justify-center px-4 py-10">

  <script>
    if (localStorage.getItem("loggedIn") !== "true") {
      window.location.href = "student_login.html";
    }
  </script>

  <div class="absolute top-5 right-5">
    <button onclick="logout()" class="bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2 rounded-lg shadow">
      🔒 Logout
    </button>
  </div>

  <div class="bg-white/80 backdrop-blur-md p-10 rounded-3xl shadow-2xl w-full max-w-3xl transition-all">
    <h1 class="text-3xl font-extrabold text-purple-700 text-center mb-6">🗞️ Manage Daily News</h1>

    <?php if ($message): ?>
      <div class="mb-6 px-4 py-3 text-center rounded-lg border shadow text-blue-700 bg-blue-100 border-blue-300 animate-pulse">
        <?php echo htmlspecialchars($message); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="add_news.php" class="space-y-6">
      <input type="hidden" name="news_id" value="<?php echo $edit_id ?? ''; ?>"/>

      <div class="relative">
        <textarea name="news_content" rows="5" required placeholder=" "
          class="peer w-full px-4 pt-6 pb-2 text-gray-800 placeholder-transparent border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none shadow-sm"><?php echo htmlspecialchars($edit_content); ?></textarea>
        <label class="absolute left-4 top-3 text-gray-500 text-md transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-purple-700">
          ✍️ Type today's Notice or update
        </label>
      </div>

      <div class="text-center">
        <button type="submit"
          class="bg-purple-600 hover:bg-purple-700 text-white text-lg font-bold px-8 py-3 rounded-full transition duration-200 shadow-md hover:shadow-lg">
          <?php echo $edit_id ? "✏️ Update News" : "➕ Add News"; ?>
        </button>
      </div>
    </form>

    <div class="mt-10">
      <h2 class="text-xl font-semibold text-purple-700 mb-4">📋 All News</h2>
      <ul class="space-y-3">
        <?php
          $result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
          while ($row = $result->fetch_assoc()):
        ?>
          <li class="bg-white/60 border border-purple-200 rounded-xl p-4 shadow flex justify-between items-start">
            <div>
              <p class="text-gray-800"><?php echo htmlspecialchars($row['content']); ?></p>
              <small class="text-gray-500 block"><?php echo $row['created_at']; ?></small>
            </div>
            <div class="flex flex-col gap-2 ml-4">
              <a href="?edit=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-medium">✏️ Edit</a>
              <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to delete?');" class="text-red-600 hover:text-red-800 font-medium">🗑️ Delete</a>
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>

  <script>
    function logout() {
      localStorage.removeItem("loggedIn");
      window.location.href = "student_login.html";
    }
  </script>
</body>
</html>

<?php $conn->close(); ?>
