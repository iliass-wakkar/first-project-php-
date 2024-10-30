<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files and establish a database connection
require_once('../functions/functions.php');
$pdo = conx();

// Check if the user is logged in and get the client ID
session_start();
if (!isset($_SESSION['id_client'])) {
    // Redirect the user to the login page if not logged in
    header('Location: ../login/login.php');
    exit(); // Stop further execution
}
$clientID = $_SESSION['id_client'];

// Handle form submission when "Buy Now" is clicked
if(isset($_POST['buyNow'])) {
    // Retrieve information from the form
// Retrieve information from the form
$productId = $_POST['productId'];
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Default to 1 if quantity is not set
$date = date('Y-m-d H:i:s'); // Current date and time

    
    // Example shipping fee and saved amount
    $shippingFee = 51.14;
    $savedAmount = 1.88;
    
    // Fetch the product information
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = :productId");
    $stmt->execute(array(':productId' => $productId));
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Calculate total
    $total = ($product['prix'] * $quantity) + $shippingFee - $savedAmount;
    
    // Insert into database table commandliste
    try {
        $stmt = $pdo->prepare("INSERT INTO commandelist (id_client, id_product, quantity, total, date) VALUES (:id_client, :id_product, :quantity, :total, :date)");
        $stmt->execute(array(
            ':id_client' => $clientID,
            ':id_product' => $productId,
            ':quantity' => $quantity, // Use the retrieved quantity value
            ':total' => $total,
            ':date' => $date
        ));
        
        // Delete the product from the cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id_client = :clientID AND id_product = :productId");
        $stmt->execute(array(
            ':clientID' => $clientID,
            ':productId' => $productId
        ));
        
        // Redirect to a success page or do other actions as needed
        header('Location: success.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Now</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="mt-5 mb-3">Confirm Your Purchase</h2>
                <form action="buy_now.php" method="POST" class="buy">
    <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
    </div>
    <button type="submit" class="btn btn-primary btn-sm" name="buyNow">Buy Now</button>
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
