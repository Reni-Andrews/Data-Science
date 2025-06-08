<?php
// DB connection params
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "faculty_portal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get students grouped by year with payment status
$sql = "
  SELECT s.id, s.name, s.year, 
         CASE WHEN p.student_id IS NOT NULL THEN 1 ELSE 0 END AS paid
  FROM students s
  LEFT JOIN payments p ON s.id = p.student_id
  ORDER BY s.year, s.name
";

$result = $conn->query($sql);

// Group students by year in PHP
$students_by_year = [];
while ($row = $result->fetch_assoc()) {
  $students_by_year[$row['year']][] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Payment List</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

  <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6 text-purple-700 text-center">Student Payment Status</h1>

    <?php foreach ([1, 2, 3] as $year): ?>
      <h2 class="text-xl font-semibold mb-3 mt-6">Year <?= $year ?></h2>
      <?php if (!empty($students_by_year[$year])): ?>
        <ul class="divide-y divide-gray-200">
          <?php foreach ($students_by_year[$year] as $student): ?>
            <li class="py-2 flex justify-between items-center">
              <span><?= htmlspecialchars($student['name']) ?></span>
              <?php if ($student['paid']): ?>
                <span class="text-green-600 font-bold text-xl">✔️</span>
              <?php else: ?>
                <span class="text-red-400 font-bold">❌</span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="text-gray-500">No students found for this year.</p>
      <?php endif; ?>
    <?php endforeach; ?>

  </div>

</body>
</html>
