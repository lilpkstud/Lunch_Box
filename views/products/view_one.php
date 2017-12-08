<?php
    require('../connection.php');
    
    $product_sku = $_GET['product_sku'];
    $current_color = $_GET['color'];

    //This query will grab ALL information about the product by the product_sku AND product_color.
    $product_query = " 
        SELECT 
            * 
        FROM products WHERE sku = ".$product_sku." AND color = '$current_color'
    ";
    
    //This query will grab OTHER colors that has the SAME product_sku. Then users can see other color options.
    $all_color_query = " 
        SELECT 
            color, quantity 
        FROM products WHERE sku = 
    ".$product_sku;
    try 
    { 
        // These two statements run the query against your database table. 
        $product_stmt = $db->prepare($product_query); 
        $product_stmt->execute();

        $all_color_stmt = $db->prepare($all_color_query);
        $all_color_stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    }
    // Finally, we can retrieve the row into an array using fetch to get ONE row.
    $product = $product_stmt->fetch();
    $product_colors = $all_color_stmt->fetchAll();     
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
    
    <!-- Actual Navigation CSS -->
    <link rel="stylesheet" type="text/css" href="/css/actual_navigation.css">

    <!-- Actual Navigation JS -->
    <script src="/js/navigation.js"></script>
    
    <!-- View One CSS -->
    <link rel="stylesheet" type="text/css" href="/css/view_one.css">
    
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
            <p>Position Left should be bigger...have to change the sizing of position right</p>
            <div class="row">
                <div class="col position_left">
                    <img class="side_product_img" src="<?=$product['img_hover']?>" alt="">
                    <img class="main_product_img"src="<?=$product['img_url']?>" alt="">
                </div>
                <div class="col position_right">
                    <h1><?=$product['product_name']?></h1>
                    <p>$<?=$product['price']?></p>
                    <form action="../controllers/cart_controller.php" method="post">
                        <input id="add_item" name="add_item" type="hidden" value="yes">
                        <input id="product_name" name="product_name" type="hidden" value="<?=$product['product_name']?>">
                        <input id="product_price" name="product_price" type="hidden" value="<?=$product['price']?>">
                        <input id="product_color" name="product_color" type="hidden" value="<?=$product['color']?>">
                        <input id="product_sku" name="product_sku" type="hidden" value="<?=$product['sku']?>">
                        <?php
                            /* Do not allow users to input any amount of quantity because this product is out of stock */
                            if($product['quantity'] == 0) {
                        ?>
                                <fieldset disabled>   
                                    <div class="form-group">
                                        <label for="quantity"> Quantity </label>
                                        <select class="form-control" id="user_quantity">
                                            <option> Out of Stock </option>
                                        </select>
                                    </div>
                                </fieldset>
                        <?php
                            } else {
                        ?>
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <div class="form-group">
                                        <select class="form-control" id="user_quantity" name="user_quantity">
                                            <option value="1"> 1 </option>
                                            <option value="2"> 2 </option>
                                            <option value="3"> 3 </option>
                                            <option value="4"> 4 </option>
                                            <option value="5"> 5 </option>
                                        </select>
                                    </div>
                                <button type="submit"> Add To Cart </button>
                        <?php
                            }
                        ?>
                    </form>
                </div>  
                <div class="w-100"></div>  
            </div>
            <div class="row">
                <div class="col center">
                    <a href="#">  
                    <div class="card" style="width: 20rem;">
                        <img class="card-img-top" src="/img/cross.jpg" alt="Other Product 1">
                        <div class="card-body">
                            <p class="card-text">Current Color Product 1 of 3</p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col center">
                    <div class="card" style="width: 20rem;">
                        <a href=""> <img class="card-img-top" src="/img/cross.jpg" alt="Other Product 1"></a>
                        <div class="card-body">
                            <p class="card-text">Other Color Product 2 of 3</p>
                        </div>
                    </div>
                </div>
                <div class="col center">
                    <div class="card" style="width: 20rem;">
                        <img class="card-img-top" src="/img/cross.jpg" alt="Other Product 1">
                        <div class="card-body">
                            <p class="card-text">Other Color2 Product</p>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>  
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <a href="/">
                    <div class="card">
                        <img class="card-img-top" src="/img/cross.jpg" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Current Color Product</h4>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                    </a>
                </div>
            <div class="col-sm-6">
                <a href=""> 
                <div class="card">
                    <img class="card-img-top" src="/img/cross.jpg" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Other Color Product</h4>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                </a>
            </div>
        </div>    
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>