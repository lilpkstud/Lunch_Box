<?php
    /*
        User is creating a new account
    */
    if($_POST['login'] === "CREATE ACCOUNT"){
        //var_dump("USER IS CREATING A NEW ACCOUNT");
        //var_dump($_POST);
        //die();
        
        $first_name = (string)$_POST['first_name'];
        $last_name = (string)$_POST['last_name'];
        $email = (string)$_POST['email'];
        $password = (string)$_POST['password'];
        $password_confirmation = (string)$_POST['password_confirmation'];
        
        //1. Check if password and password_confirmation is in use
        if($password != $password_confirmation){
            $password_error = "Password did not match. Please try again.";
        } else {
            //2. Check if email is already in use
            $login_query = 
            "
                SELECT
                    email_address
                FROM users 
                WHERE users.email_address = '$email'; 
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
                If the email is found in database. Have the user use another email account
            */
            if($login_user == true)
            {
                $duplicate_email_error = "Email is already in use.";
            } else {
                var_dump("Made it");
                die();
                /*$servername = "localhost";
                $username = 'root';
                $password = 'root';
                $dbname = 'shopping_cart';

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 

                $create_user_query = 
                "
                    INSERT INTO users (first_name, last_name, email_address, password) 
                    VALUES('$first_name', '$last_name', '$email', '$password_confirmation')
                ";
                    
                if($conn->query($create_user_query) === TRUE) {
                    $_SESSION['user'] = $_POST;
                    header("Location: /views/test/shipping_testing.php");
                    exit();
                }
                else {
                    echo "Error: ".$create_user_query."<br>".$conn->error;
                }
                $conn->close();*/

                header("Location: /");
                exit();
            }
           
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Bootstrap 4.0 -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!-- JQuery -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

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
     <nav class="navbar">
        <div class="container-fluid">
            <!-- Use any element to open the sidenav -->
            <span onclick="openNav()">
                <i id="bars" class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </span>
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Lots of Yellow</a>
            </div>
        </div>
    </nav>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/">HOME</a>
        <a href="/views/about.php">ABOUT</a>
        <a href="/views/meet_team.php">MEET THE TEAM</a>
        <a href="/views/senior_package.php">SENIOR PACKAGE</a>
        <a href="#">APPLICATION</a>
        <a href="/views/contact_page.php">CONTACT US</a>
    </div>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="content">
        <h3> Create An Account </h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="creating_account_validation" novalidate class="container">
            <div class="row">
                <div class="col-md-6 mb-3 form-group">
                    <label for="first_name"> First Name</label>
                    <input type="text" class="form-control "name="first_name" id="first_name" required >
                    <div class="invalid-feedback">
                        Please provide your first name.
                    </div>
                </div>
                <div class="col-md-6 mb-3 form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                    <div class="invalid-feedback">
                        Please provide your last name.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 form-group">
                    <label for="email"> Email </label>
                    <input type="text" class="form-control" name="email" id="email" required>
                    <div class="invalid-feedback">
                        Please provide your email address.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 form-group">
                    <label for="passowrd"> Password </label>
                    <input type="password" class="form-control "name="password" id="password" required>
                </div>
                    <div class="col-md-6 mb-3 form-group">
                    <label for="passowrd"> Confirm Password </label>
                    <input type="password" class="form-control "name="password_confirmation" id="password_confirmation" required>
                </div>
                    <div class="invalid-feedback">
                        Password does not match. Please try again.
                        <?php echo $password_error; ?>
                </div> 
                <span class="error"> <?php echo $password_error;?> </span> 
            </div>
            <input type="submit" name="login" value="CREATE ACCOUNT">
        </form>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
    Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Account successfully created. Please login
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
        'use strict';
            window.addEventListener('load', function() {
                var form = document.getElementById('creating_account_validation');
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    if(form.checkValidity() === true){
                       //alert("Account successfully created. Please login");
                    }
                    form.classList.add('was-validated');
                },
                false);
            }, 
            false);
        })();
    </script>

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