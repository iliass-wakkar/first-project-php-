<?php
session_start();
if(isset($_POST['id_product'])){
    require_once('../functions/functions.php');
$pdo=conx();
$product=new products();
$product_id=$_POST['id_product'];
$res=$product->deleteProduct($pdo,$product_id);
header('location:index.php');
}


?>