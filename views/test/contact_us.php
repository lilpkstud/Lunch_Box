<?php
    if(isset($_POST['submit'])){

        $recipient = "lotsofyellowww@gmail.com";
        $subject = "A client has contacted you!";
        $sender = $_POST["client_name"];
        $senderEmail = $_POST["client_email"];
        $message = $_POST["client_message"];

        $mailBody="Name: $sender\nEmail: $senderEmail\n\n$message";

        mail($recipient, $subject, $mailBody, "From: $sender <$senderEmail>");
        header("Location: /");
        exit();
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
    <link rel="stylesheet" type="text/css" href="../css/navigation.css">

    <!-- Navigation JS -->
    <script src="../js/navigation.js"></script> 

    <!-- Contact CSS -->
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
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
        <h1 class="title">Contact Us</h1>
        <form action="/views/contact_page.php" method="post" class="container" id="form-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_name">Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Name" required>
                    <div class="invalid-feedback">
                        Please provide your name.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_email">Email</label>
                    <input type="email" class="form-control" id="client_email" name="client_email" placeholder="Email" required>
                    <div class="invalid-feedback">
                        Please provide your email.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_message">Message</label>
                    <textarea rows="5" cols="20" id="client_message" name="client_message" class="form-control" required></textarea>
                    <div class="invalid-feedback">
                        Message required. 
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit" name="submit" value="hi">Submit</button>
        </form>
    </div>

    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
        window.addEventListener('load', function() {
            var form = document.getElementById('form-validation');
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