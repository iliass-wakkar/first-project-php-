<?php
session_start();
// Include necessary files and establish a database connection
require_once('../functions/functions.php');
$command=new command;
$cart=new cart;
$id_client=$_SESSION['id_client'];
$pdo = conx();
$ids=$_POST['productId'];
$quntity=$_POST['productq'];
$prix=$_POST['productp'];
$date=$_POST['productd'];
$dates=explode('/',$date);
$products_id=explode(' ',$ids);
$quantitys=explode(' ',$quntity);
$prixs=explode(' ',$prix);
for($i=0;$i<count($products_id);$i++){
    $id_product=$products_id[$i];
    $quantity=$quantitys[$i];
    $prix=$prixs[$i];
    $date=$dates[$i];
    $total=intval($quantity)*intval($prix);
    $command->insertToCommand($pdo, $id_client, $id_product, $quantity, $total);
    $cart->deleteProductFromCart($pdo,$id_client, $date);
}
    header('location:cart.php');


?>