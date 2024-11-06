<?php
session_start();
$ROOT_path = '../';
require_once($ROOT_path."functions/functions.php");
$pdo=conx();
$id_product=$_SESSION['id_product'];
$quantity=$_POST['quantity'];
$total=$_SESSION['product_prix']*$quantity;
$cart=new cart;
if(isset($_SESSION['id_client'])){
$id_client=$_SESSION['id_client'];
$count=$cart->count_cart($pdo, $id_client);
$_SESSION["cart"] = "<a href='../card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
<span class='small'>".$count."</span></span></i></a>";
  $res=$cart ->insertToCart($pdo, $id_client, $id_product, $quantity, $total);}
  elseif(isset($_SESSION['nbcart'])){
    $_SESSION['cart_products'].=$id_product.' ';
  $_SESSION['cart_products_quantity'].=$quantity.' ';
  $_SESSION['cart_products_date'].=date('Y-m-d H:i:s').'/';
    $_SESSION['nbcart']++;
  }
  else{$_SESSION['nbcart']=1;
  $_SESSION['cart_products'].=$id_product.' ';
  $_SESSION['cart_products_quantity'].=$quantity.' ';
  $_SESSION['cart_products_date'].=date('Y-m-d H:i:s').' ';
  }
header('location:productpage.php');

?>