<?php
    require('../connection.php');
    $connection = connection_query();
    
    //var_dump($_SESSION);
    //var_dump($_SESSION['shopping_cart']);
    //var_dump($_SESSION['guest']);
    //var_dump($_SESSION['user']);
    /*
        $database['info'] stores the current info about the user and will also show this information inside each input tags
    */
    $database['user_id'] = $_SESSION['user']['user_id'];
    $database['first_name'] = $_SESSION['user']['first_name'];
    $database['last_name'] = $_SESSION['user']['last_name'];
    $database['email_address'] = $_SESSION['user']['email_address'];
    $database['address1'] = $_SESSION['user']['address1'];
    $database['address2'] = $_SESSION['user']['address2'];
    $database['city'] = $_SESSION['user']['city'];
    $database['state'] = $_SESSION['user']['state'];
    $database['zip_code'] = $_SESSION['user']['zip_code'];
    
    /*
        User clicked the update button from SHIPPING.PHP page, which created the $_SESSION['update_information']. Send the user to SHIPPING.PHP OR review.php once the user update their information.
    */
    if($_SESSION['update_information'] === 'yes' && isset($_POST['update'])){
       update_information($connection);
       get_information($db);
       unset($_SESSION['update_information']);
       header("Location: /views/checkout/shipping.php");
       exit();
    }
    
    /*
        User is logged in and wants to update their account. Refresh UPDATE_ACCOUNT2.php so the user can see their updated information.
    */
    if($_POST['update'] === 'yes'){
        update_information($connection);
        get_information($db);
        header("Location: /views/test/update_account2.php");
        exit();
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
                <a class="btn btn-primary" href="../../views/test/update_account2.php"> Update Account </a>
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
    <div class="container">
            <h3>Update Account</h3>
            <p>CREATE AN ICON SAYING UPDATE HAS BEEN SUCCESSFUL!!</p>
            <div class="alert alert-warning" role="alert">
                Please verify that the following information is correct.
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="update_shipping_validation" novalidate>
                <input type="hidden" name="user_id" value="<?=$database['user_id']?>">
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$database['first_name']?>" required>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$database['last_name']?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="email">Email *</label>
                        <input type="text" class="form-control" id="email_address" name="email_address" value="<?=$database['email_address']?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="address">Address *</label>
                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Street Address, P.O. Box" value="<?=$database['address1']?>" required>
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Apt #, Suite, Floor (optional)" value="<?=$database['address2']?>">
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="city">City, State *</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?=$database['city']?>" required>
                        <input type="text" class="form-control" id="state" name="state" value="<?=$database['state']?>" required>
                        <div class="invalid-feedback">
                            Please provide your address.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="zip_code">ZIP Code *</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?= $database['zip_code']?>" required>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="update" value="yes">Update Account</button>
            </form>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
<?php
    function update_information($connection){
        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email_address = $_POST['email_address'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip_code = $_POST['zip_code'];
        
        if($connection->connect_error){
            die("Connection failed: ". $connection->connect_error);
        }

        $update_stmt = "
            UPDATE users SET users.first_name = '$first_name', users.last_name = '$last_name', users.email_address = '$email_address', users.address1 = '$address1', users.address2 = '$address2', users.city = '$city', users.state = '$state', users.zip_code = '$zip_code', users.UPDATED_AT = NOW() WHERE users.user_id = $user_id
        ";

        if($connection->query($update_stmt) === FALSE){
            echo "Error updating record: ". $connection->error;
            echo "FAILED AT update_info function";
        } else {
            $connection->close();
        }
    }

    function get_information($db){
        $user_id = $_SESSION['user']['user_id'];
        
        $update_query = 
        "
            SELECT
                user_id, first_name, last_name, email_address, address1, address2, city, state, zip_code
            FROM users 
            WHERE users.user_id = '$user_id'
        ";

        try
        {
            $get_user_stmt = $db->prepare($update_query);
            $get_user_stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("FAILED TO RUN query: ". $ex->getMessage());
            echo "FAILED at get_info function";
        }

        $updated_user = $get_user_stmt->fetch();
        $_SESSION['user'] = $updated_user;
    }
?>