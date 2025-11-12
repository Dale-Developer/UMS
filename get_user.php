<?php
include 'db_connect.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'No user ID provided']);
}

$conn->close();
?>