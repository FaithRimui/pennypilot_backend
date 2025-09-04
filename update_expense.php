<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (
    !isset($data['expense_id']) || !isset($data['user_id']) || !isset($data['amount']) ||
    !isset($data['category']) || !isset($data['date']) || !isset($data['expense_type']) ||
    empty($data['expense_id']) || empty($data['user_id']) || empty($data['amount']) ||
    empty($data['category']) || empty($data['date']) || empty($data['expense_type'])
) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$expense_id = intval($data['expense_id']);
$user_id = intval($data['user_id']);
$amount = floatval($data['amount']);
$category = trim($data['category']);
$date = trim($data['date']);
$description = isset($data['description']) ? trim($data['description']) : '';
$expense_type = trim($data['expense_type']);

$conn = new mysqli("localhost", "root", "", "financetracker");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$stmt = $conn->prepare("UPDATE expenses SET amount = ?, category = ?, date = ?, description = ?, expense_type = ? WHERE expense_id = ? AND user_id = ?");
$stmt->bind_param("dsssiis", $amount, $category, $date, $description, $expense_type, $expense_id, $user_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No rows updated']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update expense']);
}

$stmt->close();
$conn->close();
?>
