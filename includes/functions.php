<?php

require ('config.php');
session_start();


if (isset($_POST['product_name']) && isset($_POST['product_quantity'])) {
    # if product name and quantity is set then call function cartQuantityUpdate
    $product_name = $_POST['product_name'];
    $product_quantity = $_POST['product_quantity'];

    cartQuantityUpdate($product_name, $product_quantity, $db_conn);
}

if (isset($_POST['address'])
    && isset($_POST['city'])
    && isset($_POST['state'])
    && isset($_POST['landmark'])
    && isset($_POST['pincode'])) {

        
}


# Functions

function cartQuantityUpdate($product_name, $product_quantity, $db_conn) {
    # Get the user cart name
    $arr = explode("@", $_SESSION['email'], 2); 
    $cartName = $arr[0] . '_cart';

    # Query the DB only if the product quantity is <= 4
    if ($product_quantity <= 4) {
        # Update total price of product
        $stmtSelectProduct = $db_conn -> prepare("SELECT product_price FROM $cartName WHERE product_name = '$product_name'");
        $stmtSelectProduct -> execute();

        $stmtSelectProductRow = $stmtSelectProduct -> fetch(PDO::FETCH_ASSOC);

        $totalPriceOfProduct = $stmtSelectProductRow['product_price'] * $product_quantity;

        # Update the product's quantity
        $stmtProductQuantity = $db_conn -> prepare("UPDATE $cartName SET product_quantity = '$product_quantity', product_total = '$totalPriceOfProduct' WHERE product_name = '$product_name'");
        $stmtProductQuantity->execute();

        $productQuantityRow = $stmtProductQuantity -> rowCount();
        if ($productQuantityRow > 0) {
            echo 'Success';
        } else {
            echo 'Failed';
        }
    } else {
        echo 'Failed to update!';
    }
    
}


?>