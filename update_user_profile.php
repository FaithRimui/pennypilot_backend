<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:3000'); 
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents('php://input'), true);

if (
    !isset($data['user_id']) || 
    !isset($data['username']) || 
    !isset($data['email']) || 
    !isset($data['phone'])
) {
    echo json_encode(['error' => 'Missing required fields']);
    exit();
}

$user_id = intval($data['user_id']);
$username = $data['username'];
$email = $data['email'];
$phone = $data['phone'];

$host = 'localhost';
$db = 'financetracker';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Optional: add input validation here (email format, phone format, username rules)

$sql = "UPDATE users SET username = ?, email = ?, phone = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $username, $email, $phone, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to update profile']);
}

$stmt->close();
$conn->close();
?>
