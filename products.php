<?php
session_start();
include 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Havens | Products</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", Arial, sans-serif;
            background: #fff5f5;
        }

        /* NAVBAR */
        .navbar {
            background: #ff3b3b;
            padding: 15px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 18px rgba(0,0,0,0.25);
            margin-bottom: 30px;
        }

        .navbar img {
            height: 70px;
            object-fit: contain;
        }

        /* PAGE TITLE */
        .page-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .page-title h2 {
            margin: 0;
            font-size: 28px;
            color: #ff3b3b;
        }

        .page-title p {
            margin-top: 5px;
            color: #444;
        }

        /* PRODUCT GRID */
        .products-wrapper {
            max-width: 1100px;
            margin: auto;
            padding: 10px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
        }

        /* PRODUCT CARD */
        .product-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.1);
            padding: 18px;
            text-align: center;
            transition: 0.25s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 14px 30px rgba(255,59,59,0.25);
        }

        .product-img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 12px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #222;
            margin-bottom: 6px;
        }

        .product-category {
            font-size: 13px;
            text-transform: uppercase;
            color: #777;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .product-price {
            font-size: 16px;
            color: #ff3b3b;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-desc {
            font-size: 13px;
            color: #555;
            margin-bottom: 12px;
        }

        .add-btn {
            background: #ff3b3b;
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
        }

        .add-btn:hover {
            background: #e02d2d;
            transform: scale(1.05);
        }

        .back-dashboard {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #ff3b3b;
            font-weight: 600;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <img src="PETHAVENS.png" alt="Pethavens Logo">
</div>

<div class="products-wrapper">

    <div class="page-title">
        <h2>Shop Our Products 🐾</h2>
        <p>Quality items for your pets — curated by Pet Havens.</p>
    </div>

    <div class="products-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="product-card">
            <img class="product-img" src="<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>">

            <div class="product-name"><?php echo $row['product_name']; ?></div>
            <div class="product-category"><?php echo $row['category']; ?></div>
            <div class="product-price">$<?php echo number_format($row['price'], 2); ?></div>
            <div class="product-desc"><?php echo $row['description']; ?></div>

            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                <button type="submit" class="add-btn">Add to Cart</button>
            </form>
        </div>
        <?php } ?>
    </div>

    <a href="home.php" class="back-dashboard">← Back to Dashboard</a>

</div>

</body>
</html>
