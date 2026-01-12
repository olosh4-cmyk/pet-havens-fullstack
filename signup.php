<?php
// Database connection settings (for MAMP)
$servername = "localhost";
$username = "root"; // default MAMP username
$password = "root"; // default MAMP password
$dbname = "pethavens_db"; // the database you created in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $user = htmlspecialchars(trim($_POST["username"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $pass = trim($_POST["password"]);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red; text-align:center;'>Invalid email format.</p>";
        exit;
    }

    // Check if email or username already exists
    $checkUser = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $checkUser->bind_param("ss", $email, $user);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color:red; text-align:center;'>Email or Username already exists. Please try again.</p>";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>Account created successfully! You can now <a href='login.html'>login</a>.</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>




