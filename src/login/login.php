<!DOCTYPE html>
<html lang="fr">
<?php
define('ROOT_PATH', __DIR__ . '/../../');
 include_once(ROOT_PATH."src/head/head.php") ?>

<body>
<?php
require_once(ROOT_PATH."src/nav/nav.php");
?>
    <div class="my-4 mx-auto div_size" style="width: 33.33%" >
    <fieldset class="border border-2 border-gray p-2 my-4 mx-auto bg-light" >
        <legend class="w-auto fs-1">S'identifier</legend>
        <form action="virefier.php" method="post" >
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address :</label>
        <input type="email" name="email" class="form-control" placeholder="Email address" required>
        
        </div>
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">mot de passe :</label>
        <input type="password" name="password" class="form-control" placeholder="mot de passe"required>
        <div  class="form-text text-danger"><?php 
        if(isset($_SESSION['error2'])){
            echo $_SESSION['error2'];
            unset($_SESSION['error2']);
        }else{
            print(' ');
        }
        ?></div>
        <br>
        <div class="mb-3 d-grid gap-2 mx-3" >
            <button type="submit" name="login" value="login" class="btn btn-outline-success btn-lg">connexion</button>

        </div>
        </form>
    </fieldset>
    <div class="d-flex align-items-center">
        <hr class="flex-grow-1">
        <span class="form-text fs-6 mx-2">nouveau chez nous ?</span>
        <hr class="flex-grow-1">
    </div>
    <br>        <a class="text-decoration-none" href="../inscrire/inscrirepage.php"><div class="mb-3 d-grid gap-2 shadow border border-black border-opacity-50 rounded-2">
    <button type="button" class="btn btn-light"  >Créer nouveau compte</button>

    </div></a>

    
    </div>
    
    
</body>
</html>