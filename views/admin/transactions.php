<?php
    require('../connection.php');
    
    $invoice_number = $_GET['invoice_number'];
    $user_id = $_GET['user_id'];

    //This query will grab ALL information about the product by the product_sku AND product_color.
    $invoice_query = " 
        SELECT 
            orders.user_id, orders.invoice_number, orders.product_sku, orders.product_color, orders.quantity as user_quantity, orders.CREATED_AT, orders.UPDATED_AT as orders_updated, orders.shipped, 
            users.user_id, users.first_name, users.last_name, users.email_address, users.address1, users.address2, users.city, users.state, users.zip_code, users.UPDATED_AT as users_updated,
            products.product_name, products.quantity as product_quantity, products.UPDATED_AT as products_updated
        FROM orders 
        JOIN users ON orders.user_id = users.user_id
        JOIN products ON orders.product_sku = products.sku
        WHERE orders.invoice_number = $invoice_number;
    ";
    try 
    { 
        // These two statements run the query against your database table. 
        $invoice_stmt = $db->prepare($invoice_query); 
        $invoice_stmt->execute();
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    }
    // Finally, we can retrieve the row into an array using fetch to get ONE row.
    $invoice_info = $invoice_stmt->fetchAll();  
    var_dump($invoice_info);
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
    <h1>Invoice # <?=$invoice_number?></h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Email Address</th>
            <th>Shipping Address</th>
            <th>Product SKU</th>
            <th>Product Name</th>
            <th>Product Color</th>
            <th>User Quantity</th>
            <th>Product Overall Quantity</th>
            <th>Shipped?</th>
        </tr>
        <?php foreach($invoice_info as $info): ?>
        <tr>
            <td><?=$info['first_name'].' '.$info['last_name']?></td>
            <td><?=$info['email_address']?></td>
            <td>
                <?=
                    $info['address1'].'<br>'.
                    $info['address2'].'<br>'.
                    $info['city'].','.
                    $info['state'].' '.
                    $info['zip_code']
                ?>
            </td>
            <td><?=$info['product_sku']?></td>
            <td><?=$info['product_name']?></td>
            <td><?=$info['product_color']?></td>
            <td><?=$info['user_quantity']?></td>
            <td><?=$info['product_quantity']?></td>
            <td>
                <form action="../admin/admin_controller.php" method="post">
                    <input type="hidden" name="order_id" value =<?=$info['order_id']?>>
                    <input type="submit" name="confirm_shipment" value ="Confirmed">
                </form>
            </td>
        </tr>

        <?php endforeach?>
</body>
</html>
