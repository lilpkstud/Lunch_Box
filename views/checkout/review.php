<?php
    require('../connection.php');

    /*
        User has reviewed everything and is pulling the trigger to buy the product(s)
    */
    if($_POST['confirmed'] == "Buy Now")
    {
        //Grabbing the last invoice number
        $order_invoice_query = " 
            SELECT 
                MAX(invoice_number) AS invoice_number
            FROM orders
        ";
        try 
        { 
            // These two statements run the query against your database table. 
            $order_invoice_stmt = $db->prepare($order_invoice_query); 
            $order_invoice_stmt->execute();
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        }
        /* 
            Retrieve the last row by grabbing the largest integer of invoice_number. Once the row is grabbed, add 1 so the order will then go up.
        */
        $previous = $order_invoice_stmt->fetch();
        $convert = (int)$previous['invoice_number'];
        $current = $convert + 1;
    
        /*Invoice Testing */
        //If user is not saved = ASK IF THEY WANT THEIR INFORMATION TO BE SAVED
        //var_dump($_POST);
        //1. PUSH SESSION['shopping_cart'] into orders 
        //var_dump("Yup");

        //2. unset($_SESSION['shopping_cart']);

        //3.header("Location: /");
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "shopping_cart";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        foreach($_SESSION['shopping_cart'] as $product_id => $product):
            $user_id = $_SESSION['user']['user_id'];
            $sku = $product['product_sku'];
            $color = $product['product_color'];
            $quantity = $product['user_quantity'];
            
            $order_query = 
            "
                    INSERT INTO orders (user_id, product_sku, invoice_number, product_color, quantity, CREATED_AT, UPDATED_AT) 
                    VALUES('$user_id', $sku, '$current', '$color', $quantity, NOW(), NOW());
            ";
            
            if($conn->query($order_query) === TRUE) {
                //echo "New record created";
            } else {
                echo "Error: ".$order_query."<br>".$conn->error;
            }
        endforeach;
            if($conn->query($order_query) === TRUE) {
                unset($_SESSION['shopping_cart']);
                unset($_SESSION['total_quantity']);
                header("Location: /");
                exit();
                $conn->close();
            }
        
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

    <style>
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style> 
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
                <a class="btn btn-primary" href="/views/connection.php?logout=yes" role="button">LOGOUT</a>
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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Shipping Address</li>
                    <li class="breadcrumb-item">Billing</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Review</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col">
                     <h1>Order Review</h1>
                     <?php
                        var_dump($_SESSION['shopping_cart']);
                        //var_dump($_SESSION['total_quantity']);
                        //var_dump($_SESSION['shopping_cart']);
                        foreach($_SESSION['shopping_cart'] as $item):?>
                            <h4><?=$item['product_name']?></h4>
                            <p>Total Price: $<?=$item['product_price']?> x <?=$item['user_quantity']?></p>
                    <?php
                        endforeach;
                    ?>
                    <p><strong>Grand Total = $<?=$_SESSION['grand_total']?></strong></p>     
                </div>
                <div class="col">
                    <h1>Shipping Address</h1>
                    <?php /* Show the LOGGED IN user's shipping information */ 
                    if(isset($_SESSION['user'])){ ?>
                        <address>
                            <strong>
                                <?=$_SESSION['user']['first_name']." ".$_SESSION['user']['last_name']?>
                            </strong>
                            <p>
                                <?=$_SESSION['user']['address1']." ".$_SESSION['user']['address2']?> <br>
                                <?=$_SESSION['user']['city'].", ".$_SESSION['user']['state']." ".$_SESSION['user']['zip_code']?>
                            </p>
                        </address>
                        <form action="/views/controllers/checkout_controller.php" method="post">
                            <input type="submit" name="confirmed" value="Buy Now">
                        </form>
                    <?php 
                    } 
                    /* Show the GUEST's shipping information */
                    if(isset($_SESSION['guest'])) {  ?>
                        <address>
                            <strong>
                                <?=$_SESSION['guest']['first_name']." ".$_SESSION['guest']['last_name']?>
                            </strong>
                            <p>
                                <?=$_SESSION['guest']['address1']." ".$_SESSION['guest']['address2']?> <br>
                               <?=$_SESSION['guest']['city'].", ".$_SESSION['guest']['state']." ".$_SESSION['guest']['zip_code']?>
                            </p>
                        </address>
                    <?php
                        echo "Guest is signed in <br>";
                        var_dump($_SESSION['guest']);
                        /* 
                            Ask the guest if they would like to save the information for future use
                        */
                            
                    ?>
                            <!-- Trigger/Open The Modal -->
                            <button id="myBtn">Buy Now Modal </button>

                            <!-- The Modal -->
                            <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id=""> Create Account </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Would you like to create an account with us?</p>    
                                        </div>
                                        <div class="modal-footer">
                                            <button id="yes"> Yes </button>
                                            <button id="no"> No </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the YES button that goes the modal
        var yes = document.getElementById("yes");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        //When the user clicks on the YES button, send the user to...
        yes.onclick = function() {
            location.href = "/views/users/guest.php?save=yes";
            var text1 = json_encode($duplicate_email_error);
            console.log(text1);
        }

        //When the user clicks on the NO button, send the user to...
        no.onclick = function() {
            location.href = "/views/users/guest.php?save=no";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            emailModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>