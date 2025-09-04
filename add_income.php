<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
$income = isset($data['income']) ? floatval($data['income']) : 0;
$source = isset($data['source']) ? trim($data['source']) : '';
$date_received = isset($data['date_received']) ? $data['date_received'] : date('Y-m-d');

if (!$user_id || $income <= 0 || empty($source)) {
    echo json_encode(["error" => "Invalid input data"]);
    exit();
}

// Insert new income record
$insert_query = "INSERT INTO income (user_id, amount, source, date_received) VALUES (?, ?, ?, ?)";
$insert_stmt = $conn->prepare($insert_query);
$insert_stmt->bind_param("idss", $user_id, $income, $source, $date_received);

if ($insert_stmt->execute()) {
    // Fetch current income from users table
    $select_query = "SELECT income FROM users WHERE user_id = ?";
    $select_stmt = $conn->prepare($select_query);
    $select_stmt->bind_param("i", $user_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $current_income = floatval($row['income']);
        $new_income_total = $current_income + $income;

        // Update income in users table
        $update_query = "UPDATE users SET income = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("di", $new_income_total, $user_id);
        $update_stmt->execute();
    }

    echo json_encode(["success" => "Income added successfully"]);
} else {
    echo json_encode(["error" => "Failed to add income"]);
}
?>
