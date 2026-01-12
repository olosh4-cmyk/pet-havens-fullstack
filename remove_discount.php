<?php
session_start();
unset($_SESSION["discount"]);
unset($_SESSION["discount_code"]);
header("Location: cart.php");
exit();
?>
