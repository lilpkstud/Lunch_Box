<?php
//This page is only loaded when the user is LOGGED IN!!
//NOT FOR GUEST -> Guest is sent to shipping.php
    require('../connection.php');
    if($_GET['logout'] == "yes"){
        unset($_SESSION["user"]);
        header("Location: /views/test/shipping_testing.php");
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
            <a href="/views/test/shipping_testing.php?logout=yes"> Logout </a>
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
                    <li class="breadcrumb-item active" aria-current="page">Shipping Address</li>
                    <li class="breadcrumb-item">Billing</a></li>
                    <li class="breadcrumb-item">Review</a></li>
                </ol>
            </nav>            
        <h3>Checkout</h3>
        <?php
            if(!isset($_SESSION['user'])){

        ?>
            <form action="/views/checkout/billing.php" method="post" id="shipping-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                        <div class="invalid-feedback">
                            Please provide your first name.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                        <div class="invalid-feedback">
                            Please provide your last name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                            Please provide your email address.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="address">Address *</label>
                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Street Address, P.O. Box" required>
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Apt #, Suite, Floor (optional)">
                        <div class="invalid-feedback">
                            Please provide your address.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="zipcode">ZIP Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                        <div class="invalid-feedback">
                            Please provide your zipcode. 
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="same_billing" value="same">
                        This address is also my billing address
                    </label>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        <?php
            } else {
                var_dump($_SESSION['shopping_cart']);
                var_dump($_SESSION['user']);
        ?>
            <p> Please verify if all your information is still current </p>
            <form action="/views/checkout/billing.php" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$_SESSION['user']['first_name']?>">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$_SESSION['user']['last_name']?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?=$_SESSION['user']['email_address']?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="address">Address *</label>
                        <input type="text" class="form-control" id="address1" name="address1" value="<?=$_SESSION['user']['address1']?>">
                        <input type="text" class="form-control" id="address2" name="address2" value="<?=$_SESSION['address2']?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="zipcode">ZIP Code</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?=$_SESSION['user']['zip_code']?>">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Verified</button>
            </form>
        <?php
            }
        ?>
    </div>

   <?php  
   /* <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
        window.addEventListener('load', function() {
            var form = document.getElementById('shippiing-validation');
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                if(form.checkValidity() === true) {
                    alert("Message sent. We will contact you shortly!");
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
    </script>*/
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>