<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullName']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $user_role = trim($_POST['userRole']);

    // Check if email or username already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Redirect with error popup - user already exists
        header("Location: usermanagement.php?popup=exists");
        exit();
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, user_role, date_created) 
                                VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $fullname, $username, $email, $password, $user_role);

        if ($stmt->execute()) {
            // Redirect with success popup - user added to table
            header("Location: usermanagement.php?popup=success");
            exit();
        } else {
            // Redirect with error popup - database error
            header("Location: usermanagement.php?popup=error");
            exit();
        }
    }

    $stmt->close();
    $conn->close();
}
?>