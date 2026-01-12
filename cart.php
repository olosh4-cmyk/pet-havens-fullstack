<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch cart items
$query = "
SELECT c.id AS cart_id, c.quantity, 
       p.product_name, p.price, p.image
FROM cart c
JOIN products p ON c.product_id = p.product_id
WHERE c.user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $subtotal += $row["price"] * $row["quantity"];
    $cart_items[] = $row;
}

// Discount logic
$discount_amount = 0;
$discount_code = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["apply_discount"])) {
    $discount_code = strtolower(trim($_POST["discount_code"]));

    if ($discount_code === "pet10") {
        $discount_amount = $subtotal * 0.10;
    }
}

$total = $subtotal - $discount_amount;
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #fff5f5;
            padding: 30px;
        }

        .cart-wrapper {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0px 8px 25px rgba(0,0,0,0.12);
        }

        .cart-wrapper h2 {
            color: #ff3b3b;
            text-align: center;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 15px;
            margin-right: 25px;
        }

        .cart-info h3 {
            margin: 0;
            color: #ff3b3b;
            font-size: 22px;
        }

        .qty-controls {
            margin-top: 10px;
        }

        .qty-btn {
            background: #ff3b3b;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            margin: 0 5px;
        }

        .remove-btn {
            background: black;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
        }

        .summary-box {
            margin-top: 30px;
            background: #fff0f0;
            padding: 20px;
            border-radius: 15px;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            background: #ff3b3b;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            font-weight: bold;
        }

        .discount-box input {
            padding: 8px;
            width: 170px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .discount-btn {
            background: #000;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

    </style>
</head>

<body>

<div class="cart-wrapper">
    <h2>My Cart 🛒</h2>

    <?php if (empty($cart_items)) { ?>
        <p style="text-align:center; font-size:18px;">Your cart is empty.</p>
    <?php } ?>

    <?php foreach ($cart_items as $row) { ?>
    
    <div class="cart-item">
        <img src="<?php echo $row['image']; ?>">

        <div class="cart-info">
            <h3><?php echo $row['product_name']; ?></h3>
            <p>Price: $<?php echo number_format($row['price'], 2); ?></p>

            <div class="qty-controls">
                <form action="update_quantity.php" method="POST" style="display:inline;">
                    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                    <button type="submit" name="action" value="subtract" class="qty-btn">-</button>
                </form>

                <span style="font-size:16px; margin:0 10px;"><?php echo $row['quantity']; ?></span>

                <form action="update_quantity.php" method="POST" style="display:inline;">
                    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                    <button type="submit" name="action" value="add" class="qty-btn">+</button>
                </form>

                <a href="remove.php?id=<?php echo $row['cart_id']; ?>" class="remove-btn">Remove</a>
            </div>
        </div>
    </div>

    <?php } ?>

    <!-- Summary -->
    <div class="summary-box">
        <h3>Order Summary</h3>
        <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>

        <!-- Discount Form -->
        <form method="POST">
            <div class="discount-box">
                <input type="text" name="discount_code" placeholder="Enter discount code">
                <button type="submit" name="apply_discount" class="discount-btn">Apply</button>
            </div>
        </form>

        <?php if ($discount_amount > 0) { ?>
            <p>Discount Applied: -$<?php echo number_format($discount_amount, 2); ?></p>
        <?php } ?>

        <h3>Total: $<?php echo number_format($total, 2); ?></h3>

        <a href="process_order.php?total=<?php echo $total; ?>" class="checkout-btn">Checkout</a>
    </div>

</div>

</body>
</html>
