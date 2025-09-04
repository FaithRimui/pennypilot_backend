<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "financetracker");

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$reset_code = $data['code'] ?? '';
$new_password = $data['new_password'] ?? '';

if (!$email || !$reset_code || !$new_password) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM password_resets WHERE email = ? AND reset_code = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("ss", $email, $reset_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Invalid code or email"]);
    exit;
}

$hashed = password_hash($new_password, PASSWORD_DEFAULT);
$update = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$update->bind_param("ss", $hashed, $email);
$update->execute();

$conn->query("DELETE FROM password_resets WHERE email = '$email'");

echo json_encode(["success" => true, "message" => "Password reset successfully"]);
?>