<?php
    require('../connection.php');
     /*
        Admin is attempting to login
    */
    if($_POST['login'] === "Login"){
        $email = $_POST['email_address'];
        $password = $_POST['password'];
       
        $login_query = 
        "
            SELECT
                user_level
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
        if($login_user == true && $login_user['user_level'] == 1){
            header("Location: /views/admin/admin_dashboard.php");
            exit();
        } else {
            echo "DONT TRY TO HACK OUR WEBSITE BOIII";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <p> 
            <label for="email_address"> Email Address: </label>
            <input type="email" name="email_address">
        </p>
        <p>
            <label for="password"> Password: </label>
            <input type="password" name="password">
        </p>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>