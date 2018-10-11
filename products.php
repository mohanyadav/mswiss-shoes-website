<?php 

session_start();
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
                        if (isset($_SESSION['user_logged'])) {
                            if ($_SESSION['user_logged'] == "true") {
                                echo '<a href="includes/logout.php" class="user-logout">Logout</a>';
                            }
                        }else {
                            echo '<a href="#" class="login">Login</a>
                            <a href="#" class="signup">Signup</a>';
                        }
                    ?>
                </div>
                <div class="menu-cart">
                    <div class="cart-count">
                        <p>0</p>
                    </div>
                    <p>Cart</p>
                </div>
            </div>
        </nav>

        <div class="products-container">
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
            <div class="clearfix"></div>

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