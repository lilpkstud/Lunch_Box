<?php
    /*
        1. Grab the user's email_address
        2. Grab the user's shopping cart/products
        3. ORDER Confirmation and state that the user will receive a shipping confirmatino after the payment has been processed
    */
    $recipient = "paul.s.kwon24@gmail.com";
    $subject = "Lunch Box Socks Order Confirmation";
    $sender = "Paul";
    $senderEmail = "paul.s.kwon92@gmail.com";
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
    <?php $message = 
    "
        <h2> Order Confirmation </h2>
        <p> Thank you for ordering with use Paul! We will send an email confirming your shipment once your payment have been processed. </p>
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity x Price</th>
                <th>Subtotal</th>
            </tr>
            <tr>
                <td>Product 1</td>
                <td>4 x $11.99</td>
                <td>$100</td>
            </tr>
        </table> 
        <p> Grand Total: $100000 </p>
    ";
    
    $mailBody="Name: $sender\nEmail:
    $senderEmail\n\n$message";

    mail($recipient, $subject, $mailBody, "From: $sender <$senderEamil>");
    ?>
</body>
</html>