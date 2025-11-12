<?php
session_start();
include 'db_connect.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Get the current logged-in user's ID from session
    $current_user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    
    // Check if user is trying to delete their own account
    if ($user_id === $current_user_id) {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("You cannot delete your own account!"));
        exit();
    }
    
    // Optional: Check if the user exists before attempting deletion
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows === 0) {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("User not found!"));
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    // Delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: usermanagement.php?popup=success&message=" . urlencode("User deleted successfully!"));
    } else {
        header("Location: usermanagement.php?popup=error&message=" . urlencode("Failed to delete user. Please try again."));
    }
    
    $stmt->close();
    $conn->close();
    exit();
} else {
    header("Location: usermanagement.php?popup=error&message=" . urlencode("No user ID provided!"));
    exit();
}
?>