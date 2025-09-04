<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = "localhost";
$dbname = "financetracker";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    if ($user_id <= 0) {
        echo json_encode([]);
        exit;
    }

    // Fetch the most recent budget entry
   $stmt = $pdo->prepare("
    SELECT 
        b.budget_id, 
        b.budget_amount, 
        b.created_at,
        IFNULL(SUM(e.amount), 0) AS spent
    FROM budget b
    LEFT JOIN expenses e 
        ON b.user_id = e.user_id
    WHERE b.user_id = ?
    GROUP BY b.budget_id, b.budget_amount, b.created_at
");

    $stmt->execute([$user_id]);
    $budget = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($budget ? $budget : []);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}
?>
