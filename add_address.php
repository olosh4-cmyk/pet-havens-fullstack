<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$full_name = $_POST["full_name"];
$address = $_POST["address"];
$phone = $_POST["phone"];

$sql = "INSERT INTO saved_addresses (user_id, full_name, address, phone)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $full_name, $address, $phone);
$stmt->execute();

header("Location: saved_addresses.php?added=1");
exit();
?>
