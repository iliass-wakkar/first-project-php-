<?php

require_once($ROOT_path . 'functions/functions.php');
if (isset($_SESSION['sortBy']) and $_SESSION['sortBy'] == 'prix' and isset($_SESSION['sortprix'])) {

    $sortOrder = $_SESSION['sortprix'];
    $sortBy = $_SESSION['sortBy'];
} elseif (isset($_SESSION['sortBy']) and $_SESSION['sortBy'] == 'dateCreation' and isset($_SESSION['sortdate'])) {

    $sortOrder = $_SESSION['sortdate'];
    $sortBy = $_SESSION['sortBy'];
} else {
    $sortBy = null;
    $sortOrder = null;
}
$pdo = conx();
$products = new products();

$products = $products->fetchProducts($pdo, $sortBy, $sortOrder);

?>
<?php foreach ($products as $product): ?>

    <div class="col-5 prod_fdiv pad d-flex flex-wrap justify-content-around">
        <div class="card mb-3">
            <img src="<?php echo $ROOT_path .$product['image_url']; ?>" class="rounded-3 img_size card-img-top" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product['nom']; ?></h5>
                <span class="text-danger fs-5 fw-bolder">MAD</span>
                <span class="text-danger fs-3 fw-bolder"><?php echo $product['prix']; ?></span><br>
                <span
                    class="old-price text-muted">MAD<?php echo $product['prix'] - ($product['prix'] * $product['discount']); ?></span>
                <p class="card-text">Quantity: <?php echo $product['quantity']; ?></p>
                <form action="../productpage/productpage.php" method="get">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-dark">View Details</button>
                </form>
                <?php
                if (isset($_SESSION['admin'])) { ?>
                    <br>
                    <div class="row position-relative">
                        <form action="../editpage/editpage.php" method="post">
                            <input type="hidden" name="id_product" value="<?php echo $product['id']; ?>">
                            <button name="edit" type="submit" class="position-absolute start-2 btn btn-link text-reset">
                                <i class="fa-solid fa-pen-to-square fa-xl" style="color:blue"></i>
                            </button>
                        </form>
                        <form action="delateproduct.php" method="post">
                            <input type="hidden" name="id_product" value="<?php echo $product['id']; ?>">
                            <button name="delete" type="submit" class="position-absolute end-0 btn btn-link text-reset">
                                <i class="fa-solid fa-trash fa-xl" style="color:red"></i>
                            </button>
                        </form>
                    </div><?php } ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>