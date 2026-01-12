<?php
include 'db.php';

// Accept both ?q= and ?query=
$query = "";

if (isset($_GET["query"])) {
    $query = trim($_GET["query"]);
} elseif (isset($_GET["q"])) {
    $query = trim($_GET["q"]);
}

// AJAX live search
$is_ajax = isset($_GET["ajax"]);

// If empty query on AJAX → return nothing
if ($is_ajax && $query == "") {
    exit("");
}

// If empty query (normal search page) → show nothing
if (!$is_ajax && $query == "") {
    echo "<h2>Please enter a search term.</h2>";
    exit();
}

// Search products in database
$sql = "SELECT * FROM products WHERE product_name LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%".$query."%";
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();


// AJAX RESPONSE
if ($is_ajax) {
    if ($result->num_rows == 0) {
        echo "<p style='padding:8px;'>No results found.</p>";
        exit();
    }

    while ($row = $result->fetch_assoc()) {
        echo "<div style='padding:10px; border-bottom:1px solid #eee;'>
                <a href='products.php' style='text-decoration:none; color:#333;'>
                    ".$row['product_name']." - $".$row['price']."
                </a>
              </div>";
    }
    exit();
}


// NORMAL SEARCH PAGE OUTPUT (if you ever build this page)
echo "<h2>Search results for: <em>$query</em></h2>";

if ($result->num_rows == 0) {
    echo "<p>No products found.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo "<p>".$row['product_name']." - $".$row['price']."</p>";
    }
}
?>
