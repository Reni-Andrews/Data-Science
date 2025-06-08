<?php
session_start();

if (!isset($_SESSION['username'])) {
    // User not logged in, redirect to login page
    header("Location: faculty.html");
    exit();
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sandrilla Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 overflow-x-hidden font-sans">

  <!-- Navbar -->
  <nav class="bg-gray-900 text-white p-4 flex items-center justify-between">
    <button 
      onclick="openSidebar()" 
      class="p-2 bg-gray-700 hover:bg-gray-600 rounded-md transition"
      aria-label="Open sidebar"
    >
      ☰
    </button>
    <ul class="flex space-x-6 text-sm md:text-base">
      <li><a href="change_password.html" class="hover:underline">Change Password</a></li>
      <li><a href="absentees.php" class="hover:underline">Absentees</a></li>
      <li><a href="attendance_history.php" class="hover:underline">Attendance history</a></li>
      <li><a href="alumni.html" class="hover:underline">Alumni</a></li>
      <li><a href="news.php" class="hover:underline">Notice</a></li>
      <li><form action="faculty_logout.php" method="POST" class="inline">
  <button type="submit" class="bg-red-600 px-4 py-1 rounded text-white hover:bg-red-700">Logout</button>
</form>
</li>

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

  <!-- Main content -->
  <main
    id="main-content"
    class="p-6 transition-all duration-300 ease-in-out max-w-4xl mx-auto"
  >
    <!-- Profile Section -->
    <section id="profileCard" class="mb-12">
      <h1 class="text-4xl font-extrabold mb-3 text-gray-900" >Welcome, Sandrilla</h1>
      <p class="text-gray-600 text-lg mb-8">This is your personal faculty dashboard.</p>

      <div class="bg-white rounded-xl shadow-md p-8 max-w-md mx-auto text-center">
        <img
          src="T100501.jpg"
          alt="Faculty Photo"
          class="mx-auto rounded-full w-36 h-36 object-cover mb-6 border-4 border-blue-500"
          loading="lazy"
        />
        <h2 class="text-2xl font-semibold text-gray-900 mb-1">Name: R. Sandrilla</h2>
        <p class="text-gray-700">Date of Birth: January 12, 1987</p>
        <p class="text-gray-700">Role: Assistant Professor &amp; HoD</p>
        <p class="text-gray-700">Register Number:T100501</p>
      </div>
    </section>

    <section>
      
<body class="bg-blue-50 min-h-screen p-6 font-sans">

  <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <h1 class="text-3xl font-bold text-center py-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white">📚 Time Table</h1>

    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse border border-gray-300 text-center">
        <thead class="bg-blue-200 text-gray-800">
          <tr>
            <th class="border border-gray-300 px-4 py-2">Day Order/Hour</th>
            <th class="border border-gray-300 px-4 py-2">8:30 - 9:25</th>
            <th class="border border-gray-300 px-4 py-2">9:25 - 10:20</th>
            <th class="border border-gray-300 px-4 py-2 bg-yellow-100">BREAK<br>11:15 - 11:30</th>
            <th class="border border-gray-300 px-4 py-2">10:20 - 11:15</th>
            <th class="border border-gray-300 px-4 py-2">11:30 - 12:25</th>
            <th class="border border-gray-300 px-4 py-2">12:25 - 1:15</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr class="bg-white">
            <td class="border px-4 py-2 font-semibold">I</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2 bg-yellow-50 text-gray-500 font-semibold">--</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
          </tr>
          <tr class="bg-gray-50">
            <td class="border px-4 py-2 font-semibold">II</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2 bg-yellow-50 text-gray-500 font-semibold">BREAK</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
          </tr>
          <tr class="bg-white">
            <td class="border px-4 py-2 font-semibold">III</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2 bg-yellow-50 text-gray-500 font-semibold">--</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
          </tr>
          <tr class="bg-white">
            <td class="border px-4 py-2 font-semibold">IV</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2 bg-yellow-50 text-gray-500 font-semibold">BREAK</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
          </tr>
          <tr class="bg-gray-50">
            <td class="border px-4 py-2 font-semibold">V</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2 bg-yellow-50 text-gray-500 font-semibold">--</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
          </tr>
          <tr class="bg-white">
            <td class="border px-4 py-2 font-semibold">VI</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2 bg-yellow-50 text-gray-500 font-semibold">BREAK</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
            <td class="border px-4 py-2">p</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

    </section>

   
  </main>

  <script>

  
    function openSidebar() {
      document.getElementById("sidebar").classList.remove("-translate-x-full");
      if (window.innerWidth >= 1024) {
        document.getElementById("main-content").classList.add("ml-64");
      }
    }

    function closeSidebar() {
      document.getElementById("sidebar").classList.add("-translate-x-full");
      document.getElementById("main-content").classList.remove("ml-64");
    }

    window.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll("#sidebar a").forEach((link) => {
        link.addEventListener("click", closeSidebar);
      });

      // Change password link toggle
      document.getElementById("changePasswordLink").addEventListener("click", function (e) {
        e.preventDefault();
        document.getElementById("profileCard").classList.add("hidden");
        document.getElementById("changePasswordSection").classList.remove("hidden");
        document.getElementById("passwordMessage").textContent = "";
        document.getElementById("changePasswordForm").reset();
      });

      // Handle password form submission
      document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const current = document.getElementById("currentPassword").value;
        const newPass = document.getElementById("newPassword").value;
        const confirm = document.getElementById("confirmPassword").value;
        const msg = document.getElementById("passwordMessage");

        if (newPass !== confirm) {
          msg.textContent = "❌ New passwords do not match.";
          msg.className = "text-red-500 text-center mt-4";
          return;
        }

        fetch("change_password.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            username: "sandrilla", // Hardcoded for now
            current: current,
            new: newPass,
          }),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              msg.textContent = "✅ Password changed successfully!";
              msg.className = "text-green-500 text-center mt-4";
              document.getElementById("changePasswordForm").reset();
            } else {
              msg.textContent = "❌ " + data.message;
              msg.className = "text-red-500 text-center mt-4";
            }
          })
          .catch((err) => {
            msg.textContent = "❌ Server error.";
            msg.className = "text-red-500 text-center mt-4";
          });
      });
    });
  </script>
</body>
</html>
