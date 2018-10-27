<?php 

session_start();

include_once('includes/config.php');

$getProducts = $db_conn -> prepare("SELECT * FROM products");
$getProducts -> execute();

$products = $getProducts -> fetchAll();

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
    <title>MSwiss | Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />

    <!-- Products CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/products.css" />

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
                <a href="cart.php">
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

        <div class="products-container">
            <?php 
                $rows = $getProducts -> rowCount();
                    // $count = 0;
                    if ($rows > 0) {
                        for ($i=0; $i < $rows; $i++) {
                            // if ($i % 3 == 2 || $i == 0) {
                            //     echo '<div class="products-row">';
                            //     $count = $i;
                            //     // echo 'i starting ' . $i . '<br>';
                            // }
                            
                            // $product_url = strtolower(Str_replace(' ', '-', $products[$i]['product_name']));
                            
                            echo '
                            <a href="product-detail.php?' . $products[$i]['product_url'] . '" class="product-card">
                                <img src="' . $products[$i]['product_image_1'] . '" alt="'. $products[$i]['product_name'] . '" />
                                <div class="product-title">
                                    <h4>' . $products[$i]['product_name'] . '</h4>
                                    <p>$' . $products[$i]['product_price'] . '</p>
                                </div>
                            </a>';
    
                            // if ($i % 3 == 1 && $i != 0) {
                            //     // echo 'i ending ' . $i . '<br>';
                            //     echo '</div>
                            //     <div class="clearfix"></div>';
                            // }
                        }
                    }
    
            ?>
            <!-- <div class="products-row">
                <a href="images/home_hero1.jpg" class="product-card">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                    <div class="product-title">
                        <h4>Nike VaporMax</h4>
                        <p>$200</p>
                    </div>
                </a>
                <a href="images/home_hero1.jpg" class="product-card">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                    <div class="product-title">
                        <h4>Nike VaporMax</h4>
                        <p>$200</p>
                    </div>
                </a>
                <a href="images/home_hero1.jpg" class="product-card">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                    <div class="product-title">
                        <h4>Nike VaporMax</h4>
                        <p>$200</p>
                    </div>
                </a>
            </div>

            <div class="clearfix"></div>
            <div class="products-row">
                <a href="images/home_hero1.jpg" class="product-card">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                    <div class="product-title">
                        <h4>Nike VaporMax</h4>
                        <p>$200</p>
                    </div>
                </a>
                <a href="images/home_hero1.jpg" class="product-card">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                    <div class="product-title">
                        <h4>Nike VaporMax</h4>
                        <p>$200</p>
                    </div>
                </a>
                <a href="images/home_hero1.jpg" class="product-card">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                    <div class="product-title">
                        <h4>Nike VaporMax</h4>
                        <p>$200</p>
                    </div>
                </a>
            </div>
            <div class="clearfix"></div> -->

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