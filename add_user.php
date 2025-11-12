<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullName']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $user_role = trim($_POST['userRole']);

    // Validate inputs
    if (empty($fullname) || empty($username) || empty($email) || empty($_POST['password']) || empty($user_role)) {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("All fields are required!"));
        exit();
    }

    // Check if email or username already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("Email or username already exists!"));
        exit();
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, user_role, date_created) 
                                VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $fullname, $username, $email, $password, $user_role);

        if ($stmt->execute()) {
            header("Location: usermanagement.php?popup=success&message=" . urlencode("User added successfully!"));
        } else {
            header("Location: usermanagement.php?popup=error&message=" . urlencode("Failed to add user. Please try again."));
        }
        $stmt->close();
    }

    $check->close();
    $conn->close();
    exit();
}
?>