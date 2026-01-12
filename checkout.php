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
    SELECT cart.id, cart.quantity, products.product_id, products.product_name, products.price, products.image 
    FROM cart 
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$subtotal = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $subtotal += $row['quantity'] * $row['price'];
}

// Discounts
$discount = isset($_SESSION["discount"]) ? $_SESSION["discount"] : 0;
$discount_amount = $subtotal * $discount;
$total = $subtotal - $discount_amount;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>

    <style>
        body { font-family:Poppins, sans-serif; background:#fff4f4; margin:0; padding:20px; }
        .box { background:#fff; padding:25px; border-radius:15px; max-width:850px; 
               margin:auto; box-shadow:0 5px 20px rgba(0,0,0,0.1); }

        h2 { color:#ff3b3b; text-align:center; }

        .input-field {
            width:100%; padding:12px; border-radius:10px;
            border:1px solid #ccc; margin-bottom:15px;
        }

        .payment-box {
            padding:15px; border:1px solid #ccc; border-radius:10px; margin-bottom:20px;
        }

        .buy-btn {
            width:100%; padding:15px; border:none; border-radius:10px;
            background:#ff3b3b; color:white; font-size:17px; cursor:pointer;
        }

        .buy-btn:hover { background:#d92828; }
    </style>

    <script>
        function toggleCardFields() {
            let method = document.querySelector('input[name="payment_method"]:checked').value;
            document.getElementById("card-section").style.display = (method === "card") ? "block" : "none";
        }
    </script>

</head>
<body>

<div class="box">

    <h2>Checkout</h2>

    <?php foreach ($items as $item): ?>
        <p>
            <strong><?php echo $item['product_name']; ?></strong><br>
            $<?php echo number_format($item['price'],2); ?> x <?php echo $item['quantity']; ?>
        </p>
    <?php endforeach; ?>

    <hr>
    <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal,2); ?></p>
    <p><strong>Discount:</strong> -$<?php echo number_format($discount_amount,2); ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($total,2); ?></p>

    <hr>

    <!-- SHIPPING INFORMATION -->
    <h3>Shipping Information</h3>

    <form method="POST" action="process_order.php">

        <input class="input-field" type="text" name="full_name" placeholder="Full Name" required>

        <input class="input-field" type="text" name="phone" placeholder="Phone Number" required>

        <textarea class="input-field" name="address" placeholder="Shipping Address" required></textarea>

        <input type="hidden" name="total" value="<?php echo $total; ?>">

        <!-- PAYMENT METHOD SECTION -->
        <h3>Payment Method</h3>

        <div class="payment-box">
            <label>
                <input type="radio" name="payment_method" value="card" onclick="toggleCardFields()" required> Card Payment
            </label><br>

            <label>
                <input type="radio" name="payment_method" value="cod" onclick="toggleCardFields()"> Cash on Delivery
            </label>
        </div>

        <!-- CARD FIELDS (HIDDEN UNTIL SELECTED) -->
        <div id="card-section" style="display:none;">
            <input class="input-field" type="text" name="card_number" placeholder="Card Number">

            <input class="input-field" type="text" name="expiry" placeholder="MM/YY">

            <input class="input-field" type="text" name="cvv" placeholder="CVV">
        </div>

        <button type="submit" class="buy-btn">Place Order</button>

    </form>

</div>

</body>
</html>

