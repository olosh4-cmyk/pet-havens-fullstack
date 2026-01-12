<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch total spent
$spent_sql = "SELECT SUM(total_amount) AS total_spent FROM orders WHERE user_id = ?";
$stmt1 = $conn->prepare($spent_sql);
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$spent_result = $stmt1->get_result()->fetch_assoc();
$total_spent = $spent_result["total_spent"] ?? 0;

// Fetch order count
$count_sql = "SELECT COUNT(*) AS order_count FROM orders WHERE user_id = ?";
$stmt2 = $conn->prepare($count_sql);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$count_result = $stmt2->get_result()->fetch_assoc();
$order_count = $count_result["order_count"] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pethavens | Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: white;
        }

        /* NAVBAR */
        .navbar {
            background: #ff3b3b;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 5px 18px rgba(0,0,0,0.25);
        }

        .navbar img {
            height: 70px;
        }

        /* BANNER CENTERED */
        .banner {
            width: 100%;
            height: 260px;
            background: white;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            position: relative;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner-overlay {
            color: #ff3b3b;
            font-size: 40px;
            font-weight: bold;
            text-shadow: 0 3px 6px rgba(0,0,0,0.25);
        }

        /* SEARCH BAR */
        .search-container {
            max-width: 700px;
            margin: 25px auto;
            text-align: center;
        }

        .search-input {
            width: 100%;
            padding: 14px;
            border: 2px solid #ff3b3b;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        .search-btn {
            margin-top: 10px;
            background: #ff3b3b;
            padding: 12px 22px;
            border: none;
            color: white;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
        }

        .search-btn:hover {
            background: #e02d2d;
        }

        .search-results {
            width: 100%;
            display: none;
            background: white;
            margin-top: 10px;
            border-radius: 10px;
            box-shadow: 0px 6px 18px rgba(0,0,0,0.15);
            padding: 10px;
        }

        /* STATS BAR */
        .stats-bar {
            text-align: center;
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500;
            color: #444;
        }

        /* MENU GRID */
        .dashboard-wrapper {
            max-width: 1100px;
            margin: 30px auto;
            padding: 10px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 30px;
        }

        .menu-box {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            transition: 0.2s ease;
            cursor: pointer;
            text-align: center;
        }

        .menu-box:hover {
            transform: scale(1.04);
            box-shadow: 0 12px 30px rgba(255, 59, 59, 0.25);
        }

        .menu-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .menu-box h3 {
            color: #ff3b3b;
        }

        .logout-btn {
            display: block;
            background: #ff3b3b;
            padding: 13px 22px;
            border-radius: 12px;
            color: white;
            text-align: center;
            font-weight: bold;
            width: 200px;
            margin: 40px auto;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #e02d2d;
        }
    </style>
</head>
<body>

<div class="navbar">
    <img src="PETHAVENS.png">
</div>

<div class="banner">
    <div class="banner-overlay">Start Shopping!</div>
</div>

<!-- SEARCH BAR -->
<div class="search-container">
    <form action="search.php" method="GET">
        <input type="text" class="search-input" name="query" placeholder="Search for products..." onkeyup="liveSearch(this.value)">
        <button class="search-btn" type="submit">Search</button>
    </form>
    <div id="search-results" class="search-results"></div>
</div>

<!-- STATS BAR -->
<div class="stats-bar">
    You’ve placed <strong><?php echo $order_count; ?></strong> orders • 
    Total spent: <strong>$<?php echo number_format($total_spent, 2); ?></strong>
</div>

<div class="dashboard-wrapper">
    <div class="menu-grid">

        <a href="products.php" style="text-decoration:none;">
            <div class="menu-box">
                <img class="menu-img" src="PETHAVENS-4.png">
                <h3>View Products</h3>
            </div>
        </a>

        <a href="cart.php" style="text-decoration:none;">
            <div class="menu-box">
                <img class="menu-img" src="PETHAVENS-2.png">
                <h3>My Cart</h3>
            </div>
        </a>

        <a href="orders.php" style="text-decoration:none;">
            <div class="menu-box">
                <img class="menu-img" src="PETHAVENS-5.png">
                <h3>My Orders</h3>
            </div>
        </a>

        <a href="profile.php" style="text-decoration:none;">
            <div class="menu-box">
                <img class="menu-img" src="PETHAVENS-3.png">
                <h3>Profile Settings</h3>
            </div>
        </a>

    </div>

    <a class="logout-btn" href="logout.php">Logout</a>
</div>

<script>
function liveSearch(query) {
    const resultsBox = document.getElementById("search-results");

    if (query.length < 2) {
        resultsBox.style.display = "none";
        resultsBox.innerHTML = "";
        return;
    }

    fetch("search.php?ajax=1&query=" + encodeURIComponent(query))
        .then(res => res.text())
        .then(data => {
            resultsBox.style.display = "block";
            resultsBox.innerHTML = data;
        });
}
</script>

</body>
</html>
