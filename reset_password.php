<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "financetracker");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$code = $data['code'] ?? '';
$new_password = $data['new_password'] ?? '';

if (empty($email) || empty($code) || empty($new_password)) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

// Check if reset code is valid
$stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND reset_code = ?");
$stmt->bind_param("ss", $email, $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Invalid reset code or email."]);
    exit;
}

// Hash new password
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

// Update user password
$update = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$update->bind_param("ss", $hashed_password, $email);
$update->execute();

// Delete reset entry
$conn->query("DELETE FROM password_resets WHERE email = '$email'");

echo json_encode(["success" => true, "message" => "Password updated successfully."]);
?>
