
<!DOCTYPE html>
<html lang="en">
<?php include_once("../head/head.php") ?>
<body>
    <header>
    <?php
require_once("../nav/nav.php");
?>
<fieldset class="border rounded-3 border-2 border-gray p-2 my-4 mx-auto bg-light"style="width: 33.33%" >
        <legend class="w-auto fs-2">add Product</legend>
        <form action="virefier.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3">
        <label for="discount" class="form-label">Discount:</label>
        <input type="number" class="form-control" id="discount" name="discount" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity:</label>
        <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="form-control-file" id="image" name="image" required>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category:</label>
        <select class="form-select" id="category_nom" name="category_nom" required>
            <?php
            require_once("../functions/functions.php");
            // Connect to the database to fetch categories (replace database credentials with your own)
            $pdo = conx();
            $cat = new category();
            $result = $cat->fetch_name($pdo);
            foreach ($result as $row) {
                echo "<option value=" . $row["nom"] . ">" . $row["nom"] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3 d-grid gap-2 mx-3">
        <button type="submit" name="add" value="add" class="btn btn-outline-primary btn-lg">add</button>
    </div>
</form>

    </fieldset>



</body>

</html>