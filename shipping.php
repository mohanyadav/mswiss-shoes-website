<?php 

session_start();

include_once('includes/config.php');

#Check if the user has items in cart and is logged in
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

    if ($email == $_server_email && $token == $_server_token)
    {
        $arr = explode("@", $_SESSION['email'], 2); 
        $cartName = $arr[0] . '_cart';

        $getCartProducts = $db_conn -> prepare("SELECT * FROM $cartName");
        $getCartProducts -> execute();

        $cartProducts = $getCartProducts -> fetchAll();
        $totalCartProducts = $getCartProducts -> rowCount();
    }

    if ($totalCartProducts > 0 ) {
        
    } else {
        header('Location: products');
    }

} else {
    header('Location: index');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shipping | MSwiss</title>
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
            <div class="address-wrapper">
                <h2>Shipping Address</h2>
                <p class="status">Fill City</p>
                <form id="address-form">
                    <input type="text" placeholder="Address" id="shipping-address" required>
                    <input type="text" placeholder="City" id="shipping-city" class="address_half_input margin-right" required>
                    <input type="text" placeholder="State" id="shipping-state" class="address_half_input" required>
                    <input type="text" placeholder="Landmark" id="shipping-landmark" class="address_half_input margin-right" required>
                    <input type="text" placeholder="Pincode" id="shipping-pincode" class="address_half_input" required>
                    <input type="submit" value="Go to Payment">
                </form>
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