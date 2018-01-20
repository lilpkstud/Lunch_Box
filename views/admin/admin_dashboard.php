<?php
    require('../connection.php');
    /*
        1. Allow Admin to show Not completed shipments

        2. Grab all orders

        3. UPDATE orders AND UPDATE QUANTITY
        3A. SHOW QUANTITY OF ALL PRODUCTS
        4. Show users
    */
    
    /*
        Grabbing the quantity of all products
    */
    $products_query = "
        SELECT
           products.product_id, products.sku, products.product_name, products.price, products.quantity   
        FROM products
    ";

    /*
        Grabbing all orders and the user 
    */
    /*$orders_query = "
        SELECT 
            orders.order_id, orders.user_id as order_user_id, orders.invoice_number, orders.product_sku, orders.product_color, orders.quantity, orders.CREATED_AT, orders.UPDATED_AT, orders.shipped,
            users.user_id, users.first_name, users.last_name, users.email_address, users.address1, users.address2,users.city, users.state, users.zip_code, users.UPDATED_AT
         FROM orders JOIN users ON users.user_id = orders.user_id
    ";*/
    try
    {
        $products_stmt = $db->prepare($products_query);
        $products_stmt->execute();

        //$orders_stmt = $db->prepare($orders_query);
        //$orders_stmt->execute();
    }
    catch(PDOExpection $ex)
    {
        die("Failed to run query: ". $ex->getMessage());
    }
    
    $product_rows = $products_stmt->fetchAll();
    //$order_rows = $orders_stmt->fetchAll();
    //echo "Product_Rows: ";
    //var_dump($product_rows);
    //die();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lunch Box Socks</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
    <!-- Bootstrap JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> 
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
    <div class="container">
        <a href="/views/test/email_confirmation.php">Email Confirmation</a>

        <h1>ADMIN DASHBOARD </h1>
        <h3>All Products Table</h3>
        <table>
            <tr>
                <th>Product SKU</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Small Quantity</th>
            </tr>
            <?php foreach($product_rows as $product): ?>
                <tr>
                    <td><?=$product['sku']?></td>
                    <td><?=$product['product_name']?></td>
                    <td>$<?=$product['price']?></td>
                    <?php
                        if($product['quantity'] <= 10){
                    ?>
                            <td>
                                <div class="alert alert-danger" role="alert">
                                    Low in Stock!!! <br> 
                                    Current Quantity: <?=$product['quantity']?>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                        <input type="hidden" name="product_id" value="<?=$product['product_id']?>">
                                        <input type='text' name='refill_quantity'>
                                        <input type='submit' value = 'New Quantity'>
                                    </form>
                                </div>
                            </td>
                    <?php
                        } else {
                    ?>
                        <td>
                            <div class="alert alert-info" role="alert">
                                Current Quantity: <?= $product['quantity']?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method ="post">
                                    <input type="hidden" name="product_id" value="<?=$product['product_id']?>">
                                    <input type='text' name='refill_quantity'>
                                    <input type='submit' value = 'New Quantity'>
                                </form>
                            </div>
                        </td>
                    <?php
                        }
                    ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
<?php
    if(isset($_POST['refill_quantity'])) {
       $refill_id = $_POST['product_id'];
       $refill_quantity = $_POST['refill_quantity'];
       
       $refill_update_query = " UPDATE products
            SET 
                products.quantity = $refill_quantity
                
            WHERE 
                products.product_id = $refill_id
        ";
        try
        {
            $stmt = $db->prepare($refill_update_query);
            $stmt->execute();
            echo "Query has been executed";
            /* Query works fine but Admin_dashboard.php doesnt refresh the new quantity */
        } 
        catch(PDOExpection $ex)
        {
            die("Failed to run query: ". $ex->getMessage());
        }
    }
   
?>
</html>