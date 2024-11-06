<!DOCTYPE html>
<html lang="fr">
<?php
$ROOT_path = '../';
include_once($ROOT_path."head/head.php");
 ?>
<body>
<?php
require_once($ROOT_path."nav/nav.php");
?>
    <fieldset class="border border-2 border-gray p-2 my-4 mx-auto bg-light"style="width: 33.33%" >
        <legend class="w-auto fs-2">Créer un compte</legend>
        <form action="virefier.php" method="post" >
        <div class="mb-3">
        <label  class="form-label">nom :</label>
        <input type="text" name="nom" class="form-control" placeholder="nom" required>
        </div>
        <div class="mb-3">
        <label  class="form-label">prenom :</label>
        <input type="text" name="prenom" class="form-control" placeholder="prenom" required>
        </div>
        <div class="mb-3">
        <label  class="form-label">telephone :</label>
        <input type="number" name="tel"  class="form-control" placeholder="telephone" required>
        </div>
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address :</label>
        <input type="email" name="email" class="form-control" placeholder="Email address" required>
        <?php 
        if(isset($_SESSION['error2'])){

            echo '<div  class="form-text text-danger">'.$_SESSION['error2'];
            unset($_SESSION['error2']);
        }else{
            echo'        <div class="form-text">Nous ne partagerons jamais votre adresse e-mail avec qui que ce soit. ';
                }
        ?></div>
        </div>
        <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">mot de passe :</label>
        <input type="password" name="password" class="form-control" placeholder="mot de passe"required>
        <div  class="form-text">Nous ne partagerons jamais votre mot de passe avec qui que ce soit.</div>
        </div>
        <div class="mb-3 d-grid gap-2 mx-3" >
            <button type="submit" name="inscrire" value="inscrire" class="btn btn-outline-success btn-lg">Créer un compte</button>
        </div>
        <div><p class="form-text ">Vous possédez déjà un compte ? <a href="../login/login.php">Identifiez-vous</a></p></div>
        </form>
    </fieldset>
    
</body>
</html>