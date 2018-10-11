<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MSwiss | Product Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

        <div class="product-container">
            <div class="owl-carousel">
                <div class="product-image item">
                    <img src="images/product_images/product1.png" alt="Product 1" />
                </div>
                <div class="product-image item">
                    <img src="images/product_images/product2.png" alt="Product 1" />
                </div>
                <div class="product-image item">
                    <img src="images/product_images/product3.png" alt="Product 1" />
                </div>
            </div>

            <div class="product-title">
                <h4>Nike VaporMax</h4>
                <p>$200</p>
            </div>

            <div class="product-description">
                <div class="product-description-wrapper">
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Harum qui adipisci a quae? Quibusdam at est laudantium voluptas quasi. Architecto eos laudantium quidem impedit tempora illum. Nemo iusto magnam dolore.</p>
                    <button class="product-detail-add-to-cart"><span>+</span>Add to cart</button>
                </div>
            </div>

            <div class="product-switch">
                <img class="previous-button" src="images/icons/icon_previous.png" alt="Previous Product">
                <img class="next-button" src="images/icons/icon_next.png" alt="Next Product">
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