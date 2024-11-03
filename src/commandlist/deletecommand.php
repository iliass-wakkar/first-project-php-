<?php
session_start();
define('ROOT_PATH', __DIR__ . '/../../');

require_once(ROOT_PATH."src/functions/functions.php");

if (isset($_POST['date'])AND isset($_POST['id_client'])) {
    $pdo = conx();
    $date = $_POST['date'];
    $id_client=$_POST['id_client'];
    $cart = new command();
    
    // Call the function to delete the product from the cart
    $result = $cart->deleteCommandFromCart($pdo,$id_client, $date);

    if ($result) {
        // Product successfully deleted, redirect back to the cart page
        header('Location: ../commandlist/commandlist.php');
        exit();
    } else {
        // Error occurred, handle it appropriately
        echo "Failed to delete product from cart.";
        header('Location: ../commandlist/commandlist.php');
        exit();
    }
} else {
    // Product ID not provided, handle it appropriately
    echo "Product ID not provided.";
    header('Location: ../commandlist/commandlist.php');
    exit();
}
?>
