
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="position: fixed; top: 0; width: 100%; z-index: 1000;" >
  <div class="container-fluid">
    <a class="navbar-brand" href="/first-project-php-/src/index.php">php projet</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/first-project-php-/src/index.php">Accueil</a>
        </li>
        <?php 
    if(isset($_SESSION['client'])){
        echo '<li class="nav-item dropdown">'.
        $_SESSION['client'].
        '<ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/first-project-php-/src/login/let.php">singout</a></li>
      </ul></li>';
    } elseif(isset($_SESSION['admin'])){
        echo '<li class="nav-item dropdown">'.
        $_SESSION['admin'].
        '<ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/first-project-php-/src/login/let.php">singout</a></li>
      </ul></li>';
      //------------------------------------------
      echo "<li class='nav-item'>
          <a class='nav-link' href='/first-project-php-/src/gestionadmin/gestion.php'>Gestion Clients</a>
        </li>";
      

    } else {
        echo '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  S\'identifier/inscription
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/first-project-php-/src/login/login.php">S\'identifier</a></li>
                  <li><a class="dropdown-item" href="/first-project-php-/src/inscrire/inscrirepage.php">Inscription</a></li>
                </ul>
              </li>';
    }
?>


        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">À propos de nous</a>
        </li>
        <form method="post" action="/first-project-php-/src/verifiersearch/verifiersearch.php" class="px-4 d-flex" role="search">
        <input name="searchval" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button name="search" class="btn btn-outline-success" type="submit">Search</button>
      </form>
      </ul><?php require_once(ROOT_PATH.'src/functions/functions.php');
      $cart=new cart;
        
      if(isset($_SESSION['admin'])){
        echo $_SESSION["commandlist"];
      }
      elseif(isset($_SESSION['client'])){
      if(isset($_SESSION['cart'])){
        $pdo = conx();
        $count=$cart->count_cart($pdo, $_SESSION['id_client']);
      
        $_SESSION["cart"] = "<a href='/first-project-php-/src/card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
<span class='small'>".$count."</span></span></i></a>";
        echo $_SESSION['cart'];}
    } elseif(isset($_SESSION['nbcart'])) {
        echo "<a href='/first-project-php-/src/card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
        <span class='small'>".$_SESSION['nbcart']."</span></span></i></a>";
    }else
    echo "<a href='/first-project-php-/src/card/cart.php'><i class='px-3 fa-solid fa-cart-shopping'><span class='badge bg-danger rounded-circle'>
        <span class='small'>0</span></span></i></a>";
        
       ?>
      
      
    </div>
  </div>
</nav>
<br>
<br>
<br>