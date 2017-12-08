<?php
    require('../connection.php');
    if($_POST['confirmed'] == "Buy Now2")
    {
        //If user is not saved = ASK IF THEY WANT THEIR INFORMATION TO BE SAVED
        
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
        /*
            User has logged in 
        */
        if(isset($_SESSION['user'])) {
        
            foreach($_SESSION['shopping_cart'] as $product_id => $product):
                $user_id = $_SESSION['user']['user_id'];
                $sku = $product['product_sku'];
                $color = $product['product_color'];
                $quantity = $product['user_quantity'];
                
                $order_query = 
                "
                        INSERT INTO orders (user_id, product_sku, product_color, quantity, CREATED_AT, UPDATED_AT) 
                        VALUES('$user_id', $sku, '$color', $quantity, NOW(), NOW());
                ";

                if($conn->query($order_query) === TRUE) {
                    //echo "New record created";
                } else {
                    echo "Error: ".$order_query."<br>".$conn->error;
                }

            endforeach;
            if($conn->query($order_query) === TRUE) {
                unset($_SESSION['shopping_cart']);
                unset($_SESSION['total_quantity']);
                header("Location: /");
                exit();
                $conn->close();
            }
        }
    }
?>
       