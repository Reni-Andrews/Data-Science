<?php
$host = 'localhost';
$db = 'attendance_db';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

$year = $_GET['year'] ?? 1;
$date = $_GET['date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("
  SELECT s.register_number, s.name,
         COALESCE(a.status, 'Not Marked') AS status,
         COALESCE(a.reason, '') AS reason
  FROM students s
  LEFT JOIN attendance a ON s.id = a.student_id AND a.date = :date
  WHERE s.year = :year
  ORDER BY s.register_number
");
$stmt->execute(['year' => $year, 'date' => $date]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Attendance History</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <!-- Back Button -->
<div class="mb-4">
  <a href="attendance.html" class="flex items-center text-purple-600 hover:text-purple-800 font-medium">
    <!-- Back arrow icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to page
  </a>
</div>

  <h1 class="text-2xl font-bold text-center mb-6">Attendance History Viewer</h1>

  <form method="GET" class="max-w-xl mx-auto mb-6 flex flex-wrap items-center gap-4 justify-center">
    <label class="text-lg font-medium">Year:</label>
    <select name="year" class="px-3 py-2 border rounded">
      <option value="1" <?= $year == 1 ? 'selected' : '' ?>>1st Year</option>
      <option value="2" <?= $year == 2 ? 'selected' : '' ?>>2nd Year</option>
      <option value="3" <?= $year == 3 ? 'selected' : '' ?>>3rd Year</option>
    </select>

    <label class="text-lg font-medium">Date:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="px-3 py-2 border rounded" max="<?= date('Y-m-d') ?>" />

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      View
    </button>
  </form>

  <div class="overflow-x-auto">
    <table class="min-w-full border bg-white shadow">
      <thead class="bg-blue-100 text-left">
        <tr>
          <th class="border px-4 py-2">Register No</th>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Status</th>
          <th class="border px-4 py-2">Reason</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($students) > 0): ?>
          <?php foreach ($students as $s): ?>
            <tr>
              <td class="border px-4 py-2"><?= htmlspecialchars($s['register_number']) ?></td>
              <td class="border px-4 py-2"><?= htmlspecialchars($s['name']) ?></td>
              <td class="border px-4 py-2 <?= $s['status'] === 'Absent' ? 'text-red-600 font-semibold' : 'text-green-600' ?>">
                <?= htmlspecialchars($s['status']) ?>
              </td>
              <td class="border px-4 py-2"><?= htmlspecialchars($s['reason']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center py-4">No data available for selected date.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
