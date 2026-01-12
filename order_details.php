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

// Verify order belongs to user
$check = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$check->bind_param("ii", $order_id, $user_id);
$check->execute();
$order = $check->get_result()->fetch_assoc();

if (!$order) {
    header("Location: orders.php");
    exit();
}

// Fetch items
$sql = "
SELECT oi.quantity, oi.price, p.product_name, p.image
FROM order_items oi
JOIN products p ON oi.product_id = p.product_id
WHERE oi.order_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>

    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #fff5f5;
            padding: 30px;
        }

        .details-box {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0px 8px 25px rgba(0,0,0,0.12);
        }

        h2 {
            text-align: center;
            color: #ff3b3b;
        }

        .item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .item img {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 20px;
        }

        .back-btn, .delete-btn {
            display: inline-block;
            margin-top: 20px;
            background: #ff3b3b;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }

        .delete-btn {
            background: #444;
            margin-left: 15px;
        }

        .delete-btn:hover {
            background: #111;
        }
    </style>
</head>

<body>

<div class="details-box">

    <h2>Order #<?php echo $order_id; ?></h2>

    <p><strong>Total Paid:</strong> $<?php echo number_format($order["total_amount"], 2); ?></p>
    <p><strong>Status:</strong> <?php echo $order["status"]; ?></p>
    <p><strong>Date:</strong> <?php echo $order["order_date"]; ?></p>

    <a class="delete-btn"
       href="delete_order.php?order_id=<?php echo $order_id; ?>"
       onclick="return confirm('Permanently delete this order?');">
        Delete Order
    </a>

    <hr><br>

    <?php while ($row = $items->fetch_assoc()) { ?>
        <div class="item">
            <img src="<?php echo $row["image"]; ?>">
            <div>
                <h3><?php echo $row["product_name"]; ?></h3>
                <p>Price: $<?php echo number_format($row["price"], 2); ?></p>
                <p>Quantity: <?php echo $row["quantity"]; ?></p>
            </div>
        </div>
    <?php } ?>

    <a href="orders.php" class="back-btn">← Back to Orders</a>

</div>

</body>
</html>

