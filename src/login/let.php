<?php 
session_start();
 unset($_SESSION['id_client']);
 unset($_SESSION['client']);
 unset($_SESSION["cart"]);
 unset($_SESSION['nbcart']);
 unset($_SESSION['admin']);
 unset($_SESSION['cart_products']);
 unset($_SESSION['cart_products_quantity']);
 unset($_SESSION['cart_products_date']);
 header('location:'.$ROOT_path.'/index.php')
?>