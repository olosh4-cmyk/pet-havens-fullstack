<?php
session_start();
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

header("Location: cart.php");
exit();
?>
         