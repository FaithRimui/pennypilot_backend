<?php
header('Content-Type: application/json');
require 'db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$budget_id = isset($data['budget_id']) ? intval($data['budget_id']) : 0;

if ($budget_id <= 0) {
    echo json_encode(['error' => 'Invalid budget ID']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM budgets WHERE budget_id = ?");
$stmt->bind_param("i", $budget_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to delete budget']);
}
?>
