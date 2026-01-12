<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST["cart_id"]) || !isset($_POST["action"])) {
    header("Location: cart.php");
    exit();
}

$cart_id = $_POST["cart_id"];
$action = $_POST["action"];

// Get current quantity
$stmt = $conn->prepare("SELECT quantity FROM cart WHERE id = ?");
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$current_qty = $row["quantity"];

// Update quantity
if ($action === "add") {
    $new_qty = $current_qty + 1;
} elseif ($action === "subtract") {
    $new_qty = max(1, $current_qty - 1); // Never below 1
}

// Save update
$update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
$update->bind_param("ii", $new_qty, $cart_id);
$update->execute();

header("Location: cart.php");
exit();
?>

