<?php

include_once('includes/config.php');

session_start();

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

# Get the total number of products in user cart
if (isset($_SESSION['email'])) {
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
    <title>MSwiss | Home</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="images/icons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="images/icons/favicon-128.png" sizes="128x128" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>

    <div class="side-menu">
        <ul>
            <li>
                <a href="index.php" class="active-link">
                    Home
                </a>
            </li>
            <li>
                <a href="products.php">
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

        <a class="home-shop-button" href="products.php">Shop Now</a>
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