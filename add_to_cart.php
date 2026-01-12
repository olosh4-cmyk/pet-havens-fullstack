<?php
session_start();
include "db.php";

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Make sure product_id was sent
if (!isset($_POST['product_id'])) {
    die("No product selected.");
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// CHECK IF PRODUCT EXISTS
$checkProduct = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$checkProduct->bind_param("i", $product_id);
$checkProduct->execute();
$prodResult = $checkProduct->get_result();

if ($prodResult->num_rows == 0) {
    die("Product not found in database.");
}

// CHECK IF PRODUCT IS ALREADY IN CART
$check = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
$check->bind_param("ii", $user_id, $product_id);
$check->execute();
$cartResult = $check->get_result();

if ($cartResult->num_rows > 0) {
    // UPDATE QUANTITY
    $row = $cartResult->fetch_assoc();
    $newQty = $row['quantity'] + 1;

    $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $update->bind_param("ii", $newQty, $row['id']);
    $update->execute();

} else {
    // INSERT ITEM
    $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $insert->bind_param("ii", $user_id, $product_id);
    $insert->execute();
}

// REDIRECT TO CART PAGE
header("Location: cart.php");
exit();
