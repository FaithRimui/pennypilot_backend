<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

$conn = new mysqli("localhost", "root", "", "financetracker");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit();
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'], $data['old_password'], $data['new_password'])) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit();
}

$user_id = intval($data['user_id']);
$old_password = $conn->real_escape_string($data['old_password']);
$new_password = $conn->real_escape_string($data['new_password']);

// Retrieve current password
$query = "SELECT password FROM users WHERE id = $user_id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit();
}

$row = $result->fetch_assoc();

if ($row['password'] !== $old_password) {
    echo json_encode(["success" => false, "message" => "Old password is incorrect"]);
    exit();
}

// Update password
$update_sql = "UPDATE users SET password = '$new_password' WHERE id = $user_id";

if ($conn->query($update_sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Password updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Update failed: " . $conn->error]);
}

$conn->close();
?>
