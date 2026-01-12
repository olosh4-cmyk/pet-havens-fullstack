<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Validate required fields
if (
    !isset($_POST["full_name"]) ||
    !isset($_POST["address"]) ||
    !isset($_POST["phone"]) ||
    !isset($_POST["total"]) ||
    !isset($_POST["payment_method"])
) {
    header("Location: checkout.php?error=missing_fields");
    exit();
}

$full_name = trim($_POST["full_name"]);
$address   = trim($_POST["address"]);
$phone     = trim($_POST["phone"]);
$total     = $_POST["total"];
$payment_method = $_POST["payment_method"];

// Basic validation (you can extend)
if ($full_name === "" || $address === "" || $phone === "") {
    header("Location: checkout.php?error=missing_fields");
    exit();
}

// Determine payment description
if ($payment_method === "card") {
    // ensure card fields present
    if (!isset($_POST["card_number"]) || !isset($_POST["expiry"]) || !isset($_POST["cvv"])) {
        die("Card details missing.");
    }

    // We DO NOT store the full card number. For demo, record a short descriptor.
    $card_number = preg_replace('/\D/', '', $_POST["card_number"]); // digits only
    $last4 = strlen($card_number) >= 4 ? substr($card_number, -4) : $card_number;
    $payment_used = "Card ending in " . $last4;
} elseif ($payment_method === "cod") {
    $payment_used = "Cash on Delivery";
} else {
    // Unknown method (PayPal removed)
    die("Invalid payment method.");
}


// Fetch cart items
$query = "
SELECT c.quantity, p.product_id, p.price
FROM cart c 
JOIN products p ON c.product_id = p.product_id
WHERE c.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

if (count($items) == 0) {
    header("Location: cart.php?empty=1");
    exit();
}

// Insert order (add payment_method column if not present)
$order_sql = "
INSERT INTO orders (user_id, total_amount, full_name, address, phone, payment_method) 
VALUES (?, ?, ?, ?, ?, ?)
";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("idssss", $user_id, $total, $full_name, $address, $phone, $payment_used);
$order_stmt->execute();

$order_id = $conn->insert_id;

// Insert order items
$item_sql = "
INSERT INTO order_items (order_id, product_id, quantity, price)
VALUES (?, ?, ?, ?)
";
$item_stmt = $conn->prepare($item_sql);

foreach ($items as $item) {
    $item_stmt->bind_param("iiid", $order_id,
        $item["product_id"],
        $item["quantity"],
        $item["price"]
    );
    $item_stmt->execute();
}

// Clear cart
$delete = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$delete->bind_param("i", $user_id);
$delete->execute();

// Redirect to success page
header("Location: order_success.php?order_id=" . $order_id);
exit();
?>
