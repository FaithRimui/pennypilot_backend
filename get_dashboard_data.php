<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connection.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if (!$user_id) {
    echo json_encode(["error" => "User ID missing or invalid."]);
    exit();
}

// Get user income (from users.income)
$query1 = "SELECT income FROM users WHERE user_id = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$user_income = 0;
if ($row = $result1->fetch_assoc()) {
    $user_income = floatval($row['income']);
}

// Calculate total expenses for user
$query2 = "SELECT IFNULL(SUM(amount), 0) as total_expenses FROM expenses WHERE user_id = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$total_expenses = 0;
if ($row = $result2->fetch_assoc()) {
    $total_expenses = floatval($row['total_expenses']);
}

// Calculate balance
$balance = $user_income - $total_expenses;

// Get last income date from income table
$query3 = "SELECT date_received FROM income WHERE user_id = ? ORDER BY date_received DESC LIMIT 1";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("i", $user_id);
$stmt3->execute();
$result3 = $stmt3->get_result();
$last_income_date = null;
if ($row = $result3->fetch_assoc()) {
    $last_income_date = $row['date_received'];
}

echo json_encode([
    "total_income" => $user_income,
    "expenses" => $total_expenses,
    "balance" => $balance,
    "last_income_date" => $last_income_date
]);
?>
