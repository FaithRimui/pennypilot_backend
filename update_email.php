<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Database connection
$conn = new mysqli("localhost", "root", "", "financetracker");

// Check for connection error
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit();
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['email'])) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit();
}

$username = $conn->real_escape_string($data['username']);
$email = $conn->real_escape_string($data['email']);

$sql = "UPDATE users SET email = '$email' WHERE username = '$username'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Email updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
