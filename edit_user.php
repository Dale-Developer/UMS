<?php
include 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['userId']);
    $fullname = $_POST['fullName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $user_role = $_POST['userRole'];
    
    // Check if password is provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET fullname = ?, email = ?, username = ?, user_role = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $fullname, $email, $username, $user_role, $password, $user_id);
    } else {
        $sql = "UPDATE users SET fullname = ?, email = ?, username = ?, user_role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $fullname, $email, $username, $user_role, $user_id);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>