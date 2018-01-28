<?php
    require('../connection.php');
    
    //var_dump($_POST);

    /* ADMIN is updating the quantity of a specific product */
    if(isset($_POST['refill_quantity']) && $_POST['refill_quantity'] > 0){
        $refill_id = $_POST['product_id'];
        $refill_quantity = $_POST['refill_quantity'];
        
            
        $refill_update_query = " 
            UPDATE products
            SET 
                products.quantity = $refill_quantity,
                products.UPDATED_AT = NOW()
                
            WHERE 
                products.product_id = $refill_id
        ";
        try
        {
            $stmt = $db->prepare($refill_update_query);
            $stmt->execute();
            header("Location: ../admin/admin_dashboard.php");
            exit();
        } 
        catch(PDOExpection $ex)
        {
            die("Failed to run query: ". $ex->getMessage());
        }
    }

    /* ADMIN is confiming that they have sent the product to the user*/
    if(isset($_POST['confirm_shipment']) && $_POST['confirm_shipment'] == "Confirmed"){
        $order_id = $_POST['order_id'];
        
        $shipment_confirmation_query = "
            UPDATE orders
            SET
                orders.shipped = 'YES',
                orders.UPDATED_AT = NOW()
            WHERE
                orders.order_id = $order_id

        ";
        try
        {
            $stmt = $db->prepare($shipment_confirmation_query);
            $stmt->execute();
            header("Location: ../admin/admin_dashboard.php");
            exit();
        }
        catch(PDOExpection $ex)
        {
            die("FAILED to run query: ".$ex->getMessage());
        }
    

    }
?>