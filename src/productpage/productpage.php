<?php $ROOT_path = '../';
require_once($ROOT_path . 'head/head.php');

require_once($ROOT_path . "functions/functions.php");

$pdo = conx();
if (isset($_GET['product_id']))
    $product_id = $_GET['product_id'];
elseif (isset($_SESSION['id_product'])) {
    $product_id = $_SESSION['id_product'];
    unset($_SESSION['id_product']);
} else
    $product_id = null;

if (!$product_id) {
    // Handle the case where no product ID is provided, redirect or show an error message
    header('location:../homepage/index.php');
}
$products = new products;
$cart = new cart;
$product = $products->fetchProductById($pdo, $product_id);
$_SESSION['id_product'] = $product["id"];
$_SESSION['product_prix'] = $product["prix"];
;

// Placeholder reviews
$reviews = [
    ["review" => 'Great product, highly recommended!'],
    ["review" => 'Good quality and fast shipping.'],
    ["review" => 'I love it!'],
];
?>

<body class="">
    <!-- Header section, including navigation, etc. -->
    <?php include('../nav/nav.php'); ?>
    <div class="shadow border border-secondary-subtle border-2 bg-white container">
        <div class=" center-div shadow row row-cols-1 row-cols-md-3">
            <div class="my-6 col  g-4" style="width: 50%;">
                <img src="<?php echo $ROOT_path .htmlspecialchars($product["image_url"]); ?>" class="img-fluid" style="width: 100%;"
                    alt="Product Image">
            </div>



            <div class="position-relative my-6 col  g-4" style="width: 50%;">

                <?php

                if (isset($_SESSION['admin'])) { ?>
                    <br>
                    <div class="row position-relative">
                        <div class="row position-absolute end-0" style="width:10%">
                            <form action="../editpage/editpage.php" method="post">
                                <input type="hidden" name="id_product" value="<?php echo $product['id']; ?>">
                                <button name="edit" type="submit" class="btn btn-link text-reset">
                                    <i class="fa-solid fa-pen-to-square fa-xl" style="color:blue"></i>
                                </button>
                            </form>
                            <form action="delateproduct.php" method="post">
                                <input type="hidden" name="id_product" value="<?php echo $product['id']; ?>">
                                <button name="delete" type="submit" class="btn btn-link text-reset">
                                    <i class="fa-solid fa-trash fa-xl" style="color:red"></i>
                                </button>
                            </form>

                        </div>


                    </div><?php } ?>
                <form id="productForm" method="post">
                    <div class="col-md-6">
                        <span class="text-danger fs-3 fw-bolder">MAD</span>
                        <span class="text-danger fs-1 fw-bolder"><?php echo $product["prix"]; ?></span><br>
                        <span
                            class="old-price text-muted">MAD<?php echo $product["prix"] - ($product["prix"] * $product["discount"]); ?></span>
                        <h2><?php echo $product["nom"]; ?></h2>
                        <!-- Display product quantity here -->
                        <p>Quantity:
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" id="minusBtn">
                                    <i class="fa-solid fa-circle-minus fa-2xl"></i>
                                </button>
                            </span>
                            <input name="quantity" type="number" class="border border-3 rounded-4 "
                                style="width: 40px; text-align: center;" value="1" id="quantityInput">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" id="plusBtn">
                                    <i class="fa-solid fa-circle-plus fa-2xl"></i>

                                </button>
                            </span>
                        </div><br>
                        <a href="" class="fw-bold"><?php echo $product["category"]; ?></a><br><br>

                        </p>

                        <!--  Button -->
                        <button class="btn btn-primary" id="addToCartBtn" type="button">Add to Cart</button>
                        <!-- Reviews Section -->
                        <button id="buyNowBtn" type="button" class="btn btn-dark">Buy Now</button>

                    </div>
                </form><br>

            </div>






        </div>
        <div class=" align-items-center">
            <hr class="flex-grow-1">
        </div>
        <div class=" mt-4">
            <h3>Reviews</h3>
            <?php foreach ($reviews as $review): ?>
                <div class="card mb-2">
                    <div class="card-body">
                        <!-- Display review content -->
                        <p class="card-text"><?php echo htmlspecialchars($review["review"]); ?></p>
                        <!-- Display star rating (assuming it's always 5 stars) -->
                        <div class="review-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star filled"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        document.getElementById('quantityInput').addEventListener('input', function () {
            let input = document.getElementById('quantityInput');
            let value = parseInt(input.value, 10);
            let maxQuantity = <?php echo $product["quantity"]; ?>;
            if (value > maxQuantity) {
                input.value = maxQuantity;
            }
        });
        document.getElementById('plusBtn').addEventListener('click', function () {
            let input = document.getElementById('quantityInput');
            let value = parseInt(input.value, 10);
            let maxQuantity = <?php echo $product["quantity"]; ?>;
            if (value < maxQuantity) {
                input.value = value + 1;
            }
        });

        document.getElementById('minusBtn').addEventListener('click', function () {
            let input = document.getElementById('quantityInput');
            let value = parseInt(input.value, 10);
            if (value > 1) {
                input.value = value - 1;
            }
        });
        const productForm = document.getElementById('productForm');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const buyNowBtn = document.getElementById('buyNowBtn');

        // Add click event listeners to the buttons
        addToCartBtn.addEventListener('click', function () {
            // Update the action attribute of the form
            productForm.action = 'addtocart.php';
            // Submit the form
            productForm.submit();
        });

        buyNowBtn.addEventListener('click', function () {
            // Update the action attribute of the form
            productForm.action = 'addtocommandlist.php';
            // Submit the form
            productForm.submit();
        });
    </script>

    <!-- Include necessary JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>