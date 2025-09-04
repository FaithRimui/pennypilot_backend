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
    !isset($data['user_id']) || !isset($data['amount']) || !isset($data['category']) ||
    !isset($data['date']) || !isset($data['expense_type']) ||
    empty($data['user_id']) || empty($data['amount']) || empty($data['category']) ||
    empty($data['date']) || empty($data['expense_type'])
) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

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

// Step 1: Get current budget
$query = "
    SELECT 
        b.budget_amount,
        b.created_at,
        IFNULL(SUM(e.amount), 0) as spent
    FROM budget b
    LEFT JOIN expenses e ON b.user_id = e.user_id
    WHERE b.user_id = ?
    GROUP BY b.budget_id, b.budget_amount, b.created_at
    ORDER BY b.created_at DESC
    LIMIT 1
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'No budget set.']);
    exit;
}

$row = $result->fetch_assoc();
$budget = floatval($row['budget_amount']);
$spent = floatval($row['spent']);
$remaining = $budget - $spent;

if ($amount > $remaining) {
    echo json_encode(['success' => false, 'error' => 'Expense exceeds remaining budget.']);
    exit;
}

// Insert expense
$insert = $conn->prepare("INSERT INTO expenses (user_id, amount, category, date, description, expense_type) VALUES (?, ?, ?, ?, ?, ?)");
$insert->bind_param("idssss", $user_id, $amount, $category, $date, $description, $expense_type);

if ($insert->execute()) {
    echo json_encode(['success' => true, 'expense_id' => $insert->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to insert expense']);
}

$insert->close();
$conn->close();
?>
