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

$sql = "SELECT name, paid_at FROM paid_users ORDER BY paid_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Paid Users List</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-purple-600 text-center">List of Paid Users</h1>

    <?php if ($result->num_rows > 0): ?>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="border-b py-2 px-4">Name</th>
            <th class="border-b py-2 px-4">Payment Time</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr class="hover:bg-purple-50">
              <td class="border-b py-2 px-4"><?= htmlspecialchars($row['name']) ?></td>
              <td class="border-b py-2 px-4"><?= $row['paid_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-center text-gray-600">No payments recorded yet.</p>
    <?php endif; ?>

  </div>

</body>
</html>

<?php
$conn->close();
?>
