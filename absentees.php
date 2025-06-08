<?php
$host = 'localhost';
$db = 'attendance_db';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

$today = date('Y-m-d');

$stmt = $pdo->prepare("
  SELECT s.register_number, s.name, a.reason
  FROM attendance a
  JOIN students s ON a.student_id = s.id
  WHERE a.date = :today AND a.status = 'Absent'
  ORDER BY s.register_number
");
$stmt->execute(['today' => $today]);
$absentees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Absentees List</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-100">

  <!-- Navbar -->
  <nav class="bg-blue-200 text-white p-4 flex items-center justify-between fixed top-0 w-full z-50">
    <button onclick="openSidebar()" class="p-2 bg-gray-700 text-white rounded-md">☰</button>
    <ul class="hidden md:flex space-x-5 text-black">
      <li><a href="faculty.html" class="hover:underline">Faculty</a></li>
      <li><a href="student_login.html" class="hover:underline">Student</a></li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside
    id="sidebar"
    class="w-64 md:w-80 bg-gray-900 text-gray-100 min-h-screen p-6 fixed top-0 left-0 z-50 shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out"
  >
    <button
      onclick="closeSidebar()"
      class="absolute top-6 right-6 p-2 rounded-full bg-gray-700 hover:bg-red-600 transition-colors duration-300 z-50"
      aria-label="Close sidebar"
    >
      🡸
    </button>

    <h2 class="text-3xl font-extrabold mb-10 tracking-wide bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 bg-clip-text text-transparent select-none whitespace-nowrap">
      DATA SCIENCE
    </h2>

    <ul class="space-y-4 font-medium text-base leading-relaxed">
      <li><a href="index.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-indigo-600 hover:text-white transition duration-300 shadow-md">🏠 Home</a></li>
      <li><a href="overview.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-pink-600 hover:text-white transition duration-300 shadow-md">🔍 Overview</a></li>
      <li><a href="Department_activities.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-purple-600 hover:text-white transition duration-300 shadow-md">🏢 Department Activities</a></li>
      <li><a href="Association_events.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-indigo-600 hover:text-white transition duration-300 shadow-md">🎉 Association Events</a></li>
      <li><a href="research.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-pink-600 hover:text-white transition duration-300 shadow-md">🔬 Research</a></li>
      <li><a href="hod_message.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-purple-600 hover:text-white transition duration-300 shadow-md">📝 HOD Message</a></li>
      <li><a href="achievements.html" class="block px-5 py-2 rounded-lg bg-gray-800 hover:bg-indigo-600 hover:text-white transition duration-300 shadow-md">🏆 Achievements</a></li>
    </ul>
  </aside>
  <br>
  <br>
  <br>
  <br>
</body>
<body class="bg-yellow-50 min-h-screen p-6">
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

  <h1 class="text-xl font-bold mb-4 text-center">Today's Absentees</h1>

  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300 bg-white shadow text-sm sm:text-base">
      <thead class="bg-red-100">
        <tr>
          <th class="border px-2 py-2">Register No</th>
          <th class="border px-2 py-2">Name</th>
          <th class="border px-2 py-2">Reason</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($absentees) > 0): ?>
          <?php foreach ($absentees as $row): ?>
            <tr>
              <td class="border px-2 py-2"><?= htmlspecialchars($row['register_number']) ?></td>
              <td class="border px-2 py-2"><?= htmlspecialchars($row['name']) ?></td>
              <td class="border px-2 py-2"><?= htmlspecialchars($row['reason']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3" class="text-center py-4 text-gray-500">No absentees today 🎉</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <script>
    // Open sidebar
    function openSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.querySelector('main');
      sidebar.classList.remove('-translate-x-full');
      // Only add margin to main content on large screens
      if (window.innerWidth >= 1024) { // lg breakpoint
        main.classList.add('ml-64');
      }
    }

    // Close sidebar
    function closeSidebar() {
      const sidebar = document.getElementById('sidebar');
      const main = document.querySelector('main');
      sidebar.classList.add('-translate-x-full');
      main.classList.remove('ml-64');
    }

    // Auto-close sidebar when clicking a link inside it (good for mobile)
    window.addEventListener('DOMContentLoaded', () => {
      const sidebarLinks = document.querySelectorAll('#sidebar a');
      sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
          closeSidebar();
        });
      });
    });
    </script>
</body>
</html>
