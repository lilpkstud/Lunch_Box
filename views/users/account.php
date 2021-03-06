<?php
    require('..//connection.php');
    
    $user_id = $_SESSION['user']['user_id'];

    /* Grab all orders the user has purchased */
    $query="
        SELECT orders.invoice_number, orders.shipped, products.sku, products.product_name, products.description, products.price, products.color FROM orders JOIN products on orders.product_sku = products.sku
        WHERE orders.user_id = $user_id
    ";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOExpection $ex)
    {
        die("Failed to run query: ". $ex->getMessage());
    }
    
    $rows = $stmt->fetchAll();

    var_dump($rows[0], $_SESSION);
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
    
    <!-- Index CSS -->
    <link rel="stylesheet" type="text/css" href="/css/index.css">
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
            <?php
                /*
                    Allow the user to logout if the $_SESSION['user'] is set
                */
                if(isset($_SESSION['user'])){
            ?>
                <a class="btn btn-primary" href="../views/users/account.php">Account</a>
                <a class="btn btn-primary" href="../views/test/update_account2.php"> Update Account </a>
                <a class="btn btn-primary" href="../views/connection.php?logout=yes" role="button">LOGOUT</a>
            <?php        
                } else {
            ?>
                <a class="btn btn-primary" href="/views/users/register.php" role="button">LOGIN</a>
            <?php
                }
            ?>
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
            <div class='row'>
            <h2>User Information</h2>
                <div class='col-lg-12'>
                    <div class='row'>
                        <div class='col-lg-4'>
                            <strong>First Name:</strong> <?=$_SESSION['user']['first_name']?>
                        </div>
                        <div class='col-lg-4'>
                            <strong>Last Name:</strong> <?=$_SESSION['user']['last_name']?>
                        </div>
                        <div class='col-lg-4'>
                            <strong>Email:</strong> <?=$_SESSION['user']['email_address']?>
                        </div>
                        <div class='col-lg-12'>
                            <strong>Shipping Address:</strong> <?=$_SESSION['user']['address1'].' '.$_SESSION['user']['city']?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <h2>Order History</h2>
                    <table>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Product Color</th>
                            <th>Product Description</th>
                            <th>Shipped?</th>
                        </tr>
                        
                        <?php foreach($rows as $order): ?>
                        <tr>
                            <td><?=$order['invoice_number']?></td>
                            <td><?=$order['product_name']?></td>
                            <td>$<?=$order['price']?></td>
                            <td><?=$order['color']?></td>
                            <td><?=$order['description']?></td>
                            <td><?=$order['shipped']?></td>
                        </tr>
                        <?php endforeach?>
                    </table>
                </div>
            </div>
        </div>
            
    </div>
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