<?php
// sidebar.php - Reusable sidebar component
?>
<!-- SIDEBAR COMPONENT -->
<link rel="stylesheet" href="styles/sidebar.css" />
<link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />

<nav class="sidebar close">
  <header>
    <div class="image-text">
      <span class="image">
        <box-icon type="solid" name="package"></box-icon>
      </span>
      <div class="text logo-text">
        <span class="name">Codinglab</span>
        <span class="profession">Web developer</span>
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
          <a href="records.php">
            <i class='bx bx-folder-open icon'></i>
            <span class="text nav-text">Records</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="users.php">
            <i class='bx bxs-user-account icon'></i>
            <span class="text nav-text">User Management</span>
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
      <li class="mode">
        <div class="sun-moon">
          <i class="bx bx-moon icon moon"></i>
          <i class="bx bx-sun icon sun"></i>
        </div>
        <span class="mode-text text">Dark mode</span>
        <div class="toggle-switch">
          <span class="switch"></span>
        </div>
      </li>
    </div>
  </div>
</nav>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script>
  const body = document.querySelector("body"),
    sidebar = body.querySelector("nav"),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");
  
  toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
  });
  
  searchBtn.addEventListener("click", () => {
    sidebar.classList.remove("close");
  });
  
  modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
      modeText.innerText = "Light mode";
    } else {
      modeText.innerText = "Dark mode";
    }
  });
</script>