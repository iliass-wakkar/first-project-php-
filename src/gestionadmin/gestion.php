

<!DOCTYPE html>
<html lang="en">
<?php
$ROOT_pathinclude_once($ROOT_path."head/head.php") ?>
<?php
// Include necessary files and establish a database connection
require_once($ROOT_path."functions/functions.php");
$pdo = conx();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    // Redirect the user to the login page if not logged in as admin
    header('Location: ../login/login.php');
    exit(); // Stop further execution
}

// Retrieve data from the clients table
$stmt = $pdo->query("SELECT * FROM client");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
    <?php require_once($ROOT_path."nav/nav.php");
 ?>
    <div class="container">
        <h2 class="mt-5 mb-3">Client Management</h2>
        <a href="add_client.php" class="mb-3 btn btn-success">Add New Client</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo $client['id']; ?></td>
                        <td><?php echo $client['nom']; ?></td>
                        <td><?php echo $client['prenom']; ?></td>
                        <td><?php echo $client['tel']; ?></td>
                        <td><?php echo $client['login_email']; ?></td>
                        <td><?php echo $client['login_password']; ?></td>
                        <td>
                            <a href="editclient.php?id=<?php echo $client['id']; ?>" class=""><i class="fa-xl fa-solid fa-pen-to-square"></i></a>
                            
                            <form action="delete.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
                                <button name="delete" type="submit" class="btn btn-link text-reset">
                                   <i class="fa-solid fa-trash fa-xl" style="color:red" ></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
