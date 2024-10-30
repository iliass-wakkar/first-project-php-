<?php
session_start();
if(isset($_SESSION['sortdate'])and$_SESSION['sortdate']=='DESC')
$_SESSION['sortdate']='ASC';
else
$_SESSION['sortdate']='DESC';
$_SESSION['sortBy']='dateCreation';
header('location:resultpage.php')

?>