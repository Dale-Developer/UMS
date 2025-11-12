<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = trim($_POST['userId']);
    $fullname = trim($_POST['fullName']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $user_role = trim($_POST['userRole']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($fullname) || empty($username) || empty($email) || empty($user_role)) {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("All fields are required!"));
        exit();
    }

    // Check if email or username already exists (excluding current user)
    $check = $conn->prepare("SELECT * FROM users WHERE (email = ? OR username = ?) AND id != ?");
    $check->bind_param("ssi", $email, $username, $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("Email or username already exists!"));
        exit();
    }

    // Update user information
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, password = ?, user_role = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $fullname, $username, $email, $hashed_password, $user_role, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, user_role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $fullname, $username, $email, $user_role, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: usermanagement.php?popup=success&message=" . urlencode("User updated successfully!"));
    } else {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("Failed to update user. Please try again."));
    }
    
    $stmt->close();
    $check->close();
    $conn->close();
    exit();
}
?>