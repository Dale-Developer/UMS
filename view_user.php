<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
  } else {
    echo json_encode(["error" => "User not found"]);
  }

  $stmt->close();
  $conn->close();
}
?>
