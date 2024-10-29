<?php
session_start();
foreach($_POST as $key => $val){
    if($key=='search') {
    $_SESSION['searchval']=$_POST['searchval'];
    header('location:../search/resultpage.php');
}}
?>