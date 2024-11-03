
<?php

require_once(ROOT_PATH."src/functions/functions.php");

$pdo = conx();
$products = new products();
if(isset($_SESSION['searchval'])){
    $searchval = $_SESSION['searchval'];
}
if(isset($_SESSION['minprix']) and isset($_SESSION['maxprix'])){
    $minprix=$_SESSION['minprix'];
    $maxprix=$_SESSION['maxprix'];
    unset($_SESSION['minprix']);
    unset($_SESSION['maxprix']);
}elseif(!isset($_SESSION['minprix']) and isset($_SESSION['maxprix'])){
    $maxprix=$_SESSION['maxprix'];
    $minprix=null;
    unset($_SESSION['maxprix']);
}elseif(isset($_SESSION['minprix']) and !isset($_SESSION['maxprix'])){
    $minprix=$_SESSION['minprix'];
    $maxprix=null;
    unset($_SESSION['minprix']);
}else{
    $minprix=null;
    $maxprix=null;
}
if(isset($_SESSION['category_nom'])){
    $category_nom=$_SESSION['category_nom'];
    unset($_SESSION['category_nom']);
}else{
    $category_nom=null;
}
if(isset($_SESSION['sortBy'])and$_SESSION['sortBy']=='prix'){
    if(isset($_SESSION['sortprix'])){
    $sortOrder=$_SESSION['sortprix'];
}else{
    $sortOrder=null;
}$sortBy=$_SESSION['sortBy'];
}
elseif(isset($_SESSION['sortBy'])and$_SESSION['sortBy']=='dateCreation'){
    if(isset($_SESSION['sortdate'])){
    $sortOrder=$_SESSION['sortdate'];
}else{
    $sortOrder=null;
}$sortBy=$_SESSION['sortBy'];
}else {$sortBy='prix';$sortOrder=null;}
$products = $products->searchAndSortProducts($pdo, $searchval, $category_nom ,$maxprix,$minprix, $sortBy, $sortOrder);

?>
        <?php foreach ($products as $product): ?>

            <div class="col-5 prod_fdiv pad d-flex flex-wrap justify-content-around">
            <div class="card mb-3" >
                <img src="<?php echo $product['image_url']; ?>" class="rounded-3 img_size card-img-top" alt="Product Image">
                <div class="card-body "style="padding-bottom: 50px;">
                    <h5 class="card-title"><?php echo $product['nom']; ?></h5>
                    <span class="text-danger fs-5 fw-bolder">MAD</span>
                    <span class="text-danger fs-3 fw-bolder"><?php echo $product['prix']-($product['prix']*($product['discount'])/100); ?></span><br>
                    <span class="old-price text-muted">MAD<?php echo $product['prix']; ?></span>
                    <p class="card-text">Quantity: <?php echo $product['quantity']; ?></p>
                    <form action="../productpage/productpage.php" method="get">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="btn btn-primary">View Details</button>
                    </form>
                    <?php 
                    if(isset($_SESSION['admin'])){ ?>
                        <br>
    <div class="row position-relative">
    <form action="../editpage/editpage.php" method="post">
        <input type="hidden" name="id_product" value="<?php echo $product['id']; ?>">
            <button name="edit" type="submit" class="position-absolute start-2 btn btn-link text-reset">
                <i class="fa-solid fa-pen-to-square fa-xl" style="color:blue" ></i>
            </button>
        </form> 
        <form action="delateproduct.php" method="post">
        <input type="hidden" name="id_product" value="<?php echo $product['id']; ?>">
            <button name="delete" type="submit" class="position-absolute end-0 btn btn-link text-reset">
                <i class="fa-solid fa-trash fa-xl" style="color:red" ></i>
            </button>
        </form>
    </div><?php } ?>
                </div>
            </div>
        </div>
<?php endforeach; ?>








