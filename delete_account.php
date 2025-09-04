<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// DB credentials
$host = "localhost";
$user = "root";
$password = "";
$dbname = "financetracker";

// Connect to DB
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"));
if (!isset($data->username)) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$username = $conn->real_escape_string($data->username);

// Optional: delete user-related data in other tables here (if any)

// Delete user account
$query = "DELETE FROM users WHERE username = '$username'";
if ($conn->query($query) === TRUE) {
    echo json_encode(["success" => true, "message" => "Account deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete account"]);
}

$conn->close();
?>