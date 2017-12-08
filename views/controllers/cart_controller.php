<?php
    require('../connection.php');

    //Adding an Item to the Shopping Cart
    if($_POST['add_item'] === "yes"){

        function set_cart(){
            /*
                If Shopping Cart is not created, function set_cart creates a new shopping cart AND adds the product inside the array 
            */
            if(empty($_SESSION['shopping_cart'])) {
                $_SESSION['shopping_cart'] = array();
                array_push($_SESSION['shopping_cart'], $_POST);
                header("Location: /views/checkout/shopping_cart.php");
                exit();
            } 
            else {
                foreach($_SESSION['shopping_cart'] as $item_key => $item_value):
                    /*
                        If user is adding the same product_sku && product_color  => ADD the quantity
                    */
                    if(
                        $_SESSION['shopping_cart'][$item_key]['product_sku'] === $_POST['product_sku']
                        && 
                        $_SESSION['shopping_cart'][$item_key]['product_color'] === $_POST['product_color']
                    ){
                        $current = $_SESSION['shopping_cart'][$item_key]['user_quantity'];
                        $update = $_POST['user_quantity'];
                        $new_quantity = $current + $update;
                        $_SESSION['shopping_cart'][$item_key]['user_quantity'] = $new_quantity;
                        get_cart();
                        /*header("Location: /views/checkout/shopping_cart.php");
                        exit();*/
                    }
                endforeach;
                array_push($_SESSION['shopping_cart'], $_POST);
                get_cart();
            }
    
        }

        function get_cart(){
            header("Location: /views/checkout/shopping_cart.php");
            exit();
        }
        
        set_cart();
        get_cart();
    }

    //Editing the quantity of an item from the Shopping Cart
    if(isset($_POST['edit_quantity'])){
        function edit_quantity(){
            //The $new_quantity holds the new value that the user has inputed
            $new_quantity = $_POST['new_user_quantity']; 
            
            //Updating the current user_quantity with the $new_quantity
            $_SESSION['shopping_cart'][$_POST['edit_id']]['user_quantity'] = $new_quantity;
            
        }

        function get_cart(){
            header("Location: /views/checkout/shopping_cart.php");
            exit();
        }

        edit_quantity();
        get_cart();
    }

    //Removing an Item from the Shopping Cart
    if(isset($_POST['remove_id']))
    {
        function remove_item(){
            unset($_SESSION['shopping_cart'][$_POST['remove_id']]);
            header("Location: /views/checkout/shopping_cart.php");
            exit();
        }

        remove_item();
    } 
?>
