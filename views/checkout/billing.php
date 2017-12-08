<?php 
    require('../connection.php');

    /*
        User has signed in as a guest. SAVE the guest's shipping information so we can push it into the db IF they want to.
    */
    /*if($_SESSION['guest'] === "yes")
    {
        echo "User is signed in as a guest";
        $_SESSION['guest'] = $_POST;
        var_dump($_SESSION['guest']);
        
    }*/
    /*else {
        // User has signed in. Preload their billing info for [FUTURE USE!!!]
    }
    */

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
    
    <!-- Navigation CSS -->
    <link rel="stylesheet" type="text/css" href="/css/navigation.css">
    
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 
    
    <!-- Actual Navigation CSS -->
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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Shipping Address</li>
                    <li class="breadcrumb-item active" aria-current="page">Billing</a></li>
                    <li class="breadcrumb-item">Review</a></li>
                </ol>
            </nav>  
            <h3>Choose A Payment Method </h3>
            <p>
                1 Boxes with Credit/Debit Card
                2nd Box Stripe <a href="#"> Stripe Button </a>
            </p>
            <p> 
                Option 1: Stripe
                Option 2: Venmo -> Once the payments have been processed we will email you the shipping confirmation!
            </p>
            <a href="/views/checkout/review.php"> REVIEW </a>
        </div>
    </div>
    <?php
        var_dump($_SESSION);
    ?>
</body>
</html>