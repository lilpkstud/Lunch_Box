<?php
    require('../connection.php');
    /*
        1. Check if the order is correct and show the invoice to show that it is completed

        2. Create an Email Confirmation

    */

    //var_dump("MADE IT TO THE CONFIRMATION PAGE!");
    /*
        unset($_SESSION['shopping_cart']);
            unset($_SESSION['total_quantity']);
            header("Location: /");
            exit();
    */

    //var_dump($_SESSION['guest']);
    //var_dump($_SESSION['shopping_cart']);

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
    <h2>Order Confirmation</h2>
    <p>Thank you for ordering with us <?=$_SESSION['guest']['first_name']?>! We will send an email confirming your shipment. </p>

    <h3>Product Order</h3>
    <?php
        $grand_total = 0;

        foreach($_SESSION['shopping_cart'] as $order):
        $total_price = $order['product_price'] * $order['user_quantity'];
    ?>
        <p>Product: <?=$order['product_name']?> </p>
        <p>Total Price: $<?=$order['product_price']?> x <?=$order['user_quantity']?> = $<?=$total_price?></p>
    <?php
        $grand_total += $total_price;
        endforeach;
    ?>
    <h4>Grand Total = $<?=$grand_total?></h4>
    <form action="/views/controllers/checkout_controller.php" method="post">
        <input type="hidden" name="order_confirmation" value="confirmed">
        <input type="submit" name="Submit" value="Confirm">
    </form>
</body>
</html>
<?php
    /* THIS STATEMENT DOESNT WORK FIX IT*/
    if($_POST['Submit'] == "Confirm"){
        unset($_SESSION['guest']);
        unset($_SESSION['shopping_cart']);
        unset($_SESSION['total_quantity']);
        //Why doesnt the header work????
        header("Location: /");
        exit();
        
       
    }
?>