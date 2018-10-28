<?php
session_start();

include_once('includes/config.php');
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$product_name_url = substr($url, strpos($url, '?') + 1);

if (!empty($product_name_url)) {
    
    $getProduct = $db_conn -> prepare("SELECT * FROM products WHERE product_url = '$product_name_url'");
    $getProduct -> execute();
    $product = $getProduct -> fetch(PDO::FETCH_ASSOC);

    $product_id_next = $product['product_id'] + 1;
    $product_id_prev = $product['product_id'] - 1;

    $nextProduct = $db_conn -> prepare("SELECT product_url FROM products WHERE product_id = '$product_id_next'");
    $nextProduct -> execute();
    $next_product = $nextProduct -> fetch();

    $prevProduct = $db_conn -> prepare("SELECT product_url FROM products WHERE product_id = '$product_id_prev'");
    $prevProduct -> execute();
    $prev_product = $prevProduct -> fetch();

    $rows = $getProduct -> rowCount();
    if ($rows > 0) {
        # Product exists
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

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

$totalCartProducts = 0;

if (isset($_SESSION['email'])) {
    // Check if product is in user cart
    $arr = explode("@", $_SESSION['email'], 2); 
    $cartName = $arr[0] . '_cart';

    $productInCartID = $product['product_id'];
    $checkCart = $db_conn -> prepare("SELECT * FROM $cartName WHERE product_id = $productInCartID");

    $checkCart -> execute();
    $checkCartProduct = $checkCart -> fetch(PDO::FETCH_ASSOC);

    $allUserCartProductss = $db_conn -> prepare("SELECT * FROM $cartName");
    $allUserCartProductss -> execute();

    $totalCartProducts = $allUserCartProductss -> rowCount();
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MSwiss | <?php echo $product['product_name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="images/icons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/icons/favicon-128.png" sizes="128x128" />
    
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />

    <!-- Products CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/products.css" />

    <!-- Product Detail CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/product-detail.css" />

    <!-- Anonymous Pro Font CDN -->
    <link href="https://fonts.googleapis.com/css?family=Anonymous+Pro" rel="stylesheet">

    <!-- Owl Carousel CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    
    <!-- Owl Carousel Theme CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

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
            <a href="products.php" class="active-link">
                Shop
            </a>
        </li>
        <li>
            <a href="index.php">
                About
            </a>
        </li>
        <li>
            <a href="cart.php">
                Cart
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
                        <p><?php echo $totalCartProducts; ?></p>
                    </div>
                    <p>
                        <?php

                        if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
                            echo '<a href="cart.php">Cart</a>';
                        } else {
                            echo 'Cart';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </nav>

        <div class="product-container">
            <div class="owl-carousel">
                <div class="product-image item">
                    <img src="<?php echo $product['product_image_1']; ?>" alt="Product 1" />
                </div>
                <div class="product-image item">
                    <img src="<?php echo $product['product_image_2']; ?>" alt="Product 1" />
                </div>
                <div class="product-image item">
                    <img src="<?php echo $product['product_image_3']; ?>" alt="Product 1" />
                </div>
            </div>

            <div class="product-title">
                <h4><?php echo $product['product_name']; ?></h4>
                <p>$<?php echo $product['product_price']; ?></p>
            </div>

            <div class="product-description">
                <div class="product-description-wrapper">
                    <p><?php echo $product['product_description']; ?></p>
                    <?php
                    if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
                        if ($email == $_server_email && $token == $_server_token && $checkCartProduct > 0)
                        {
                            // Show remove from cart button
                            echo '
                            <a class="add-to-cart added"><span></span></a>
                            ';
                        } else {

                            // Show add to cart button 
                            echo '
                            <a class="add-to-cart"><span></span></a>
                            ';
                        }          
                    } else {
                        // Show add to cart button which redirects to login
                        echo '<button class="product-detail-add-to-cart"><span>+</span>Add to cart</button>';
                    }
                    ?>
                </div>
            </div>

            <div class="product-switch">
                <?php
                    if ($prev_product > 0) {
                        echo '<a href="product-detail.php?' . $prev_product['product_url'] . '">
                        <img class="previous-button" src="images/icons/icon_previous.png" alt="Previous Product">
                        </a>';
                    }

                    if ($next_product > 0) {
                        echo '<a href="product-detail.php?' . $next_product['product_url'] . '">
                        <img class="next-button" src="images/icons/icon_next.png" alt="Next Product">
                        </a>';
                    }
                ?>
                
            </div>

            <div class="clearfix"></div>

        </div>
    </div>


    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Owl Carousel Thumbs JS -->
    <script src="js/owl.carousel2.thumbs.js"></script>

    <!-- Custom JS -->
    <script src="js/product-detail.js"></script>

    <!-- Custom JS -->
    <script src="js/main.js"></script>
</body>
</html>