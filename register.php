<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = trim($_POST['fullname']);
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
  $user_role = trim($_POST['user_role']);

  // Check if email or username already exists
  $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
  $check->bind_param("ss", $email, $username);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    // Redirect with error popup
    header("Location: login.php?popup=exists");
    exit();
  } else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, user_role, date_created) 
                            VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $fullname, $username, $email, $password, $user_role);

    if ($stmt->execute()) {
      // Redirect with success popup
      header("Location: login.php?popup=success");
      exit();
    } else {
      // Redirect with error popup
      header("Location: login.php?popup=error");
      exit();
    }
  }

  $stmt->close();
  $conn->close();
}
?>
