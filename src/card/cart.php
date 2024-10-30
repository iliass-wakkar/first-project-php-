<!DOCTYPE html>
<html lang="en">
<?php require_once('../head/head.php') ?>
<body style='background-color: #ebebeb' >
    <?php require_once('../nav/nav.php')?>
    <?php

// Include necessary files and establish a database connection
require_once('../functions/functions.php');
$pdo = conx();
$cart=new cart;

if(isset($_SESSION['id_client'])){
$clientID = $_SESSION['id_client'];
$products =$cart->fetchClientProducts($pdo, $clientID);
}else $products=null;
// Define the fetchProducts() function to retrieve products chosen by the client


// Fetch products chosen by the client

// Example subtotal calculation
$subTotal = 0;

// Example shipping fee and saved amount
$shipping = 0;
$savedAmount = 0;

// Calculate total
$total = $subTotal + $shipping - $savedAmount;
?>
    <div class="container">
        <!-- Title and Select All button -->
        <div class="row mb-3">
            <div class="col-8" style='background-color: #ebebeb'>
                <h1 class="mb-0" >Shopping Cart (<?php
                if(isset($_SESSION['id_client']) AND isset($_SESSION['nbcart'])){
                    $nbc=$cart->count_cart($pdo,$clientID);
                    echo $nbc;
                    $nbcart=$_SESSION['nbcart'];
                    unset($_SESSION['nbcart']);
                    }
                elseif(isset($_SESSION['id_client'])){
                $nbc=$cart->count_cart($pdo,$clientID);
                echo $nbc;}elseif(isset($_SESSION['nbcart'])){ $nbcart=$_SESSION['nbcart'];echo $nbcart;}else$nbcart=0;
                 ?>)</h1>
                
            </div>
            <div class="col-auto d-flex align-items-center">
                <?php if(isset($_SESSION['id_client'])){ ?>
                <form id="deleteAllForm" action="deleteallitems.php" method="POST">
                    <button type="submit" id="deleteAllBtn" class="btn btn-sm btn-danger" name="deleteAllBtn">Delete All Items</button>
                </form><?php }?>
            </div>
        </div>
        <!-- Cards with products -->
        <div class="row">
            <div class="col ">
                <!-- Product cards -->
                
                    <div class="product cardd bg-white rounded-2 p-3 " style="width: 950px; overflow-x: auto" >
                        <div  class=" mx-3  form-check d-flex justify-content-right align-items-center">
                                    <input id="selectAllBtn" type="checkbox" class="border border-secondary-subtle form-check-input productCheck">
                                    <label class="mx-3" for="text">Select all items</label>
                                </div>
                        <div class="card-body">
                            <?php if(isset($_SESSION['id_client'])AND isset($_SESSION['cart_products'])){
                                
                                foreach ($products as $product): ?>
                            <div class="cardd">
                            <input id="hinput" type="hidden" name="productId" value="<?php echo $product['prod_quantity']; ?>">
                            <div class="row  border-top py-3 d-flex justify-content-center align-items-center">
                            <div class="position-relative" >
                                    <form action="deleteitems.php" method="POST" class="delete-form">
                                        <input class="datep" type="hidden" name="date" value="<?php echo $product['date']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0" name="deleteProductBtn" style="background-color: transparent; border: none;">
                                        <i class="fa-regular fa-trash-can fa-lg" style="color: #ff0000;"></i></button>                                   
                                    </form>
                                    </div>
                                <div class="col-md-1 form-check d-flex justify-content-center align-items-center">
                                    <input type="checkbox" name="selectedProducts[]" value="<?php echo $product['prod_id']; ?>" class="border border-secondary-subtle form-check-input productCheckbox">
                                </div>
                                <div class="col ml-0">
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="img-fluid rounded-3">
                                </div>
                                
                                <div class="row col-md-8 d-flex justify-content-center align-items-center">
                                    
                                    <div class="col-12" >
                                    <h5 class="col-12 card-title"><?php echo htmlspecialchars($product['nom']); ?></h5>
                                    </div>
                                    
                                    <div class="col">
                                    <p class="card-text">Price: US $<?php echo number_format($product['prix'], 2); ?></p>
                                    </div>
                                    <div class="col-5" >
                                <form action="addtocart.php" method="POST"> <!-- Form to add to cart -->
                                        <div class="input-group quantityContainer">
                                        <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="maxQuantity" value="<?php echo $product['prod_quantity']; ?>"> 
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default minusBtn" >
                                                    <i class="fa-solid fa-circle-minus fa-2xl"></i>
                                                </button>
                                            </span>
                                            <input class="total" type="hidden" name="total" value="<?php echo $product['prix']; ?>">
                                            <input name="quantity" type="number" class="border border-3 rounded-4 quantityInput" style="width: 40px; text-align: center;" value="<?php echo $product['cart_quantity']; ?>" >
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default plusBtn" >
                                                    <i class="fa-solid fa-circle-plus fa-2xl"></i>
                                                </button>
                                            </span>
                                            <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                        </div>
                                        <br>
                                    </form>
                                </div>
                                    
                                </div>
                                
                            </div>      </div>          <?php endforeach; }
                             else if(isset($_SESSION['id_client'])){
                                foreach ($products as $product): 
                        
                            $quantity = isset($product['cart_quantity']) ? $product['cart_quantity'] : 0;?>
                            <div class="cardd">
                            <input id="hinput" type="hidden" name="productId" value="<?php echo $product['prod_quantity']; ?>">
                            <div class="row  border-top py-3 d-flex justify-content-center align-items-center">
                            <div class="position-relative" >
                                    <form action="deleteitems.php" method="POST" class="delete-form">
                                        <input class="datep" type="hidden" name="date" value="<?php echo $product['date']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0" name="deleteProductBtn" style="background-color: transparent; border: none;">
                                        <i class="fa-regular fa-trash-can fa-lg" style="color: #ff0000;"></i></button>                                   
                                    </form>
                                    </div>
                                <div class="col-md-1 form-check d-flex justify-content-center align-items-center">
                                    <input type="checkbox" name="selectedProducts[]" value="<?php echo $product['prod_id']; ?>" class="border border-secondary-subtle form-check-input productCheckbox">
                                </div>
                                <div class="col ml-0">
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="img-fluid rounded-3">
                                </div>
                                
                                <div class="row col-md-8 d-flex justify-content-center align-items-center">
                                    
                                    <div class="col-12" >
                                    <h5 class="col-12 card-title"><?php echo htmlspecialchars($product['nom']); ?></h5>
                                    </div>
                                    
                                    <div class="col">
                                    <p class="card-text">Price: US $<?php echo number_format($product['prix'], 2); ?></p>
                                    </div>
                                    <div class="col-5" >
                                <form action="addtocart.php" method="POST"> <!-- Form to add to cart -->
                                        <div class="input-group quantityContainer">
                                        <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="maxQuantity" value="<?php echo $product['prod_quantity']; ?>"> 
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default minusBtn" >
                                                    <i class="fa-solid fa-circle-minus fa-2xl"></i>
                                                </button>
                                            </span>
                                            
                                            <input class="total" type="hidden" name="total" value="<?php echo $product['prix']; ?>">
                                            <input  name="quantity" type="number" class="quantityval border border-3 rounded-4 quantityInput" style="width: 40px; text-align: center;" value="<?php echo $product['cart_quantity']; ?>" >
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default plusBtn" >
                                                    <i class="fa-solid fa-circle-plus fa-2xl"></i>
                                                </button>
                                            </span>
                                            <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                        </div>
                                        <br>
                                    </form>
                                </div>
                                    
                                </div>
                                
                            </div>      </div>          <?php endforeach; }else{
                                for($i=0;$i<$nbcart;$i++){
                                    $prod_id=explode(" ",$_SESSION['cart_products']);
                                    $product_id[$i]=intval($prod_id[$i]);
                                    $quantity=explode(" ",$_SESSION['cart_products_quantity']);                                    
                                    $date=explode("/",$_SESSION['cart_products_date']);
                                    $products=new products;
                                    $product=$products->getProductById($pdo,$product_id[$i]);
                                    $total=intval($product['prix']);
                                    ?>
                                    <div class="cardd">
                                    <input id="hinput" type="hidden" name="productId" value="<?php echo $product['quantity']; ?>">
                                    <div class="row  border-top py-3 d-flex justify-content-center align-items-center">
                                    <div class="position-relative" >
                                            <form action="deleteitems.php" method="POST" class="delete-form">
                                                <input class="datep" type="hidden" name="date" value="<?php echo $date[$i]; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm position-absolute top-0 end-0" name="deleteProductBtn" style="background-color: transparent; border: none;">
                                                <i class="fa-regular fa-trash-can fa-lg" style="color: #ff0000;"></i></button>                                   
                                            </form>
                                            </div>
                                        <div class="col-md-1 form-check d-flex justify-content-center align-items-center">
                                            <input type="checkbox" name="selectedProducts[]" value="<?php echo $prod_id[$i]; ?>" class="border border-secondary-subtle form-check-input productCheckbox">
                                        </div>
                                        <div class="col ml-0">
                                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="img-fluid rounded-3">
                                        </div>
                                        
                                        <div class="row col-md-8 d-flex justify-content-center align-items-center">
                                            
                                            <div class="col-12" >
                                            <h5 class="col-12 card-title"><?php echo htmlspecialchars($product['nom']); ?></h5>
                                            </div>
                                            
                                            <div class="col">
                                            <p class="card-text">Price: US $<?php echo number_format($product['prix'], 2); ?></p>
                                            </div>
                                            <div class="col-5" >
                                        <form action="addtocart.php" method="POST"> <!-- Form to add to cart -->
                                                <div class="input-group quantityContainer">
                                                <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                                <input type="hidden" name="maxQuantity" value="<?php echo $product['quantity']; ?>"> 
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default minusBtn">
                                                            <i class="fa-solid fa-circle-minus fa-2xl"></i>
                                                        </button>
                                                    </span>
                                                    <input class="total" type="hidden" name="total" value="<?php echo $total; ?>">
                                                    <input name="quantity" type="number" class="border border-3 rounded-4 quantityInput"  style="width: 40px; text-align: center;" value="<?php echo $quantity[$i]; ?>">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default plusBtn">
                                                            <i class="fa-solid fa-circle-plus fa-2xl"></i>
                                                        </button>
                                                    </span>
                                                    <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                                </div>
                                                <br>
                                            </form>
                                        </div>
                                            
                                        </div>
                                        
                                    </div>          </div>      <?php };
                            } ?>

                        </div>
                    </div>
            </div>
            <!-- Summary -->
            <!-- Summary -->
<div class="col" >
    <div style="overflow-x: auto; width: 320px;" class="card">
        <div  class=" card-body my-3" id="summary">
            <div>
            <h5 class=" card-title fw-bold fs-3">Summary</h5>
            </div>
            <div class="row " >
                <p class="col-6 card-text">Subtotal: </p>
                <span class="col-6" id="subTotal"><?php echo number_format($subTotal, 2); ?> DH</span>

            </div>
            <div class="row position-relative" >
            <p class="col-6 card-text">Shipping: </p>
            <span class="col-6" id="subTotal"><?php echo number_format($shipping, 2); ?> DH</span>
            </div>
            <div class="row border-bottom position-relative" >
            <p class="col-6 card-text">Saved: </p>
            <span class="col-6" id="subTotal">-<?php echo number_format($savedAmount, 2); ?> DH</span>
            </div>
            <div class="mb-2  row position-relative" >
            <p  class="fw-bold col-6 card-text">Total: </p>
            <span id="total" class="fw-bold  col-6" id="subTotal"><?php echo number_format($total, 2); ?> DH</span>
            </div>
            <?php if(isset($_SESSION['id_client'])){ ?>
            <form id="buyNowForm" action="buynow.php" method="POST">
            <input id="selectedProductsInputq" type="hidden" name="productq" value="">
            <input id="selectedProductsInputp" type="hidden" name="productp" value="">
            <input id="selectedProductsInputd" type="hidden" name="productd" value="">

    <!-- Include hidden input fields for selected products -->
    <input id="selectedProductsInput" type="hidden" name="productId" value="">
    <!-- Buy Now button -->
    <button id="buyNowBtn" type="button" class="btn btn-primary btn-block" name="buyNow">Buy Now</button>
</form><?php }?>
        </div>
    </div>
</div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
       
       document.querySelectorAll('.quantityInput').forEach(function(input) {
    input.addEventListener('input', function() {
        let value = parseInt(input.value, 10);
        let maxQuantityInput = input.parentElement.querySelector('[name="maxQuantity"]');
        let maxQuantity = maxQuantityInput.value;
        console.log(maxQuantity);
        if (value > maxQuantity) {
            input.value = maxQuantity;
        }
    });
});

document.querySelectorAll('.plusBtn').forEach(function(button) {
    button.addEventListener('click', function() {
        let input = button.closest('.quantityContainer').querySelector('.quantityInput');
        let value = parseInt(input.value, 10);  
        let maxQuantityInput = input.parentElement.querySelector('[name="maxQuantity"]');
        let maxQuantity = maxQuantityInput.value;
        if (value < maxQuantity) {
            input.value = value + 1;
            updateTotal();
        }
    });
});

document.querySelectorAll('.minusBtn').forEach(function(button) {
    button.addEventListener('click', function() {
        let input = button.closest('.quantityContainer').querySelector('.quantityInput');
        let value = parseInt(input.value, 10);
        if (value > 1) {
            input.value = value - 1;
            updateTotal();
        }
    });
});
       
       document.querySelector('.productCheck').addEventListener('change', function(event) {

// Select all checkbox inputs
var checkboxes = document.querySelectorAll('.productCheckbox');
if (event.target.checked) {
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = true;
      
    });
} else {
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
      
    });
}
});
        


        document.querySelector('.productCheck').addEventListener('change', updateTotal);
        
        document.querySelectorAll('.productCheckbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateTotal);
        });

        document.querySelectorAll('.quantityInput').forEach(function(input) {
            input.addEventListener('change', updateTotal);
        });

        function updateTotal() {
            var total = 0;
            var subtotal = 0;
            var checkb = document.getElementById('selectAllBtn');
            var checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkb.checked){
            checkedCheckboxes.forEach(function(checkbox) {
                var card = checkbox.closest('.cardd');
                var prix = parseFloat(card.querySelector('.total').value);
                var quan = parseFloat(card.querySelector('.quantityInput').value);
                subtotal += quan * prix;
            
            });
            prix=parseFloat(checkedCheckboxes[0].closest('.cardd').querySelector('.total').value);
            quan=parseFloat(checkedCheckboxes[0].closest('.cardd').querySelector('.quantityInput').value);
            subtotal-=quan * prix;}else if(!checkb.checked){
                checkedCheckboxes.forEach(function(checkbox) {
                
                var card = checkbox.closest('.cardd');
                var prix = parseFloat(card.querySelector('.total').value);
                var quan = parseFloat(card.querySelector('.quantityInput').value);
                subtotal += quan * prix;
            
            });
            }
            var shipping=parseFloat(<?php echo $shipping; ?>);
            var savedAmount=parseFloat(<?php echo $savedAmount; ?>)
            total = subtotal + shipping - savedAmount;
            document.getElementById('subTotal').innerText = subtotal.toFixed(2)+' DH';
            document.getElementById('total').innerText = total.toFixed(2)+' DH';
        }
        // Find the Buy Now button
        document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buyNowBtn').addEventListener('click', function() {
        // Collect IDs of selected products
        var selectedIds='';
        var quantity='';
        var prix='';
        var date='';
        var checkboxes = document.querySelectorAll('.productCheckbox:checked');
        checkboxes.forEach(function(checkbox) {
            var card=checkbox.closest('.cardd');
            quantity = quantity+card.querySelector('.quantityInput').value+' ';
            prix =prix+card.querySelector('.total').value+' ';
            date =date+card.querySelector('.datep').value+'/';
            selectedIds =selectedIds+checkbox.value + ' ';
        })
        
        // Set selected IDs as value of hidden input field
        document.getElementById('selectedProductsInput').value = selectedIds;
        document.getElementById('selectedProductsInputq').value = quantity;
        document.getElementById('selectedProductsInputp').value = prix;
        document.getElementById('selectedProductsInputd').value = date;

        // Submit the form
        document.getElementById('buyNowForm').submit();
    });
});


    </script>
    <!-- Custom JS -->
</body>
</html>
