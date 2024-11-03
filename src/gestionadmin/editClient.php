<?php
define('ROOT_PATH', __DIR__ . '/../../');
require_once(ROOT_PATH."src/functions/functions.php");
$pdo = conx();

// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login/login.php');
    exit(); // Stop further execution
}

// Retrieve client ID from the URL query parameter
if(isset($_GET['id'])) {
    $clientID = $_GET['id'];
} else {
    // Redirect if no client ID is provided
    header('Location: gestion.php');
    exit(); // Stop further execution
}

// Fetch client information from the database
$stmt = $pdo->prepare("SELECT * FROM client WHERE id = :clientID");
$stmt->execute(array(':clientID' => $clientID));
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission to update client information
if(isset($_POST['updateClient'])) {
    // Retrieve information from the form
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    
    // Update client information in the database
    $stmt = $pdo->prepare("UPDATE client SET nom = :nom, prenom = :prenom, tel = :tel, login_email = :email WHERE id = :clientID");
    $stmt->execute(array(
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':tel' => $tel,
        ':email' => $email,
        ':clientID' => $clientID
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
    <title>Edit Client</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mt-5 mb-3">Edit Client Information</h2>
                <form action="editclient.php?id=<?php echo $clientID; ?>" method="POST">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($client['nom']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom:</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($client['prenom']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="tel">Telephone:</label>
                        <input type="text" class="form-control" id="tel" name="tel" value="<?php echo htmlspecialchars($client['tel']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($client['login_email']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" name="updateClient">Update</button>
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
