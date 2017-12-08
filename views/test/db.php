<?php 

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

        foreach($_SESSION['shopping_cart'] as $product):
            $order_query = "
                    INSERT INTO orders (product_sku, product_color, quantity) 
                    VALUES(" .$product['product_sku'].", 'Testing_Black' ,". $product['user_quantity']."     )
            ";
            if($conn->query($order_query) === TRUE) {
                echo "New record created";
            }
            else {
                echo "Error: ".$order_query."<br>".$conn->error;
            }

        endforeach;

        $conn->close();