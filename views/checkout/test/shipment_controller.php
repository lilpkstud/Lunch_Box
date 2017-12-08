<?php
    require('../../connection.php');
    //var_dump($_POST);
    //var_dump($_SESSION['shopping_cart']);
    //var_dump($_SESSION['user']);
   
    if($_POST['confirmed'] === 'Buy Now SHIPMENT'){
        $current_invoice = get_invoice($db);
        insert_order($current_invoice);
    }

    /* This function will grab the last invoice number and then add 1 to set $current as the new invoice_number */
    function get_invoice($db){
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
        $previous = $order_invoice_stmt->fetch();
        $convert = (int)$previous['invoice_number'];
        $current = $convert + 1;
        return $current;
    }
    
    /* This function will insert the orders in the shopping cart*/
    function insert_order($current_invoice){
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

        /*foreach($_SESSION['shopping_cart'] as $product_id => $product):
            $user_id = $_SESSION['user']['user_id'];
            $sku = $product['product_sku'];
            $color = $product['product_color'];
            $quantity = $product['user_quantity'];
            
            $order_query = 
            "
                    INSERT INTO orders (user_id, product_sku, invoice_number, product_color, quantity, CREATED_AT, UPDATED_AT) 
                    VALUES('$user_id', $sku, '$current_invoice', '$color', $quantity, NOW(), NOW());
            ";
            
            if($conn->query($order_query) === TRUE) {
                echo "New record created";
            } else {
                echo "Error: ".$order_query."<br>".$conn->error;
            }
        endforeach;*/
        $length = count($_SESSION['shopping_cart']);
        $product = $_SESSION['shopping_cart'];

        for($index=0; $index < $length; $index++){
            $user_id = $_SESSION['user']['user_id'];
            $sku = $product[$index]['product_sku'];
            $color = $product[$index]['product_color'];
            $quantity = $product[$index]['user_quantity'];

            $order_query = 
            "
                    INSERT INTO orders (user_id, product_sku, invoice_number, product_color, quantity, CREATED_AT, UPDATED_AT) 
                    VALUES('$user_id', $sku, '$current_invoice', '$color', $quantity, NOW(), NOW());
            ";
            
            if($conn->query($order_query) === TRUE) {
                //echo "New record created";
            } else {
                echo "Error: ".$order_query."<br>".$conn->error;
            }
        }
        if($conn->query($order_query) === TRUE) {
            //unset($_SESSION['shopping_cart']);
            //unset($_SESSION['total_quantity']);
            header("Location: /views/checkout/confirmation.php");
            exit();
            $conn->close();
        }
    }

    /*
        Changing the Qunatity after each ORDER CONFIRMATION
        UPDATE `products` SET `quantity` = quantity - 1 WHERE `products`.`product_id` = 5;
    */
?>