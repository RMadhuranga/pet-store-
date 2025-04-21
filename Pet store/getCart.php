<?php
session_start();
require 'db.php';

$userId = $_SESSION['user_id'] ?? 0;

$sql = "SELECT p.name, p.price, c.quantity, (p.price * c.quantity) as total
        FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

echo json_encode($cartItems);

$stmt->close();
$conn->close();
?>
