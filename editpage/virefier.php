<?php
session_start();
foreach($_POST as $key => $val){
    if($key=='add') continue;
    
    if($key=='discount'){
        
        if( $val>100){
            $_SESSION['error2'] = "Le discount n'est pas valide.";
            header('location:editepage.php');
            exit();
        }
    }
}
    

require_once('../functions/functions.php');
$conx=conx();
$product_id=$_SESSION['product_id'];
$products=new products;
$product = $products->fetchProductById($conx,$product_id);
unset($_SESSION['product_id']);
    $nom = $_POST["name"];
    $prix = $_POST["price"];
    $discount = $_POST["discount"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category_nom"]; // Assuming category_id is the name of the dropdown field
    
    if(!EMPTY($_FILES["image"]["name"]))  {  //traitement sur le fichier. Accepter les extensions dans la condition if
	 
        $nomFichier    = $_FILES["image"]["name"] ;
        $nomTemporaire = $_FILES["image"]["tmp_name"] ;
        $chemin= "../img/";
        $extension=explode('.',$nomFichier); 
                if ($extension[1] == "png" || $extension[1] == "jpg" || $extension[1] == "jpeg" || $extension[1] == "gif"|| $extension[1] == "webp"){   
                    copy($nomTemporaire, $chemin.$nomFichier);                
                }
                $image_url=$chemin.$nomFichier;
                }else
                $image_url=$product["image_url"];
                $dateCreation = date('Y-m-d H:i:s');
    $product=new products();
    $product->updateProduct($conx,$product_id,$nom,$prix,$discount,$category,$quantity,$image_url);
    header('location:../homepage/homepage.php');

?>