<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.10.0/src/Exception.php';
require 'PHPMailer-6.10.0/src/PHPMailer.php';
require 'PHPMailer-6.10.0/src/SMTP.php';

// DB connection
$conn = new mysqli("localhost", "root", "", "financetracker");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$full_name = $data['full_name'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$password = $data['password'] ?? '';

// Full name must contain only letters and spaces, and at least two words
if (!preg_match("/^[A-Za-z]+(\s[A-Za-z]+)+$/", trim($full_name))) {
    echo json_encode(["success" => false, "message" => "Full name must contain only letters and at least two words."]);
    exit;
}

// Check for required fields
if (!$full_name || !$email || !$phone || !$password) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

// Check for duplicate email or phone
$check = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
$check->bind_param("ss", $email, $phone);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email or phone already in use."]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, phone, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $full_name, $email, $hashedPassword, $phone);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;

    // Generate OTP
    $otp_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

    // Save OTP
    $otp_stmt = $conn->prepare("INSERT INTO otp_codes (user_id, otp_code, purpose) VALUES (?, ?, 'signup')");
    $otp_stmt->bind_param("is", $user_id, $otp_code);
    $otp_stmt->execute();

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '920a80e6de4eb0';
        $mail->Password = 'f1e7f324777516';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom('no-reply@pennypilot.test', 'Penny Pilot');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Penny Pilot OTP Code';
        $mail->Body = "Hello $full_name,<br><br>Your OTP is: <strong>$otp_code</strong><br>This code will expire in 10 minutes.";

        $mail->send();

        echo json_encode([
            "success" => true,
            "message" => "Signup successful. OTP sent.",
            "otp" => $otp_code
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Signup done but OTP failed to send. Mailer Error: " . $mail->ErrorInfo
        ]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Signup failed. Try again."]);
}
?>
