<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "pethavens_db";  // ✔ FIXED — must match signup.php

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password_input = trim($_POST['password']);

    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password_input, $hashed_password)) {

            $_SESSION["user_id"] = $id;
            $_SESSION["email"] = $email;

            header("Location: home.php");
            exit();

        } else {
            echo "<h3>Invalid password.</h3>";
        }
    } else {
        echo "<h3>No account found with that email.</h3>";
    }

    $stmt->close();
}

$conn->close();
?>

