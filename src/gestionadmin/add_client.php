<?php
define('ROOT_PATH', __DIR__ . '/../../');
require_once(ROOT_PATH."src/functions/functions.php");
$pdo = conx();

// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['admin'])) {
    // Redirect to home page or access denied page
    header('Location: ../homepage/index.php');
    exit(); // Stop further execution
}

// Handle form submission to add a new client
if(isset($_POST['addClient'])) {
    // Retrieve information from the form
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Assuming password is also submitted
    
    // Insert new client into the database
    $stmt = $pdo->prepare("INSERT INTO client (nom, prenom, tel, login_email, login_password) VALUES (:nom, :prenom, :tel, :email, :password)");
    $stmt->execute(array(
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':tel' => $tel,
        ':email' => $email,
        ':password' => $password // Remember to hash the password for security in a real-world scenario
    ));
    
    // Redirect to a success page or back to the client list
    header('Location: gestion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Client</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mt-5 mb-3">Add New Client</h2>
                <form action="add_client.php" method="POST">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom:</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">Telephone:</label>
                        <input type="text" class="form-control" id="tel" name="tel" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addClient">Add Client</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
