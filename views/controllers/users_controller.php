<?php 
    require('../views/connection.php');
    var_dump($_POST);
    var_dump($_SESSION);

    
    /*
        User is logging in FROM register.php
    */
    if($_POST['login'] === "SIGN IN" || $_POST['login'] === "SIGN IN & CHECKOUT"){
        //var_dump("USER IS LOGGING IN. FIND THEM IN THE DATABASE");
        
        $email = $_POST['email_address'];
        $password = $_POST['password'];
        $login_query = 
        "
            SELECT
                *
            FROM users 
            WHERE users.email = '$email' AND users.password = '$password' 
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
            var_dump("Could not find user");
        } else {
            var_dump($login_user);
        }
        
    }
    /*
        User is logging in FROM login.php
    
    if($_POST['login'] === "SIGN IN & CHECKOUT"){
        //var_dump("USER IS LOGGIN IN. FIND THEM IN THE DATABASE");
        login_process();
    }*/
    /*
        User is creating a new account FROM register.php
    */
    if($_POST['login'] === "CREATE ACCOUNT"){
        var_dump("USER IS CREATING A NEW ACCOUNT");
        //User Validation
        //EMAIL MUST BE UNIQUE!!!!
    }

    function login_process(){
        var_dump("LOGIN FUNCTION");
        //var_dump($_POST['email_address']);
        $email = $_POST['email_address'];
        $password = $_POST['password'];
        $login_query = 
        "
            SELECT
                *
            FROM users 
            WHERE users.email = '$email' AND users.password = '$password' 
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
        var_dump($login_user);
        var_dump("User is logged in");
    }
?>