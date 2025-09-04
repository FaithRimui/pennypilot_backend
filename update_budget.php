<?php
header('Content-Type: application/json');
require 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

$budget_id = isset($data['budget_id']) ? intval($data['budget_id']) : 0;
$category = isset($data['category']) ? trim($data['category']) : '';
$amount = isset($data['budget_amount']) ? floatval($data['budget_amount']) : 0;

if ($budget_id <= 0 || $category === '' || $amount <= 0) {
    echo json_encode(['error' => 'Missing or invalid input']);
    exit;
}

$stmt = $conn->prepare("UPDATE budgets SET category = ?, budget_amount = ? WHERE budget_id = ?");
$stmt->bind_param("sdi", $category, $amount, $budget_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to update budget: ' . $conn->error]);
}
?>
