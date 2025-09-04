<?php
$conn = new mysqli("localhost", "root", "", "financetracker");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
