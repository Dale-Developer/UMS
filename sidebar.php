<?php
// sidebar.php - Reusable sidebar component

session_start();
include 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

// Fetch username & role from database using session email
$email = $_SESSION['email'];
$query = $conn->prepare("SELECT username, user_role FROM users WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

$username = $user['username'] ?? 'Unknown User';
$user_role = ucfirst($user['user_role'] ?? 'User'); // Capitalize role


?>
<!-- SIDEBAR COMPONENT -->
<link rel="stylesheet" href="styles/sidebar.css" />
<link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />

<nav class="sidebar close">
  <header>
    <div class="image-text">
      <span class="image">
        <box-icon name='user-account' type='solid' ></box-icon>
      </span>
      <div class="text logo-text">
        <span class="name"><?= htmlspecialchars($username) ?></span>
        <span class="profession"><?= htmlspecialchars($user_role) ?></span>

      </div>
    </div>
    <i class="bx bx-chevron-right toggle"></i>
  </header>
  <div class="menu-bar">
    <div class="menu">
      <li class="search-box">
        <i class="bx bx-search icon"></i>
        <input type="text" placeholder="Search..." />
      </li>
      <ul class="menu-links">
        <li class="nav-link">
          <a href="dashboard.php">
            <i class="bx bx-home-alt icon"></i>
            <span class="text nav-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="usermanagement.php">
            <i class='bx bxs-user-account icon'></i>
            <span class="text nav-text">User Management</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="records.php">
            <i class='bx bx-folder-open icon'></i>
            <span class="text nav-text">Records</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="settings.php">
            <i class='bx bx-cog icon'></i>
            <span class="text nav-text">Settings</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="bottom-content">
      <li class="">
        <a href="logout.php">
          <i class="bx bx-log-out icon"></i>
          <span class="text nav-text">Logout</span>
        </a>
      </li>
      <!-- <li class="mode">
        <div class="sun-moon">
          <i class="bx bx-moon icon moon"></i>
          <i class="bx bx-sun icon sun"></i>
        </div>
        <span class="mode-text text">Dark mode</span>
        <div class="toggle-switch">
          <span class="switch"></span>
        </div>
      </li> -->
    </div>
  </div>
</nav>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script>
  // Single, clean sidebar toggle script
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle');

    if (toggle && sidebar) {
      toggle.addEventListener('click', function () {
        sidebar.classList.toggle('close');
        document.body.classList.toggle('sidebar-closed');
        console.log('Sidebar toggled - close:', sidebar.classList.contains('close'));
      });
    }

    // Keep your existing dark mode functionality
    const body = document.querySelector("body"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");

    if (modeSwitch) {
      modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
          modeText.innerText = "Light mode";
        } else {
          modeText.innerText = "Dark mode";
        }
      });
    }
  });
</script>