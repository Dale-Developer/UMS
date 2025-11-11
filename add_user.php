<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullName'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $userRole = $_POST['userRole'];

  $sql = "INSERT INTO users (fullname, email, username, password, user_role, status, created_at)
          VALUES (?, ?, ?, ?, ?, 'active', NOW())";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $fullname, $email, $username, $password, $userRole);

  if ($stmt->execute()) {
    echo "<script>alert('User added successfully!'); window.location.href='usermanagement.php';</script>";
  } else {
    echo "<script>alert('Error adding user: " . $conn->error . "'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
?>
