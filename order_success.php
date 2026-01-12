<?php
session_start();
include 'db.php';

if (!isset($_GET["order_id"])) {
    header("Location: home.php");
    exit();
}

$order_id = $_GET["order_id"];

// Fetch order info
$order_sql = "SELECT o.*, u.username 
              FROM orders o 
              JOIN users u ON o.user_id = u.id
              WHERE o.order_id = ?";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch order items
$item_sql = "
    SELECT oi.quantity, oi.price, p.product_name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
";
$stmt_items = $conn->prepare($item_sql);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Complete</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #fff5f5;
            padding: 30px;
        }
        .box {
            background: white;
            width: 70%;
            margin: auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 8px 25px rgba(0,0,0,0.12);
        }
        h2 { color: #ff3b3b; text-align: center; }
        .section-title { font-size: 20px; margin-top: 25px; font-weight: 600; }
        .item-row { padding: 10px 0; border-bottom: 1px solid #eee; }
        strong { color: #222; }
        a {
            text-decoration: none;
            background: #ff3b3b;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 25px;
            font-weight: 600;
            text-align: center;
        }
        a:hover { background: #e02d2d; }
    </style>
</head>

<body>

<div class="box">

    <h2>🎉 Order Successful!</h2>
    <p>Your order ID is <strong>#<?= $order_id; ?></strong></p>

    <!-- Customer Info -->
    <div class="section-title">📦 Shipping Information</div>
    <p><strong>Name:</strong> <?= htmlspecialchars($order["full_name"]); ?></p>
    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order["address"])); ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($order["phone"]); ?></p>

    <!-- Order Details -->
    <div class="section-title">🛒 Order Summary</div>

    <?php 
    $total_display = 0;
    while ($item = $items->fetch_assoc()) { 
        $line_total = $item["quantity"] * $item["price"];
        $total_display += $line_total;
    ?>
        <div class="item-row">
            <strong><?= $item["product_name"]; ?></strong><br>
            Quantity: <?= $item["quantity"]; ?><br>
            Price: $<?= number_format($item["price"], 2); ?><br>
            Line Total: $<?= number_format($line_total, 2); ?>
        </div>
    <?php } ?>

    <p class="section-title">💰 Total Paid: $<?= number_format($order["total_amount"], 2); ?></p>
    <p><strong>Order Date:</strong> <?= $order["order_date"]; ?></p>

    <a href="home.php">Return to Dashboard</a>
</div>

</body>
</html>
