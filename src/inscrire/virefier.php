<?php
session_start();
foreach($_POST as $key => $val){
    if($key=='inscrire') continue;

}
require_once($ROOT_path."functions/functions.php");
$conx=conx();
$email=$_POST['email'];
$password=$_POST['password'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$tel=$_POST['tel'];
$type='Client';
$client= new client();
$user=new User();


        $res=$user->insrt_login($conx,$email,$password,$type);
        if(!$res['message']){
            $_SESSION['error2'] = "Cette adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
        header('location:inscrirepage.php');
        exit();
        }else{
            $stmt= $client->insrt_client($conx,$nom,$prenom,$tel,$email,$password);
            $res=$stmt->fetch(PDO::FETCH_ASSOC);
            if(!$res['message']){
                $_SESSION['error2'] = "Une erreur s'est produite lors de la création du compte. Veuillez réessayer.";
                header('location:inscrirepage.php');
                exit();            
            }else{
                header('location:../login/login.php');
            }
        }
        

?>