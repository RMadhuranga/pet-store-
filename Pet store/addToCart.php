<?php
session_start();
require 'db.php';

// Retrieve JSON data sent via POST
$data = json_decode(file_get_contents("php://input"), true);

$productId = $data['product_id'];
$quantity = $data['quantity'] ?? 1;
$userId = $_SESSION['user_id'] ?? 0; // Assuming user_id is stored in session if logged in

// Insert or update the product in the cart
$sql = "INSERT INTO cart (user_id, product_id, quantity) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = quantity + ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $userId, $productId, $quantity, $quantity);

if ($stmt->execute()) {
    echo "Product added to cart!";
} else {
    echo "Error: Could not add product to cart.";
}

$stmt->close();
$conn->close();
?>
