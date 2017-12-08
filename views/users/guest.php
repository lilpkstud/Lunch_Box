<?php
    /*
        This file is only called when:
            1. User is signed-in as a guest
            2. Guest has clicked YES/NO from the Review.php
    */
    require('../connection.php');
    $conn = connection_query();
    $first_name = $_SESSION['guest']['first_name'];
    $last_name = $_SESSION['guest']['last_name'];
    $email = $_SESSION['guest']['email'];
    $address1 = $_SESSION['guest']['address1'];
    $address2 = $_SESSION['guest']['address2'];
    $zip_code = $_SESSION['guest']['zip_code'];

    if($_GET['save'] === 'yes'){
        find_user($db, $email);
        $user = create_user($db, $conn, $first_name, $last_name, $email, $address1, $address2, $zip_code);
        create_order($db, $conn, $user);
    }

    /*
        User doesnt want to save their information in our database. Just create the order and direct the user to confirmation.php
    */
    if($_GET['save'] === 'no'){

        find_user($db, $email);
        $user = create_guest_user($db, $conn, $first_name, $last_name, $email, $address1, $address2, $zip_code);
        create_order($db, $conn, $user);

    }

    function find_user($db, $email){
       
        //Check if email is already in use
        $duplicate_query = 
        " 
            SELECT 
                user_id
            FROM users
            WHERE users.email_address = '$email'
        ";
        try {
            $duplicate_stmt = $db->prepare($duplicate_query);
            $duplicate_stmt->execute();
        }
        catch(PDOException $ex) {
            die("FAILED TO RUN QUERY: ". $ex->getMessage());
        }

        $duplicate_email = $duplicate_stmt->fetch();

        /*
            If the email is found in the database, have the user use another email account
        */
        if($duplicate_email == true){
            $duplicate_email_error = "Email is already in use. Please type in your password to verify this transaction";
            var_dump("Email found");
            die();
        } 
    }

    /* This function will create the user IF the guest clicked YES */
    function create_user($db, $conn, $first_name, $last_name, $email, $address1, $address2, $zip_code) {
        $create_user_query = 
        "
            INSERT INTO users (first_name, last_name, email_address, address1, address2, zip_code, CREATED_AT, UPDATED_AT)
            VALUES ('$first_name', '$last_name', '$email', '$address1', '$address2', '$zip_code', NOW(), NOW())
        ";
        if($conn->query($create_user_query) === FALSE) {
            echo "Error: ".$create_user_query."<br>".$conn->error;
        }

        /*
            Once the user is created return the user_id for the create_order function
        */
        $select_user_query = 
        "
            SELECT user_id
            FROM users
            WHERE users.email_address = '$email'
        ";
        try {
            $select_user_stmt = $db->prepare($select_user_query);
            $select_user_stmt->execute();
        }
        catch(PDOException $ex) {
            die("FAILED TO RUN QUERY: ". $ex->getMessage());
        }

        return $select_user_stmt->fetch();
    }

    /* This function will create the user IF the guest clicked NO */
    function create_guest_user($db, $conn, $first_name, $last_name, $email, $address1, $address2, $zip_code) {
        $create_user_query = 
        "
            INSERT INTO users (guest, first_name, last_name, email_address, address1, address2, zip_code, CREATED_AT, UPDATED_AT)
            VALUES ('yes', '$first_name', '$last_name', '$email', '$address1', '$address2', '$zip_code', NOW(), NOW())
        ";
        if($conn->query($create_user_query) === FALSE) {
            echo "Error: ".$create_user_query."<br>".$conn->error;
        }

        /*
            Once the user is created return the user_id for the create_order function
        */
        $select_user_query = 
        "
            SELECT user_id
            FROM users
            WHERE users.email_address = '$email'
        ";
        try {
            $select_user_stmt = $db->prepare($select_user_query);
            $select_user_stmt->execute();
        }
        catch(PDOException $ex) {
            die("FAILED TO RUN QUERY: ". $ex->getMessage());
        }

        return $select_user_stmt->fetch();
    }

    function create_order($db, $conn, $user){
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
            $user_id = $user['user_id'];
            $sku = $product['product_sku'];
            $color = $product['product_color'];
            $quantity = $product['user_quantity'];
            
            $order_query = 
            "
                    INSERT INTO orders (user_id, product_sku, invoice_number, product_color, quantity, CREATED_AT, UPDATED_AT) 
                    VALUES('$user_id', $sku, '$current', '$color', $quantity, NOW(), NOW());
            ";
            if($conn->query($order_query) === FALSE) {
                echo "Error: ".$order_query."<br>".$conn->error;
            } 
        endforeach;
        
        if($conn->query($order_query) === TRUE) {
            header("Location: /views/checkout/confirmation.php");
            exit();
            $conn->close();
        }
    }

    function new_quantity(){
        //Grab the last invoice and subtract the small_quantity from the invoice quantity
    }

   
?>