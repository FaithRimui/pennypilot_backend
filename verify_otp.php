<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

$conn = new mysqli("localhost", "root", "", "financetracker");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$otp = $data['otp'] ?? '';

if (!$email || !$otp) {
    echo json_encode(["success" => false, "message" => "Email and OTP required."]);
    exit;
}

// Get user ID
$userQuery = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$userQuery->bind_param("s", $email);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found."]);
    exit;
}

$user = $userResult->fetch_assoc();
$user_id = $user['user_id'];

// Verify OTP
$otpQuery = $conn->prepare("SELECT * FROM otp_codes WHERE user_id = ? AND otp_code = ? AND purpose = 'signup'");
$otpQuery->bind_param("is", $user_id, $otp);
$otpQuery->execute();
$otpResult = $otpQuery->get_result();

if ($otpResult->num_rows > 0) {
    // Optional: Delete OTP after successful verification
    $deleteOtp = $conn->prepare("DELETE FROM otp_codes WHERE user_id = ? AND purpose = 'signup'");
    $deleteOtp->bind_param("i", $user_id);
    $deleteOtp->execute();

    echo json_encode(["success" => true, "message" => "OTP verified successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid or expired OTP."]);
}
?>
