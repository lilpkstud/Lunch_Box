<?php
   require('../connection.php');

    /*
        Grabbing the order and the user from the Invoice ID 
    */
    $orders_query = "
        SELECT 
            orders.order_id, orders.user_id as order_user_id, orders.invoice_number, orders.product_sku, orders.product_color, orders.quantity, orders.CREATED_AT, orders.UPDATED_AT, orders.shipped,
            users.user_id, users.first_name, users.last_name, users.email_address, users.address1, users.address2, users.zip_code, users.UPDATED_AT
         FROM orders JOIN users ON users.user_id = orders.user_id WHERE orders.invoice_number = ". $_GET['id']
    ;
    try 
    { 
        // These two statements run the query against your database table. 
        $orders_stmt = $db->prepare($orders_query); 
        $orders_stmt->execute();
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    }

    $invoice = $orders_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <style>
        th{
            margin: 5px;
            padding:0px 10px;
        }
        td{
            margin: 5px;
            padding:0px 10px;
        }
    </style>
</head>
<body>
    <a href="/views/admin/admin_dashboard.php"> Admin Home</a>
    <?php

        if(count($invoice) == 1)
        {
          $info = $invoice[0];
    ?>
        <h2>Invoice # <?=$info['invoice_number']?></h2>
        <h4>Customer Information</h4>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Address1</th>
                <th>Address2</th>
                <th>Zipcode</th>
            </tr>
            <tr>
                <td><?=$info['first_name']?></td>
                <td><?=$info['last_name']?></td>
                <td><?=$info['email_address']?></td>
                <td><?=$info['address1']?></td>
                <td><?=$info['address2']?></td>
                <td><?=$info['zip_code']?></td>
            </tr>    
        </table>
        <br>
        <h4>Order Information</h4>
        <table>
            <tr>
                <th>Product SKU</th>
                <th>Product Color</th>
                <th>Quantity</th>
                <th>Shipment Confirmation</th>
            </tr>
            <tr>
                <td><?=$info['product_sku']?></td>
                <td><?=$info['product_color']?></td>
                <td><?=$info['quantity']?></td>
                <td><?=$info['shipped']?></td>
                <td>
                    <form action="/views/admin/test.php" method="post">
                        <input type="hidden" name="order_id" value="<?=$info['order_id']?>">
                        <input type="submit" name="Confirm Shipment" value="Confirm Shipment">
                    </form>
                </td>
            </tr>
        </table>
    <?php
        } else {
            $customer = $invoice[0];
    ?>
            <h2>Invoice # <?=$info['invoice_number']?></h2>
            <h4>Customer Information</h4>
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Address1</th>
                    <th>Address2</th>
                    <th>Zipcode</th>
                </tr>
                <tr>
                    <td><?=$customer['first_name']?></td>
                    <td><?=$customer['last_name']?></td>
                    <td><?=$customer['email_address']?></td>
                    <td><?=$customer['address1']?></td>
                    <td><?=$customer['address2']?></td>
                    <td><?=$customer['zip_code']?></td>
                </tr>    
            </table>
            <br>
            <h4>Order Information</h4>
            <table>
                <tr>
                    <th>Product SKU</th>
                    <th>Product Color</th>
                    <th>Quantity</th>
                    <th>Shipment Confirmation</th>
                </tr>
                <?php foreach($invoice as $order): ?>
                    <tr>
                        <td><?=$order['product_sku']?></td>
                        <td><?=$order['product_color']?></td>
                        <td><?=$order['quantity']?></td>
                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                <input type="hidden" name="order_id" value="<?=$order['order_id']?>">
                                <input type="submit" name="Confirm Shipment" value="Confirm Shipment">
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
    <?php    
        }
    ?>
</body>
</html>