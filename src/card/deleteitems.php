<?php
session_start();
require_once($ROOT_path."functions/functions.php");

if (isset($_POST['date']) and isset($_SESSION['id_client'])) {
    $pdo = conx();
    $date = $_POST['date'];
    $cart = new cart();
    $id_client=$_SESSION['id_client'];

        $count=$cart->count_cart($pdo,$id_client);
    // Call the function to delete the product from the cart
    $result = $cart->deleteProductFromCart($pdo,$id_client,$date);

    if ($result) {
        // Product successfully deleted, redirect back to the cart page

        $_SESSION['cart']="<a href='../card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
        <span class='small'>".$count."</span></span></i></a>";
        header('Location: ../card/cart.php');

        exit();
    } else {
        // Error occurred, handle it appropriately
        echo "Failed to delete product from cart.";
        $_SESSION['cart']="<a href='../card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
        <span class='small'>".$count."</span></span></i></a>";
        header('Location: ../card/cart.php');

        exit();
    }
} elseif(isset($_SESSION['nbcart'])) {
    // Product ID not provided, handle it appropriately
    echo "Product ID not provided.";
    $_SESSION['cart']="<a href='../card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
        <span class='small'>".$count."</span></span></i></a>";
    header('Location: ../card/cart.php');
    exit();
}
?>
