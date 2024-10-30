<?php
session_start();
foreach($_POST as $key => $val){
    if($key=='ok') {
        if($_POST['minprix']!=null and $_POST['maxprix']!=null){
            $_SESSION['minprix']=$_POST['minprix'];
            $_SESSION['maxprix']=$_POST['maxprix'];
        }elseif($_POST['minprix']==null and $_POST['maxprix']!=null){
            $_SESSION['maxprix']=$_POST['maxprix'];
        }elseif($_POST['minprix']!=null and $_POST['maxprix']==null){
            $_SESSION['minprix']=$_POST['minprix'];
        }elseif($_POST['category_nom']!="Select an option"){
            $_SESSION['category_nom']=$_POST['category_nom'];
        }

    header('location:resultpage.php');
}}
?>