<?php
    require('../connection.php');
    $connection = connection_query();

    //var_dump($_SESSION);
    //var_dump($_POST);
    //die();
    //var_dump($_POST['update_user']);

    /*
        User is already logged in. Send the user to SHIPPING.PHP to verify that their information is up to date.
    */
    if(isset($_SESSION['user'])){
        /*
            User clicked $_POST['update_user'] from SHIPPING.PHP to update their shipping information. Update their information by the $_POST information, grab the user info again, and send them BACK to SHIPPING.PHP to verify that their info is now correct.
        */
        if($_POST['update_user'] === 'Update'){
            update_information($connection);
            get_information($db);
            header("Location: /views/checkout/shipping.php");
            exit();
        }
        /*
            User clicked $_POST['verified'] from SHIPPING.PHP. User has verified that their shipping information is correct. Send user to BILLING.PHP
        */ 
        if($_POST['verified'] === 'Verified'){
             header("Location: /views/checkout/billing.php");
            exit();
        }
        /*
            User clicked $_POST['confirmed'] from REVIEW.PHP to execute their order. Insert their order to the database, _______, send them to CONFIRMATION.PHP
        */
        if($_POST['confirmed'] === "Buy Now"){
            update_quantity($connection, $db);
            $next_invoice = get_invoice($db);
            insert_order($connection, $next_invoice);
            header("Location: /views/checkout/confirmation.php");
            exit();
        }
        /*
            User has confirmed that they reviewed the order they sent. The product name, price, quantity is exactly the same. Unset $_SESSION['shopping_cart'] and $_SESSION['total_quantity'] and send them back to index.php.

            ALSO SEND AN ORDER/PAYMENT/SHIPPING CONFIRMATION AS WELL!!!!!
        */
        if($_POST['order_confirmation'] === 'confirmed'){
            unset($_SESSION['shopping_cart']);
            unset($_SESSION['total_quantity']);
            header("Location: /");
            exit();
        }
        else {
            header("Location: /views/checkout/shipping.php");
            exit();
        }
    }
    /*
        User is logging in as a GUEST from SHIPPING.PHP. Save their $_POST info as $_SESSION['guest']
    */
    if($_POST['guest_shipping'] === 'Submit'){
        $_SESSION['guest'] = $_POST;
        unset($_SESSION['guest']['guest_shipping']);
        header("Location: /views/checkout/billing.php");
        exit();
    }
    else {
        //var_dump("User is NOT logged in. Direct user to login OR sign in as a guest");
        header("Location: /views/users/login.php");
        exit();
    }

    
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

    /* 
        This function will grab the last invoice number and then add 1 to set $current as the new invoice_number
    */
    function get_invoice($db){
        $order_invoice_query = " 
            SELECT 
                MAX(invoice_number) AS invoice_number
            FROM orders
        ";
        try 
        {  
            $order_invoice_stmt = $db->prepare($order_invoice_query); 
            $order_invoice_stmt->execute();
        }
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        }
        $previous = $order_invoice_stmt->fetch();
        $convert = (int)$previous['invoice_number'];
        $current = $convert + 1;
        return $current;
    }

    /* 
        This function will insert the orders in the shopping cart
    */
    function insert_order($connection, $next_invoice){
        //Checking connection
        if($connection->connect_error){
            die("Connection failed: ".$connection->connect_error);
        }
        foreach($_SESSION['shopping_cart'] as $product):
            $user_id = $_SESSION['user']['user_id'];
            $sku = $product['product_sku'];
            $color = $product['product_color'];
            $quantity = $product['user_quantity'];

            $order_query = 
            "
                INSERT INTO orders (user_id, product_sku, invoice_number, product_color, quantity, CREATED_AT, UPDATED_AT) VALUES('$user_id', $sku, '$next_invoice', '$color', $quantity, NOW(), NOW());
            ";

            if($connection->query($order_query) === FALSE){
                echo "Error: ".$order_query."<br>".$connection->error;
            }
        endforeach;
        $connection->close();
    }

    /*
        This function will update the product's total quantity from the user's quantity of the shopping cart
    */
    function update_quantity($connection, $db)
    {
        foreach($_SESSION['shopping_cart'] as $product):
            //GRAB THE QUANTITY FROM THE DATABASE FIRST AND THEN update the quantity
            
            $sku = $product['product_sku'];
            $color = $product['product_color'];
            $user_quantity = $product['user_quantity'];

            $product_quantity_query = 
            "
                SELECT products.sku, products.color, products.quantity FROM products WHERE products.sku = '$sku' AND products.color = '$color '
            ";
            
            try
            {
                $get_product_quantity = $db->prepare($product_quantity_query);
                $get_product_quantity->execute();
            }
            catch(PDOException $ex)
            {
                die("DIDNT WORK");
            }

            $current_quantity = $get_product_quantity->fetch();
            
            if($current_quantity['sku'] === $sku && $current_quantity['color'] === $color){
                $update_quantity = $current_quantity['quantity'] - $user_quantity;

                //echo "<br> This Product's SKU: ".$current_quantity['sku']." has this much products (".$current_quantity['quantity']."). User wants to buy ".$user_quantity." The new quantity will now be ".$update_quantity;
            }
                $updated_quantity_stmt = 
                "
                    UPDATE products SET quantity = '$update_quantity', UPDATED_AT = NOW() WHERE products.sku = '$sku' AND products.color = '$color';
                ";
                
                if($connection->query($updated_quantity_stmt) === FALSE){
                    echo "Error updating record: ".$connection->error;
                }
        endforeach;
        
    }
?>