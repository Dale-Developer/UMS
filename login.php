<?php
include 'db_connect.php';

$showPopup = false;

if (isset($_POST['login'])) {
  $email = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Secure query (fetch user by email)
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify hashed password
    if (password_verify($password, $user['password'])) {
      session_start();
      $_SESSION['email'] = $user['email'];
      $_SESSION['user_role'] = $user['user_role']; // optional
      header("Location: dashboard.php");
      exit();
    } else {
      $showPopup = true; // incorrect password
    }
  } else {
    $showPopup = true; // user not found
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/login.css">
  <title>LOGIN</title>
</head>

<body>
  <header>RECORD MANAGEMENT SYSTEM</header>

  <div class="container" id="container">
    <!-- SIGN UP FORM -->
    <div class="form-container sign-up-container">
      <form action="register.php" method="POST">
        <h1>Create Account</h1>
        <input type="text" placeholder="Full Name" name="fullname" required />
        <input type="text" placeholder="Username" name="username" required />
        <input type="email" placeholder="Email" name="email" required />
        <input type="password" placeholder="Password" name="password" required />
        <select name="user_role" id="roles" required>
          <option value="">Select Role:</option>
          <option value="admin">Admin</option>
          <option value="staff">Staff</option>
          <option value="regular_user">Regular User</option>
        </select>
        <button type="submit">Sign Up</button>
      </form>
    </div>

    <!-- SIGN IN FORM -->
    <div class="form-container sign-in-container">
      <form action="login.php" method="POST">
        <h1>Sign in</h1>
        <input type="text" placeholder="Username" name="username" required />
        <input type="password" placeholder="Password" name="password" required />
        <a href="#">Forgot your password?</a>
        <button type="submit" name="login">Sign In</button>
      </form>
    </div>

    <!-- OVERLAY PANELS -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Friend!</h1>
          <p>Enter your personal details and start your journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>

  <!-- POPUP FOR INVALID LOGIN
  <div id="popup" class="popup" style="display: <?= $showPopup ? 'flex' : 'none'; ?>;">
    <div class="popup-content">
      <h2>Login Failed</h2>
      <p>Invalid username or password.</p>
      <button onclick="closePopup()">OK</button>
    </div>
  </div>

   -->
  <?php
  // Handle popup messages (login.php?popup=success, etc.)
  $popupType = $_GET['popup'] ?? '';
  $popupMessage = '';

  if ($popupType === 'success') {
    $popupMessage = ['title' => 'Account Created', 'text' => 'Your account was created successfully! Please log in.', 'color' => '#22c55e'];
  } elseif ($popupType === 'exists') {
    $popupMessage = ['title' => 'Registration Failed', 'text' => 'Email or username already exists.', 'color' => '#ef4444'];
  } elseif ($popupType === 'error') {
    $popupMessage = ['title' => 'Error', 'text' => 'An error occurred during registration.', 'color' => '#ef4444'];
  } elseif ($showPopup) {
    $popupMessage = ['title' => 'Login Failed', 'text' => 'Invalid username or password.', 'color' => '#ef4444'];
  }
  ?>

  <!-- POPUP -->
  <?php if (!empty($popupMessage)): ?>
    <div id="popup" class="popup" style="display: flex;">
      <div class="popup-content" style="border-left: 5px solid <?= $popupMessage['color'] ?>;">
        <h2><?= htmlspecialchars($popupMessage['title']) ?></h2>
        <p><?= htmlspecialchars($popupMessage['text']) ?></p>
        <button onclick="closePopup()">OK</button>
      </div>
    </div>
  <?php endif; ?>

  <!-- JAVASCRIPT -->
  <script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
      container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
      container.classList.remove("right-panel-active");
    });

    function closePopup() {
      document.getElementById("popup").style.display = "none";
    }
  </script>
</body>

</html>