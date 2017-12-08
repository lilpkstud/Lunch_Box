/*require('../connection.php');
    $conn = connection_query();
    var_dump($conn);
    die();
    
    /*
        Guest has clicked yes to create an account

        1. Save the guest information and insert it to the db
        1A. Have the guest create a password/password_confirmation
        1B. Have the guest already login 
        
        2. Create the order
        2A. Send the old guest/new user to the confirmation.php 
        
    */
    //echo "GUEST.PHP";
    //var_dump($_GET);
    //var_dump($_SESSION);
    /*
        GUEST user has reviewed and ...
            1A. Guest clicked yes to create an account
            1B. Guest clicked no to creating an account
            2. Guest wants to buy their shopping cart item
    */

    if($_GET['save'] === "yes"){
        var_dump("HI");
        die();
        $first_name = $_SESSION['guest']['first_name'];
        $last_name = $_SESSION['guest']['last_name'];
        $email = $_SESSION['guest']['email'];
        $address1 = $_SESSION['guest']['address1'];
        $address2 = $_SESSION['guest']['address2'];
        $zip_code = $_SESSION['guest']['zip_code'];
        var_dump($email);
        duplicate_email($email);
        //create_user($conn, $first_name, $last_name, $email);
        //$login_user_id = get_user($email, $db);
        //var_dump($login_user_id);
        //die();
        //create_order($db, $conn, $login_user_id);
        
    }
    if($_GET['save'] === "no"){
        $first_name = $_SESSION['guest']['first_name'];
        $last_name = $_SESSION['guest']['last_nane'];
        $email = $_SESSION['guest']['email'];
        $address1 = $_SESSION['guest']['address1'];
        $address2 = $_SESSION['guest']['address2'];
        $zip_code = $_SESSION['guest']['zip_code'];
        
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
            //var_dump("Made It");
            $duplicate_email_error = "Email is already in use. Please type in your password to verify this transaction";
            header("Location: /views/users/duplicate_email.php");
            exit();
        } else {
            create_order($db, $conn);
        }
    }

    function duplicate_email($email){
        //Check if email is already in use
        $email_query = 
        "
            SELECT
                email_address
            FROM users 
            WHERE users.email_address = '$email'; 
        ";
        try {
            $email_stmt = $db->prepare($email_query);
            $email_stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("FAILED TO RUN query: ". $ex->getMessage());
        }
            
        $login_user = $email_stmt->fetch();
   
        /*
            If the email is found in database. Have the user use another email account
        */
        if($login_user == true)
        {
            //$duplicate_email_error = "Email is already in use. Please type in your password to verify this transaction";
            //header("Location: /views/users/duplicate_email.php");
            //exit();
            echo "EMAIL DUPLIACATE";
            die();
    }

    function create_user($conn, $first_name, $last_name, $email){
        $create_user_query = 
            "
                INSERT INTO users (first_name, last_name, email_address, CREATED_AT, UPDATED_AT) 
                VALUES('$first_name', '$last_name', '$email', NOW(), NOW())
            ";
        if($conn->query($create_user_query) === FALSE) {
            echo "Error: ".$create_user_query."<br>".$conn->error;
        }
    }

    function get_user($email, $db){
        $user_query = 
        "
            SELECT
                user_id
            FROM users 
            WHERE users.email_address = '$email'; 
        ";
        try {
            $user_stmt = $db->prepare($user_query);
            $user_stmt->execute();
        }
        catch(PDOException $ex)
        {
            die("FAILED TO RUN query: ". $ex->getMessage());
        }
  
        $login_user = $user_stmt->fetch();
        var_dump($login_user);
        die();

    }
     function create_order($db, $conn, $login_user_id){
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
            header("Location: /views/checkout/confirmation.php");
            exit();
            $conn->close();
        }
    }