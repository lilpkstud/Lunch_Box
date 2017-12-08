<?php
    require('../connection.php');
  
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

    $shipment_query = "UPDATE orders SET shipped = \"Yes\" WHERE 'orders.order_id' = ". $_POST['order_id'];
    
    if ($conn->query($shipment_query) === TRUE) {
        echo "Record updated successfully";
        //header("Location: /");
        //exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
    
    
    
    
    /*try 
    { 
        // These two statements run the query against your database table. 
        $shipment_stmt = $db->prepare($shipment_query); 
        $shipment_stmt->execute();
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    }
     //$invoice = $shipment_stmt->fetchAll();
     //var_dump($invoice);*/
?>