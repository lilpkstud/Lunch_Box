<?php
    require('../connection.php'); 
    /*
        UPDATE MYSQL COMMAND NOT WORKING. FIND A WAY TO FIX THIS SHIT.
    */
    //Check if user POST form is the same as the database.
        
        $database = $_SESSION['user'];
        $update = $_SESSION['update_information'];
        //var_dump($database);
        //var_dump($_POST);
        
    if($_POST['update'] === "yes"){
        //var_dump($database['user_id']);
        //var_dump($_POST);
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

        $user_id = $database['user_id'];
        $first_name = (string)$_POST['first_name'];
        $last_name = (string)$_POST['last_name'];
        $email_address = (string)$_POST['email_address'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $zip_code = $_POST['zip_code'];
        
        $update_query = "UPDATE users
            SET 
                users.first_name = 'TEST'
                
            WHERE 'users.user_id' = 2; 
        ";

        try
        {
            $stmt = $db->prepare($update_query);
            $stmt->execute();
        } 
        catch(PDOExpection $ex)
        {
            die("Failed to run query: ". $ex->getMessage());
        }
       

        /*if(mysqli_query($conn, $update_query)){
            echo "Account has been updated";
        }  else {
            echo "Error updating record: ".mysqli_error($conn);
        }*/


    
        //$rows = $stmt->fetchAll();

       // mysqli_close($conn);

        //var_dump($rows);
       
        /*
        last_name = '$last_name',
                email_address = '$email_address',
                address1 = '$address1',
                address2 = '$address2',
                zip_code = '$zip_code',
                UPDATED_AT = NOW()
        if($conn->query($update_query) === TRUE) {
            //unset($_SESSION['shopping_cart']);
            //unset($_SESSION['total_quantity']);
            header("Location: /");
            exit();
            //var_dump("Account has been updated");
            $conn->close();
        } else {
            echo "Error: ".$update_query."<br>".$conn->error;
        }*/
        
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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Shipping Address</li>
                    <li class="breadcrumb-item">Billing</a></li>
                    <li class="breadcrumb-item">Review</a></li>
                </ol>
            </nav>
            <h3>Update Account</h3>
            <div class="alert alert-warning" role="alert">
                Please verify that the following information is now correct.
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="update_shipping_validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="first_name">First Name *</label>
                        <?php if($database['first_name'] != $update['first_name']){ ?>
                            <input type="text" class="form-control" id="first_name" name="first_name" value ="<?= $update['first_name']?>"required>
                        <?php }  else { ?>
                            <input type="text" class="form-control" id="first_name" name="first_name" value ="<?=$database['first_name']?>" required>
                        <?php } ?>
                         <div class="invalid-feedback">
                            Please provide your first name.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="last_name">Last Name *</label>
                        <?php if($database['last_name'] != $update['last_name']){ ?>
                            <input type="text" class="form-control" id="last_name" name="last_name" value ="<?= $update['last_name']?>"required>
                        <?php }  else { ?>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$database['last_name']?>" required>
                        <?php } ?>
                        <div class="invalid-feedback">
                            Please provide your last name.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="email">Email *</label>
                        <?php if($database['email_address'] != $update['email']){ ?>
                            <input type="text" class="form-control" id="email_address" name="email_address" value ="<?= $update['email']?>"required>
                        <?php }  else { ?>
                            <input type="text" class="form-control" id="email_address" name="email_address" value="<?= $database['email_address']?>" required>
                        <?php } ?>
                        <div class="invalid-feedback">
                                Please provide your email address.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="address">Address *</label>
                        <?php if($database['address1'] != $update['address1']){ ?>
                            <input type="text" class="form-control" id="address1" name="address1" value ="<?= $update['address1']?>"required>
                        <?php }  else { ?>
                            <input type="text" class="form-control" id="address1" name="address1" value="<?= $database['address1']?>" required>
                        <?php } ?>
                        <?php if(!empty($update['address2']) || $database['address2'] != $update['address2']){ ?>
                            <input type="text" class="form-control" id="address2" name="address2" value ="<?= $update['address2']?>">
                        <?php }  else { ?>
                            <input type="text" class="form-control" id="address2" name="address2" value="<?= $database['address2']?>" placeholder = "Apt #, Suite, Floor (optional)">
                        <?php } ?>
                        <div class="invalid-feedback">
                                Please provide your shipping address.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="zip_code">ZIP Code *</label>
                        <?php if($database['zip_code'] != $update['zip_code']){ ?>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value ="<?= $update['zip_code']?>"required>
                        <?php }  else { ?>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?= $database['zip_code']?>" required>
                        <?php } ?>
                        <div class="invalid-feedback">
                                Please provide your zip code.
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="same_billing" value="same">
                        This address is also my billing address
                    </label>
                </div>
                <button class="btn btn-primary" type="submit" name="update" value="yes">Update Account</button>
            </form>
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