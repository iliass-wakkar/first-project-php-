<?php
session_start();
require_once(ROOT_PATH."src/functions/functions.php");
$pdo=conx();
$id_client=$_SESSION['id_client'];
$id_product=$_SESSION['id_product'];
$quantity=$_POST['quantity'];
$total=$_SESSION['product_prix']*$quantity;
$cart=new command;
  $res=$cart ->insertToCommand($pdo, $id_client, $id_product, $quantity, $total);

header('location:productpage.php');

?>