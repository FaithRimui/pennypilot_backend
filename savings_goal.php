<?php
// CORS Headers
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financetracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $user_id = $_GET['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(["success" => false, "error" => "Missing user_id"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM savings_goals WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $goals = [];
    while ($row = $result->fetch_assoc()) {
        $goals[] = $row;
    }

    echo json_encode($goals);
    $stmt->close();
}

elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_id = $data['user_id'];
    $goal_name = $data['goal_name'];
    $target_amount = $data['target_amount'];
    $target_date = $data['target_date'];

    $progress_amount = 0.00;

    $stmt = $conn->prepare("INSERT INTO savings_goals (user_id, goal_name, goal_amount, progress_amount, target_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $user_id, $goal_name, $target_amount, $progress_amount, $target_date);

    echo json_encode($stmt->execute() ? ["success" => true] : ["success" => false, "error" => $stmt->error]);
    $stmt->close();
}

elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $user_id = $data['user_id'];
    $amount_to_add = $data['progress_amount'];

    // Fetch current progress amount
    $stmt = $conn->prepare("SELECT progress_amount FROM savings_goals WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["success" => false, "error" => "Goal not found"]);
        $stmt->close();
        exit;
    }

    $row = $result->fetch_assoc();
    $new_progress = $row['progress_amount'] + $amount_to_add;
    $stmt->close();

    // Update with new progress amount
    $stmt = $conn->prepare("UPDATE savings_goals SET progress_amount = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("dii", $new_progress, $id, $user_id);

    echo json_encode($stmt->execute() ? ["success" => true] : ["success" => false, "error" => $stmt->error]);
    $stmt->close();
}

elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $user_id = $data['user_id'];

    $stmt = $conn->prepare("DELETE FROM savings_goals WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);

    echo json_encode($stmt->execute() ? ["success" => true] : ["success" => false, "error" => $stmt->error]);
    $stmt->close();
}

else {
    echo json_encode(["success" => false, "error" => "Unsupported method"]);
}

$conn->close();
?>
