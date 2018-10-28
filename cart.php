<?php 

session_start();

include_once('includes/config.php');


#Auth Section
if (isset($_SESSION['email']) && isset($_SESSION['token'])) {

    #Store retrieved session values
    $email = $_SESSION['email'];
    $token = $_SESSION['token'];

    # if email and token is set check them against the database, retrieve and store the email and token retrieved for comparison

    $sql = "SELECT user_email, user_token from users WHERE user_email = '$email'";
    $retrieveStmt = $db_conn -> prepare($sql);
    $retrieveStmt -> execute();

    $user_row = $retrieveStmt -> fetch(PDO::FETCH_ASSOC);

    if ($user_row > 0) {
        # store values to be compared
        $_server_email = $user_row['user_email'];
        $_server_token = $user_row['user_token'];
    }

}

if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
    if ($email == $_server_email && $token == $_server_token)
    {
        $arr = explode("@", $_SESSION['email'], 2); 
        $cartName = $arr[0] . '_cart';

        $getCartProducts = $db_conn -> prepare("SELECT * FROM $cartName");
        $getCartProducts -> execute();

        $cartProducts = $getCartProducts -> fetchAll();
    }
} else {
    header('Location: index.php');
}


$totalCartProducts = 0;

if (isset($_SESSION['email'])) {
    // Check if product is in user cart
    $arr = explode("@", $_SESSION['email'], 2); 
    $cartName = $arr[0] . '_cart';

    $allUserCartProducts = $db_conn -> prepare("SELECT * FROM $cartName");
    $allUserCartProducts -> execute();

    $totalCartProducts = $allUserCartProducts -> rowCount();

    #Total Quantity of products
    $stmtTotalProductQuantity = $db_conn -> prepare("SELECT SUM(product_quantity) FROM $cartName");
    $stmtTotalProductQuantity -> execute();

    $stmtTotalProductQuantityRow = $stmtTotalProductQuantity -> fetch(PDO::FETCH_NUM);

    $totalProducts = $stmtTotalProductQuantityRow[0];

    #Total Price of Products
    $totalPriceProducts = $db_conn -> prepare("SELECT SUM(product_total) FROM $cartName");

    $totalPriceProducts -> execute();

    $totalPriceRow = $totalPriceProducts -> fetch(PDO::FETCH_NUM);

    $totalPrice = $totalPriceRow[0];


    # Get all products added to cart
    $allCartProducts = $db_conn -> prepare("SELECT * FROM $cartName");
    $allCartProducts -> execute();

    $allCartProductsRow = $allCartProducts -> fetchAll();

}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Cart | MSwiss</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="images/icons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/icons/favicon-128.png" sizes="128x128" />

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />

    <!-- Products CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/products.css" />

    <!-- Roboto font CDN -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

</head>
<body>

    <div class="side-menu">
        <ul>
            <li>
                <a href="index.php">
                    Home
                </a>
            </li>
            <li>
                <a href="products.php">
                    Shop
                </a>
            </li>
            <li>
                <a href="cart.php" class="active-link">
                    Cart
                </a>
            </li>
            <li>
                <a href="index.php">
                    About
                </a>
            </li>
            <li>
                <a href="index.php">
                    Contact
                </a>
            </li>  
        </ul>

        <a href="#" class="disclaimer">Privacy Policy</a>
        <a href="#" class="disclaimer">Disclaimer</a>
    </div>

    <div class="clearfix"></div>

    <div class="overlay">

    </div>

    <div class="clearfix"></div>
    
    <div class="login-wrapper">
        <h3>Login</h3>
        <form  id="login-form">
            <input type="email" id="login-email" name="login-email" placeholder="Email Address" required/>
            <input type="password" id="login-password" name="login-password" placeholder="Password" required/>
            <p></p>
            <input id="login-btn" type="submit" value="Log in" />
        </form>
    </div>

    <div class="signup-wrapper">
        <h3>Sign up</h3>
        <form id="signup-form">
            <input type="text" id="signup-name" placeholder="Name*" required/>
            <input type="email" id="signup-email" placeholder="Email Address*" required/>
            <input type="password" id="signup-password" placeholder="Password*" required/>
            <input type="text" id="signup-address" placeholder="Address*" required/>
            <p></p>
            <input id="signup-btn" type="submit" value="Sign up" />
        </form>
    </div>

    <div class="container">

        <nav>
            <div class="menu-container">
                <div class="menu-icon">
                    <span class="menu-aria"></span>
                    <span class="menu-aria"></span>
                    <span class="menu-aria"></span>
                    <div class="menu-text">
                        <p>Menu</p>
                    </div>
                </div>
                <div class="menu-login-signup">
                    <?php
                    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
                        if ($email == $_server_email && $token == $_server_token)
                        {
                            echo '<a href="includes/logout.php" class="user-logout">Logout</a>';
                        }
                    } else {
                        echo '<a href="#" class="login">Login</a>
                        <a href="#" class="signup">Signup</a>';
                    }
                    ?>
                </div>
                <div class="menu-cart">
                    <div class="cart-count">
                        <p>
                            <?php echo $totalCartProducts; ?>
                        </p>
                    </div>
                    <p>Cart</p>
                </div>
            </div>
        </nav>

        <div class="products-container">
            <div class="cart-wrapper">
                <h2>Cart <?php echo '(' . $totalCartProducts . ')'; ?></h2>
                <div class="cart-products">
                    <?php
                        $cartProductsCount = $allCartProducts ->  rowCount();

                        for ($i=0; $i < $cartProductsCount; $i++) { 
                            $cartProductQuantitySelected = '';

                            for ($j=1; $j <= 4; $j++) { 
                                # Loop through all the quantity of the cart product
                                if ($allCartProductsRow[$i]['product_quantity'] == $j) {
                                    # Print normal select option
                                    $cartProductQuantitySelected .= '
                                    <option selected="selected" value="' . $j . '">' . $j . '</option>
                                    ';
                                } else {
                                    # Print normal select option
                                    $cartProductQuantitySelected .= '
                                    <option value="' . $j . '">' . $j . '</option>
                                    ';
                                }
                            }

                            # Display the products
                            echo '
                            <div class="product">
                                <div class="product-image-wrapper">
                                    <img src="' . $allCartProductsRow[$i]['product_image'] . '" alt="' . $allCartProductsRow[$i]['product_name'] . '">
                                </div>
                                <div class="product-content-wrapper">
                                    <div class="content">
                                        <h4>' . $allCartProductsRow[$i]['product_name'] . '</h4>
                                        <p>$' . $allCartProductsRow[$i]['product_price'] . '</p>
                                        <select name="' . $allCartProductsRow[$i]['product_name'] . '" class="number_of_products">
                                        ' . $cartProductQuantitySelected . '
                                        </select>
                                        <img src="images/icons/icon_close.png" alt="' . $allCartProductsRow[$i]['product_name'] . '" class="remove_product">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            ';
                        }
                    ?>
                </div>
            </div>
            <div class="checkout-wrapper">
                <p>Total Items: <span><?php echo $totalProducts; ?></span></p>
                <p>Products Price: 
                    <span>
                        <?php 
                            $totalPrice = number_format((float)$totalPrice, 2, '.', '');
                            echo '$'.$totalPrice;
                        ?>
                    </span>
                </p>
                <p>GST (18%): 
                    <span>
                    <?php 
                        $gst = $totalPrice * 18 / 100;
                        $gst = number_format((float)$gst, 2, '.', '');
                        echo '$'.$gst; 
                    ?>
                    </span>
                </p>
                <p>Rounded Price: 
                    <span>
                    <?php 
                        $priceDiff = $totalPrice + $gst - round($totalPrice + $gst);

                        $priceDiff = number_format((float)$priceDiff, 2, '.', '');
                        echo '$'.$priceDiff; 
                    ?>
                    </span>
                </p>
                <div class="spacer"></div>
                <p>Total Price: </p>
                <p class="total-price">
                    <span>
                        <?php 
                            $totalPriceAfterGST = $totalPrice + $gst - $priceDiff;

                            $totalPriceAfterGST = number_format((float)$totalPriceAfterGST, 2, '.', '');
                            echo '<sup>$ </sup>'.$totalPriceAfterGST; 
                        ?>
                    </span>
                </p>
                <?php
                    if ($totalCartProducts > 0) {
                        # Show Checkout button only if user cart has product
                        echo '
                            <a href="shipping.php" class="checkout-button">         Checkout
                            </a>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="js/main.js"></script>
</body>
</html>