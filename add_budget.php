<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (
    !isset($data['user_id']) || !isset($data['budget_amount']) ||
    empty($data['user_id']) || empty($data['budget_amount'])
) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$user_id = intval($data['user_id']);
$budget_amount = floatval($data['budget_amount']);

// DB connection
$conn = new mysqli("localhost", "root", "", "financetracker");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Fetch user's income
$income_check = $conn->prepare("SELECT income FROM users WHERE user_id = ?");
$income_check->bind_param("i", $user_id);
$income_check->execute();
$income_result = $income_check->get_result();
$user = $income_result->fetch_assoc();

if (!$user) {
    echo json_encode(['error' => 'User not found']);
    exit;
}

$income = floatval($user['income']);

if ($budget_amount > $income) {
    echo json_encode(['error' => 'Budget exceeds monthly income']);
    exit;
}

// Check if user has set a budget in the last 30 days
$check = $conn->prepare("SELECT created_at FROM budget WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$check->bind_param("i", $user_id);
$check->execute();
$result = $check->get_result();

if ($row = $result->fetch_assoc()) {
    $last_set = new DateTime($row['created_at']);
    $now = new DateTime();
    $interval = $now->diff($last_set);

    if ($interval->days < 30 && $interval->invert == 0) {
        echo json_encode(['error' => 'You can only set a budget once every 30 days.']);
        exit;
    }
}

// Insert budget (category removed)
$stmt = $conn->prepare("INSERT INTO budget (user_id, budget_amount) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $budget_amount);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'budget_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => 'Failed to insert budget']);
}

$stmt->close();
$conn->close();
?>
