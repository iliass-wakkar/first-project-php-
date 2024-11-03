<?php
foreach($_POST as $key => $val){
    if($key=='add') continue;
    if($key=='discount'){
       
       if( $val>100){
            $_SESSION['error2'] = "Le discount n'est pas valide.";
            header('location:addproduct.php');
            exit();
        }
    }
    
}
require_once(ROOT_PATH."src/functions/functions.php");
$conx=conx();
    $nom = $_POST["name"];
    $prix = $_POST["price"];
    $discount = $_POST["discount"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category_nom"]; // Assuming category_id is the name of the dropdown field
    
    if(!EMPTY($_FILES["image"]["name"]))  {  //traitement sur le fichier. Accepter les extensions dans la condition if
	 
        $nomFichier    = $_FILES["image"]["name"] ;
        $nomTemporaire = $_FILES["image"]["tmp_name"] ;
        $chemin = "../img/" ;
        $extension=explode('.',$nomFichier); 
                if ($extension[1] == "png" || $extension[1] == "jpg" || $extension[1] == "jpeg" || $extension[1] == "gif"|| $extension[1] == "webp"){   
                    copy($nomTemporaire, $chemin.$nomFichier);                
                }
                
                $image_url=$chemin.$nomFichier;
                }
                
                $dateCreation = date('Y-m-d H:i:s');
    $product=new products();
    $product->insrt_product($conx,$nom,$prix,$discount,$category,$dateCreation,$quantity,$image_url);
    header('location:../homepage/index.php');

?>