<?php

include ('config.php');
session_start();

$product_name = $_POST['product_name'];

$stmtProduct = $db_conn->prepare("SELECT * FROM products WHERE product_name LIKE :product_name");
$stmtProduct->bindParam(':product_name', $product_name);
$stmtProduct->execute();

$product_row = $stmtProduct->fetch(PDO::FETCH_ASSOC);

print_r($product_row);
if ($product_row > 0) {
    # product exists 
    $arr = explode("@", $_SESSION['email'], 2); 
    $cartName = $arr[0] . '_cart';

    $stmtCartCheck = $db_conn -> prepare("SELECT * FROM $cartName WHERE product_name = :product_name");
    $stmtCartCheck -> bindParam(':product_name', $product_name);
    $stmtCartCheck -> execute();

    $cart_row = $stmtCartCheck -> fetch(PDO::FETCH_ASSOC);

    if ($cart_row > 0) {
        # if product is already added to cart
        # remove product and update cart
        $stmtDelete = $db_conn -> prepare("DELETE FROM $cartName WHERE product_name = :product_name");
        $stmtDelete -> bindParam(':product_name', $product_name);
        $stmtDelete -> execute();

    } else {
        # product doesn't exist in user cart

    }
}
?>