<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['expense_id'])) {
    echo json_encode(['success' => false, 'error' => 'Missing expense_id']);
    exit;
}

$expense_id = intval($data['expense_id']);

$conn = new mysqli("localhost", "root", "", "financetracker");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM expenses WHERE expense_id = ?");
$stmt->bind_param("i", $expense_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Expense not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete expense']);
}

$stmt->close();
$conn->close();
?>
