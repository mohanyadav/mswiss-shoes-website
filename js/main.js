$(document).ready(function(){

    //Store the overlay, menu, container, menu button
    var overlay = $('.overlay');
    var sideMenu = $('.side-menu');
    var mainContainer = $('.container');
    var menuButton = $('.menu-icon');

    var body = $('body');

    //Login and signup button reference
    var navLoginBtn = $('.login');
    var navSignupBtn = $('.signup');

    //Login and signup button reference
    var loginBtn = $('.login-btn');
    var signupBtn = $('#signup-btn');

    //Reference to navigation login and signup dialog
    var loginDialog = $('.login-wrapper');
    var signupDialog = $('.signup-wrapper');

    //Status Text
    var loginStatusText = $('.login-wrapper p');
    var signupStatusText = $('.signup-wrapper p');

    //when menu is clicked, reveal the menu + fade in the overlay + move the main container
    menuButton.click(function(){
        sideMenu.addClass('active');
        mainContainer.addClass('active');
        body.css('overflow-x', 'hidden');
        overlay.addClass('active');
    });

    //When overlay is clicked revert everything
    overlay.click(function(){
        sideMenu.removeClass('active');
        mainContainer.removeClass('active');
        overlay.removeClass('active');
        loginDialog.removeClass('active');        
        body.css('overflow-y', 'auto');
        signupDialog.removeClass('active');
    });

    //Login button is clicked
    navLoginBtn.click(function(e){
        e.preventDefault();
        overlay.addClass('active');
        loginDialog.addClass('active');
        body.css('overflow-y', 'hidden');
    });

    $('.product-detail-add-to-cart').click(function(e){
        e.preventDefault();
        overlay.addClass('active');
        loginDialog.addClass('active');
        body.css('overflow-y', 'hidden');
    });

    $count = $('.cart-count p').text();

    $('.add-to-cart').click(function(e){
        e.preventDefault();
        $('.add-to-cart').toggleClass('added');
        if ($('.add-to-cart').hasClass('added')) {
            $count++;
            $('.cart-count p').text($count);

            // Add product to database cart

            var data = "product_name=" + $("h4").text();

            $.ajax({
                type: "POST",
                url: "includes/add-to-cart",
                data: data,
                success: function(data)
                {                       
                }
            });
            
        e.preventDefault();
        } else {
            $count--;
            $('.cart-count p').text($count);

            //Remove product from database cart
            var data = "product_name=" + $("h4").text();

            $.ajax({
                type: "POST",
                url: "includes/remove-from-cart",
                data: data,
                success: function(data)
                {                       
                }
            });
            
        e.preventDefault();
        }
        
    });

    $(".remove_product").click(function(e){
        e.preventDefault();
        var productName = $(this).attr('alt');
        
        var data = "product_name=" + productName;

        $.ajax({
            type: "POST",
            url: "includes/remove-from-cart",
            data: data,
            success: function(data)
            {       
                window.location.reload();                
            }
        });
    });

    // Handle change in product quantity
    $(".number_of_products").change(function(e){
        e.preventDefault();
        var productName = $(this).attr('name');
        var quantitySelected = $(this).children('option:selected').val();
        
        var data = "product_name=" + productName + "&product_quantity=" + quantitySelected;

        $.ajax({
            type: "POST",
            url: "includes/functions",
            data: data,
            success: function(data)
            {       
                window.location.reload();                
            }
        });
    });

    navSignupBtn.click(function(e){
        e.preventDefault();
        overlay.addClass('active');
        signupDialog.addClass('active');
        body.css('overflow-y', 'hidden');
    });

    $("#signup-form").submit(function(e) {
        var name = $('#signup-name').val();
        var email = $('#signup-email').val();
        var password = $('#signup-password').val();
        var address = $('#signup-address').val();

        var data = "name=" + name + "&email=" + email + "&password=" + password + "&address="+ address;

        $.ajax({
               type: "POST",
               url: "includes/signup",
               data: data,
               success: function(data)
               {
                   if(data == "products.php")
                   {
                        window.location.href = data;
                   } else {
                       signupStatusText.html(data);
                   }
                }
             });
    
        e.preventDefault();
    });

    $("#login-form").submit(function(e) {
        var email = $('#login-email').val();
        var password = $('#login-password').val();

        var data = "email=" + email + "&password=" + password;

        $.ajax({
               type: "POST",
               url: "includes/login",
               data: data,
               success: function(data)
               {
                   if(data == "products.php")
                   {
                        window.location.href = data;
                   } else {
                       loginStatusText.html(data);
                   }
                }
             });
    
        e.preventDefault();
    });

    // Submit Shipping info
    $('#address-form').submit(function(e){

        var address = $('#shipping-address').val();
        var city = $('#shipping-city').val();
        var state = $('#shipping-state').val();
        var landmark = $('#shipping-landmark').val();
        var pincode = $('#shipping-pincode').val();

        var data = "address=" + address + "&city=" + city + "&state=" + state + "&landmark=" + landmark + "&pincode=" + pincode;

        alert(data);

        $.ajax({
            type: "POST",
            url: "includes/functions",
            data: data,
            success: function(data)
            {
                alert(data);
                if(data == "products.php")
                {
                     window.location.href = data;
                } else {
                    loginStatusText.html(data);
                }
             }
          });

        e.preventDefault();
    });

});