<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Get user's orders
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #fff5f5;
            padding: 30px;
        }

        .orders-box {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        a.view-btn {
            background: #ff3b3b;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        a.view-btn:hover {
            background: #e02d2d;
        }

        /* Back button */
        .back-btn {
            display: block;
            width: 200px;
            margin: 30px auto 0 auto;
            text-align: center;
            background: #ff3b3b;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }

        .back-btn:hover {
            background: #e02d2d;
        }
    </style>
</head>

<body>

<div class="orders-box">
    <h2>My Orders 🧾</h2>

    <?php if ($result->num_rows == 0) { ?>
        <p style="text-align:center; color:#555; margin-top:15px;">You have no past orders.</p>
    <?php } else { ?>

        <table>
            <tr>
                <th>Order ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>#<?php echo $row["order_id"]; ?></td>
                    <td>$<?php echo number_format($row["total_amount"], 2); ?></td>
                    <td><?php echo $row["status"]; ?></td>
                    <td><?php echo $row["order_date"]; ?></td>
                    <td>
                        <a class="view-btn" href="order_details.php?order_id=<?php echo $row['order_id']; ?>">
                            View
                        </a>
                    </td>
                </tr>
            <?php } ?>

        </table>

    <?php } ?>

    <!-- 🔙 Back to Dashboard Button -->
    <a href="home.php" class="back-btn">← Back to Dashboard</a>

</div>

</body>
</html>
