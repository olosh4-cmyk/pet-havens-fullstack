<?php
session_start();

$valid_codes = [
    "PET10" => 0.10,
    "PET20" => 0.20,
    "FREESHIP" => 0.15
];

$code = strtoupper(trim($_POST["discount_code"]));

if (isset($valid_codes[$code])) {
    $_SESSION["discount"] = $valid_codes[$code];
    $_SESSION["discount_code"] = $code;
    header("Location: cart.php?success=1");
} else {
    $_SESSION["discount"] = 0;
    header("Location: cart.php?error=1");
}

exit();
?>
