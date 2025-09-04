<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "financetracker");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';

if (!$email) {
    echo json_encode(["success" => false, "message" => "Email is required"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Email not found"]);
    exit;
}

$code = rand(100000, 999999);

$insert = $conn->prepare("INSERT INTO password_resets (email, reset_code) VALUES (?, ?)");
$insert->bind_param("ss", $email, $code);
$insert->execute();

echo json_encode(["success" => true, "message" => "Reset code generated", "code" => $code]); // Remove 'code' in production
?>