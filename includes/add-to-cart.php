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
        # if true product is already added to cart
        echo "product exists in cart";
    } else {
        # add product to cart
        echo "not exist";
        $stmtAdd = $db_conn -> prepare("INSERT INTO $cartName (product_id, product_name, product_price, product_image, product_quantity, product_total) VALUES (:product_id, :product_name, :product_price, :product_image, :product_quantity, :product_total);");

        $quantity = '1';
        $stmtAdd -> bindParam(':product_id', $product_row['product_id']);
        $stmtAdd -> bindParam(':product_name', $product_row['product_name']);
        $stmtAdd -> bindParam(':product_price', $product_row['product_price']);
        $stmtAdd -> bindParam(':product_image', $product_row['product_image_1']);
        $stmtAdd -> bindParam(':product_quantity', $quantity);
        $stmtAdd -> bindParam(':product_total', $product_row['product_price']);
        
        $stmtAdd -> execute();

    }
}
?>