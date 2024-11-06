<?php
session_start();
require_once($ROOT_path."functions/functions.php");
$idc=$_SESSION['id_client'];
// Check if the form is submitted with the deleteAllBtn
if (isset($_POST['deleteAllBtn'])) {
    // Call the function to delete all items from the cart
    $pdo = conx();
    $cards = new cart(); // Create a new instance of the products class
    $result = $cards->deleteAllItemsFromCart($pdo,$idc);

    if ($result) {
        // Items successfully deleted, redirect back to the cart page
        header('Location: ../card/cart.php');
        exit();
    } else {
        // Error occurred, handle it appropriately
        echo "Failed to delete all items from cart.";
    }
} else {
    // Delete All button not clicked, handle it appropriately
    echo "Delete All button not clicked.";
}
?>
