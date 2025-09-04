<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.10.0/src/Exception.php';
require 'PHPMailer-6.10.0/src/PHPMailer.php';
require 'PHPMailer-6.10.0/src/SMTP.php';

// Handle CORS
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin === 'http://localhost:3000') {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
} else {
    header("Access-Control-Allow-Origin: *");
}
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "financetracker");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$email = trim($data['email'] ?? '');

if (empty($email)) {
    echo json_encode(["success" => false, "message" => "Email is required."]);
    exit;
}

// Lookup user
$stmt = $conn->prepare("SELECT user_id, username FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Email not found."]);
    exit;
}

$user = $result->fetch_assoc();
$user_id = $user['user_id'];
$full_name = $user['username'];

// Generate and store reset code
$reset_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$insert = $conn->prepare("INSERT INTO otp_codes (user_id, otp_code, purpose) VALUES (?, ?, 'reset')");
$insert->bind_param("is", $user_id, $reset_code);
$insert->execute();

// Send email using Mailtrap
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
    $mail->Subject = 'Penny Pilot Password Reset Code';
    $mail->Body = "Hello $full_name,<br><br>Your password reset code is: <strong>$reset_code</strong><br>This code will expire in 10 minutes.";

    $mail->send();

    echo json_encode(["success" => true, "message" => "Reset code sent to your email."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Could not send email. Error: " . $mail->ErrorInfo]);
}
?>
