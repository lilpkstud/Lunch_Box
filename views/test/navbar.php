<?php
    //Copied Navigation2.php 
    require('../connection.php');
    //var_dump($_SESSION);
    $query="
        SELECT * FROM products
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
            <a class="btn btn-primary" href="#" role="button">LOGIN</a>
            <a id="cart_logo" href="/views/checkout/shopping_cart.php">
                <i id="SDFi_shopping_logo"class="fa fa-shopping-cart fa-2x" aria-hidden="true">(<?=$_SESSION['total_quantity']?>)</i>
            </a>
        </div>       
    
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">HOME</a>
            <a id="product_logo_tag" href="#"><img id="product_logo" src="/img/jordan.jpg" alt=""></a>
            <a href="#">ABOUT</a>
            <a href="#">FAQ</a>
            <a href="/views/checkout/shopping_cart.php"> Shopping Cart </a>
        </div>
    </nav>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="content">
         <div class="container">
            <div class="row">
                <?php
                    foreach($rows as $product_key=>$product):
                        if($product_key % 2 ==0){
                            echo "<div class='w-100'> </div>";
                        }
                ?>
                    <div class="col">
                        <div id="hover"
                            onmouseover="
                                $(this).find('.product_image').css('visibility','hidden'); 
                                $(this).find('.hidden').css('visibility', 'visible');
                            "
                            onmouseout="
                                $(this).find('.product_image').css('visibility', 'visible');
                                $(this).find('.hidden').css('visibility', 'hidden');

                            "
                        >
                            <a href="/views/products/view_one.php?product_sku=<?=$product['sku']?>&color=<?=$product['color']?>">
                                <img class="product_image" src="<?=$product['img_url']?>" alt="">
                                <img class="hidden" src="<?=$product['img_hover']?>" alt="">
                            </a>
                        </div>
                        <h3 class="product_info"><?=$product['product_name']?></h3>
                        <p class="product_info"><?=$product['price']?></p>
                    </div>
                <?php
                    endforeach;        
                ?>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>