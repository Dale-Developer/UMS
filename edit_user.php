<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $userId = $_POST['userId'];
  $fullname = $_POST['fullName'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $userRole = $_POST['userRole'];
  $status = $_POST['status'];
  $password = $_POST['password'];

  if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET fullname=?, email=?, username=?, password=?, user_role=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $fullname, $email, $username, $hashedPassword, $userRole, $status, $userId);
  } else {
    $sql = "UPDATE users SET fullname=?, email=?, username=?, user_role=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $fullname, $email, $username, $userRole, $status, $userId);
  }

  if ($stmt->execute()) {
    echo "<script>alert('User updated successfully!'); window.location.href='usermanagement.php';</script>";
  } else {
    echo "<script>alert('Error updating user: " . $conn->error . "'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
?>
