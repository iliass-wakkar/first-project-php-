<?php
session_start();
foreach($_POST as $key => $val){
    if($key=='login') continue;}
    require_once($ROOT_path . "functions/functions.php");
    $conx=conx();
$email=$_POST['email'];
$password=$_POST['password'];
$user=new User();
$client=new Client();
$cart=new Cart();
$res=$user->fullLoginCount($conx,$email,$password);
if($res['message']==0){
    $_SESSION['error2'] = "email or mot de pass est faux";
    header('location:login.php');
    exit();
}elseif($res['message']==1){
    $res=$user->fullLogin($conx,$email,$password);
    if($res['user_type']=='Client'){
        $cl=$client->getByEmail($conx,$email);
        $count=$cart->count_cart($conx, $cl['id']);
        $_SESSION['id_client']=$cl['id'];
        $_SESSION['client'] = "<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>bonjour ".$cl['nom']."</a>";
        if(isset($_SESSION['nbcart'])){
        for($i=0;$i<$_SESSION['nbcart'];$i++){
            $id_client=$_SESSION['id_client'];
            $prod_id=explode(" ",$_SESSION['cart_products']);
            $product_id[$i]=intval($prod_id[$i]);
            $quantity=explode(" ",$_SESSION['cart_products_quantity']);                                    
            $date=explode(" ",$_SESSION['cart_products_date']);
            $products=new products;
            $product=$products->getProductDetails($conx,$prod_id);
            $total=intval($quantity[$i])*intval($product['prix']);
            $cart->insertToCart($conx, $id_client, $product_id[$i], $quantity[$i], $total);
        }}unset($_SESSION['cart_products']);
        unset($_SESSION['cart_products_quantity']);
        unset($_SESSION['cart_products_date']);
        $count=$cart->count_cart($conx, $_SESSION['id_client']);
        $_SESSION["cart"] = "<a href='../card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
<span class='small'>".$count."</span></span></i></a>";
        header('location:../homepage/index.php');
        exit();}
    if($res['user_type']=='Admin'){
        $admin=new Admin();
        $command=new command;
        $ad1=$admin->getByEmail($conx,$email);
        $_SESSION['id_admin']=$ad1['id'];
        $nbc=$command->count_commandelist($conx);
        $_SESSION["commandlist"] = "<a href='../commandlist/commandlist.php'><i class='fa-solid fa-basket-shopping'><span class='badge bg-danger rounded-circle'>
<span class='small'>".$nbc."</span></span></i></a>";
        $_SESSION['admin'] = "<a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>bonjour ".$ad1['nom']."</a>";
        header('location:../homepage/index.php');
        exit();
    }

}else{
    $_SESSION['error2'] = "something wrong !";
    header('location:login.php');
    exit();
}

?>