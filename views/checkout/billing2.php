<?php 
    require('../connection.php');
    //if($_POST['same_billing'] == "same")

    var_dump($_POST);
    var_dump($_SESSION);
    //die();
    
    /*
        If the user is not signed-in, send the user to the login.php to sign-up OR sign-in as a guest.
        ELSE => Show the billing
    
    if(!isset($_SESSION['user'])){
        header("Location: /views/users/login.php");
        exit();
    }*/
    //var_dump($_POST);
    //var_dump($_SESSION);
    //Save Customer's Information to Session so.....
   $_SESSION['user_first_name'] = $_POST['first_name'];
   $_SESSION['user_shipping_address'] = $_POST;
    //var_dump($_SESSION);
    //if($_POST['same_billing'] == "same"){
        //Redirect to the Review Page
        //header("Location: review.php");
        //exit();
    //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lunch Box Socks</title> <!-- Bootstrap CSS -->
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
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">HOME</a>
        <a id="product_logo_tag" href="#"><img id="product_logo" src="/img/jordan.jpg" alt=""></a>
        <a href="#">ABOUT</a>
        <a href="#">FAQ</a>
        <a href="/views/checkout/shopping_cart.php"> Shopping Cart </a>
    </div>

    <!-- Use any element to open the sidenav -->
    <span onclick="openNav()">
        <i id="bars" class="fa fa-bars fa-2x" aria-hidden="true"></i>
    </span>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="content">  
        <h3>Choose A Payment Method </h3>
        <p>
            1 Boxes with Credit/Debit Card
            2nd Box Stripe <a href="#"> Stripe Button </a>
        </p>
        <form action ="review.php" method="post" class="container" id="billing-validation" novalidate>
            <h3> Enter Your Card Details: </h3>
            <p>
                <label for="card_number">
                    Card Number
                    <input type="number" name="card_number">
                </label>
            </p>
            <p>
                <label for="security_code">
                    Security Code
                    <input type="number" name="security_code">
                </label>
            </p>
            <p>
                <label for="expiration_date">
                    Expiration Date
                    <select name="month">
                        <option value="default">Month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    /
                    <select name="year">
                        <option value="default">Year</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </label>
            </p>
            <p>
                <label for="card_name">
                    Name On Card
                    <input type="text" name="name">
                </label>
            </p>
            <?php
                if($_POST['same_billing'] === "same"){
            ?>
                    <h3> Your Card's Billing Address </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$_POST['first_name']?>">
                        </div>
                        <div class="col-md-6 mb-3 form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$_POST['last_name']?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="address">Address *</label>
                            <input type="text" class="form-control" id="address1" name="address1" value="<?= $_POST['address1']?>">
                            <?php
                                if(!empty($_POST["address2"])){
                            ?>       
                                    <input type="text" class="form-control" id="address2" name="address2" value="<?= $_POST['address2']?>">
                            <?php
                                } else {
                            ?>
                                <input type="text" class="form-control" id="address3" name="address3" placeholder="Apt #, Suite, Floor (optional)">
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group">
                            <label for="zipcode">ZIP Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value=<?=$_POST['zip_code']?>>
                        </div>
                    </div>
            <?php
                } else {
            ?>
                <h3>Your Card's Billing Address</h3>
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
            <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function() {
                    'use strict';
                        window.addEventListener('load', function() {
                            var form = document.getElementById('billing-validation');
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
            </script>
            <?php
                }
            ?>
            <input type="submit" name="Submit" value="Review">
        </form>
    </div>
</body>
</html>