<?php
session_start();

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "financetracker");

$raw_input = file_get_contents("php://input");
$data = json_decode($raw_input, true);

if (!$data || !isset($data['email']) || !isset($data['password']) || !isset($data['captcha'])) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];
$captcha = $data['captcha'];

// ✅ CAPTCHA check
if (!isset($_SESSION['captcha']) || strtolower($captcha) !== strtolower($_SESSION['captcha'])) {
    echo json_encode(["success" => false, "message" => "Invalid CAPTCHA"]);
    exit;
}

// ✅ Admin logic
if ($email === "pennypilotadmin@gmail.com" && $password === "Penny25#") {
    echo json_encode([
        "success" => true,
        "role" => "admin",
        "username" => "Penny Admin"
    ]);
    exit;
}

// ✅ Regular user lookup
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Email not found"]);
    exit;
}

$user = $result->fetch_assoc();

if (password_verify($password, $user['password_hash'])) {
    echo json_encode([
        "success" => true,
        "role" => "user",
        "user_id" => $user['user_id'],
        "username" => $user['username'],
        "email" => $user['email']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Incorrect password"]);
}
?>
