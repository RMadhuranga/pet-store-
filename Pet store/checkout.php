<?php
session_start();
require 'db.php';

$userId = $_SESSION['user_id'] ?? 0;
$paymentMethod = $_POST['payment_method'];
$totalAmount = 0;

// Calculate the total amount from the cart
$sql = "SELECT p.price, c.quantity FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $totalAmount += $row['price'] * $row['quantity'];
}

// Insert the order into the orders table
$sql = "INSERT INTO orders (user_id, total_amount, payment_method) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ids", $userId, $totalAmount, $paymentMethod);
$stmt->execute();
$orderId = $stmt->insert_id;

// Insert each item from the cart into order_items and clear the cart
$sql = "INSERT INTO order_items (order_id, product_id, quantity, price)
        SELECT ?, product_id, quantity, price FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $orderId, $userId);
$stmt->execute();

// Clear the user's cart
$sql = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

echo "Order placed successfully!";

$stmt->close();
$conn->close();
?>
