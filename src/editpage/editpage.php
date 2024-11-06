
<!DOCTYPE html>
<html lang="en">
<?php $ROOT_path = '../';

include_once($ROOT_path."head/head.php") ?>
<body>
<?php
require_once($ROOT_path."nav/nav.php");
require_once($ROOT_path . "functions/functions.php");
$product_id=$_POST['id_product'];
$pdo = conx();
$products = new products();
$product = $products->fetchProductById($pdo,$product_id);
$_SESSION['product_id']=$product_id;
?>
<fieldset class="border rounded-3 border-2 border-gray p-2 my-4 mx-auto bg-light"style="width: 33.33%" >
        <legend class="w-auto fs-2">Edit Product</legend>
        <form  action="virefier.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" value="<?php echo $product['nom']; ?>" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" class="form-control" id="price" value="<?php echo $product['prix']; ?>" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount:</label>
                            <input type="number" class="form-control" value="<?php echo $product['discount']; ?>" id="discount" name="discount">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" value="<?php echo $product['quantity']; ?>" name="quantity">
                        </div>
                        <div class="form-group">
                            <label for="image" class="form-label">Image:</label>
                            <input type="file" class="form-control-file" id="image" value="<?php echo $product['image_url']; ?>" name="image">
                        </div>
                        <div class="mb-3">
    <label for="category_id" class="form-label">Category:</label>
    <select class="form-select" id="category_nom" name="category_nom">
        <?php
        // Fetch all categories
        $cat = new category();
        $result = $cat->fetch_name($pdo);

        // Display the current category initially
        echo "<option value='" . htmlspecialchars($product['category']) . "' selected>" . htmlspecialchars($product['category']) . "</option>";

        // Display other categories in the dropdown
        foreach ($result as $row) {
            if ($row["nom"] !== $product['category']) {
                echo "<option value='" . htmlspecialchars($row["nom"]) . "'>" . htmlspecialchars($row["nom"]) . "</option>";
            }
        }
        ?>
    </select>
</div>

        <div class="mb-3 d-grid gap-2 mx-3" >
            <button type="submit" name="edite" value="edite" class="btn btn-outline-primary btn-lg">edit</button>
        </div>
        </form>
    </fieldset>

</body>

</html>