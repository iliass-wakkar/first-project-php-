<?php
define('ROOT_PATH', __DIR__ . '/../../');
require_once(ROOT_PATH."src/functions/functions.php");
$pdo = conx();

// Check if the user is logged in and get the client ID
session_start();
// Check if the user is an admin
if (!isset($_SESSION['admin'])) {
    // Redirect to home page or access denied page
    header('Location: ../login/login.php');
    exit(); // Stop further execution
}

// Retrieve client ID from the URL query parameter
if(isset($_POST['id'])) {
    $clientID = $_POST['id'];
} else {
    // Redirect if no client ID is provided
    header('Location: gestion.php');
    exit(); // Stop further execution
}

// Delete client from the database
$stmt = $pdo->prepare("DELETE FROM client WHERE id = :clientID");
$stmt->execute(array(':clientID' => $clientID));

// Redirect to a success page or back to the client list
header('Location: gestion.php');
exit();
?>
