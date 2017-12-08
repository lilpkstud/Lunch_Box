<?php
    require('../connection.php');

    $duplicate_email_error = "Email is already in use. Please type in your password to verify this transaction. ";
   
    if($_POST['login'] === "SIGN IN"){
        $email = $_POST['email_address'];
        $password = $_POST['password'];
        $login_query = 
        "
            SELECT
                *
            FROM users 
            WHERE users.email_address = '$email' AND users.password = '$password' 
        ";
                
        try {
            $login_stmt = $db->prepare($login_query);
            $login_stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("FAILED TO RUN query: ". $ex->getMessage());
        }
        
        $login_user = $login_stmt->fetch();
        
        /*
            The email/password combo cannot be found in database. Have the user rety
        */
        if($login_user == false)
        {
           $login_error = "Email and password combination is incorrect. Please try again";
        } else {
            $_SESSION['user'] = $login_user;
            /*
                Might have to check if the guest info and user from the DB matches.
            */
            unset($_SESSION['guest']);
            header("Location: /views/checkout/shipping.php");
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
        <!-- The Modal -->
        <div id="emailModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=""> Duplicate Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?= $duplicate_email_error ?></p>    
                    </div>
                    <div class="modal-footer">
                        <button id="yes"> Ok </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Have the guest verify that the email they are using is theirs. If they forgot their password have them click on a link to reset their password -->
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1> Email Verification </h1>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <p> <label for="email_address"> Email Address: </label>
                            <input type="email" name="email_address" value="<?=$_SESSION['guest']['email']?>">
                        </p>
                        <p><label for="password"> Password: </label>
                            <input type="password" name="password">
                        </p>
                        <input type="submit" name="login" value="SIGN IN">
                    </form>
                    <a href="#"> Forgot Password? </a>
                    <br></br>
                    <span class="error"> <?php echo $login_error;?> </span>
                </div>
            </div>
        </div>
    </div>
    <?php
        /*
            Only show the Duplicate Email Modal once 
        */ 
        if(empty($_POST['login'])){
            var_dump("Currently working");
    ?>
        <script>
            $(window).on('load',function(){
                $('#emailModal').modal('show');
            });
            var yes = document.getElementById("yes");
            //When the user clicks on the YES button, send the user to...
            yes.onclick = function() {
                $('#emailModal').modal('hide');
            } 
        </script>
    <?php
        }
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>