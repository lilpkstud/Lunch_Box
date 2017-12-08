<?php
    require('../connection.php');
    
    if(isset($_SESSION['shopping_cart'])){
        /*
            $_SESSION['total_quantity'] will keep track of the user's quantity of ALL products

            $_SESSION['grand_total'] will keep track of the entire amount the user will need to pay for all products
        */
        $_SESSION['total_quantity'] = 0;
        $_SESSION['grand_total'] = 0;
        foreach($_SESSION['shopping_cart'] as $shopping_key => $shopping_item):
            $_SESSION['total_quantity'] += $shopping_item['user_quantity'];
        endforeach;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lunch Box Socks</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
    <!-- Bootstrap JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 

    <!-- Navigation CSS -->
    <link rel="stylesheet" type="text/css" href="/css/actual_navigation.css">

    <!-- Actual Navigation JS -->
    <script src="/js/navigation.js"></script>
</head>
<body>
     <nav class="nav navbar fixed-top">
        <div class="col">
            <!-- Use any element to open the sidenav -->
            <span onclick="openNav()">
                <i id="bars" class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </span>
        </div>
        <div class="col">
            <h1 style="text-align: center; color: sandybrown"> Lunch Box Socks </h1>
        </div>
        <div class="col">
            <a id="cart_logo" href="/views/checkout/shopping_cart.php">
                <i id="i_shopping_logo"class="fa fa-shopping-cart fa-2x" aria-hidden="true">(<?=$_SESSION['total_quantity']?>)</i>
            </a>
        </div>       
    
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="/">HOME</a>
            <a id="product_logo_tag" href="/"><img id="product_logo" src="/img/jordan.jpg" alt=""></a>
            <a href="#">ABOUT</a>
            <a href="#">FAQ</a>
            <a href="/views/checkout/shopping_cart.php"> Shopping Cart </a>
        </div>
    </nav>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="content">
        <div class="container">
            <?php 
                if(empty($_SESSION['shopping_cart'])){
                    echo "<h2> Shopping Cart is Empty. </h2>";
                } else {
                    echo "<h2> Shopping Cart Items </h2>";
                    foreach($_SESSION['shopping_cart'] as $shopping_id=>$shopping_item):
                        /*
                            $total_price will calculate each product by the user's quantity
                        */
                        $total_price = $shopping_item['user_quantity'] * $shopping_item['product_price'];
                        
                        $_SESSION['grand_total'] += $total_price;

                        echo "<h4>".$shopping_item['product_name']."</h4>
                                <p>$".$shopping_item['product_price']."</p> 
                                <p>".$shopping_item['product_color']."</p>
                                <p>$".$shopping_item['product_price']." x ".$shopping_item['user_quantity']." = $".$total_price."

                                <p> Quantity: ".$shopping_item['user_quantity']."</p>
                                <form action='../controllers/cart_controller.php' method='post'>
                                    <input type='hidden' name='edit_quantity' value='yes'>
                                    <input type='hidden' name='edit_id' value=".$shopping_id.">
                                    <input type='number' name='new_user_quantity' min='1' max='15' value=".$shopping_item['user_quantity'].">
                                    <input type='submit' value = 'Edit Quantity'>
                                </form>
                                <form action='../controllers/cart_controller.php' method='post'>
                                    <input type='hidden' name='remove_id' value=".$shopping_id.">
                                    <input type='submit' value = 'Remove Item'>
                                </form>";
                    endforeach;
                    echo "<p><strong>Grand Total = $".$_SESSION['grand_total']."</strong></p>";
                    
                }
                    
                /*
                    Checking if the user is signed in. Users that are logged in will be directed to SHIPPING.PHP to verify that their information is up to date.
                */
                if(isset($_SESSION['user'])){
            ?>
                <a href="../controllers/checkout_controller.php"> Check Out Now</a>
            <?php        
                } else {
                    /*
                        Have the user login 
                    */
            ?>
                <a href="../controllers/checkout_controller.php"> Check Out Now </a>
            <?php
                }
            ?>
        </div> <!-- Container div -->
    </div> <!-- Content div -->
    <footer class="footer">
        <div class="container">
            <h3 id="contact_text">Connect With Us</h3>

            <a class="icon_links" href="mailto:lotsofyellowww@gmail.com"> 
                <i class="fa fa-envelope-o" aria-hidden="true"> Email </i>  
            </a>
            <a class="icon_links" href="https://www.facebook.com/Lots-of-Yellow-1116666705131888/">
                <i class="fa fa-facebook-official" aria-hidden="true"> Facebook </i>
            </a>
            <a class="icon_links" href="https://www.instagram.com/lotsofyellowww/">
                <i class="fa fa-instagram" aria-hidden="true"> Instagram </i>
            </a>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>