<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["order_id"])) {
    header("Location: orders.php");
    exit();
}

$order_id = $_GET["order_id"];
$user_id = $_SESSION["user_id"];

// Ensure order belongs to the user
$check = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$check->bind_param("ii", $order_id, $user_id);
$check->execute();
$order = $check->get_result()->fetch_assoc();

if (!$order) {
    header("Location: orders.php?error=Invalid Order");
    exit();
}

// Delete items first
$del_items = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
$del_items->bind_param("i", $order_id);
$del_items->execute();

// Delete order
$del_order = $conn->prepare("DELETE FROM orders WHERE order_id = ? AND user_id = ?");
$del_order->bind_param("ii", $order_id, $user_id);
$del_order->execute();

header("Location: orders.php?msg=Order deleted successfully");
exit();
?>
