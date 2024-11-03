<!DOCTYPE html>
<html lang="en">
<?php define('ROOT_PATH', __DIR__ . '/../../');
include_once(ROOT_PATH."src/head/head.php") ?>
<body>
    <header>
    <?php
require_once(ROOT_PATH."src/nav/nav.php");
?>
    </header>
    
    
      <div class="shadow row " >

        
      <div class=" col  shadow border border-secondary-subtle border-2 " >
          <form class="" method="post" action="verifiersort.php">        

          <div class="border-bottom border-secondary-subtle  prod_div container py-2 text-right" >
            <div class="row" >
              <label class="fs-4 fw-bold form-label" >prix :</label>
                <input type="text" name="minprix" placeholder="Max"  class="col border w-50 border-secondary-subtle form-control">
                <span class=" col-2 fs-3 " >-</span>
                <input type="text" name="maxprix" placeholder="Min" class=" col border w-50 border-secondary-subtle form-control">
                <button name="ok" type="submit" class="mb-1 btn mt-3 btn-dark">OK</button>
            </div>
                
        </div>
        <div class="border-bottom border-secondary-subtle  prod_div container py-2 text-right" >
          <div class="row" >
            <label class="fs-4 fw-bold form-label" >category :</label>
                <select class="form-select" id="category_nom" name="category_nom">
                <option value="Select an option"> Select an option</option>
                                    <?php
                                    require_once(ROOT_PATH . "src/functions/functions.php");
                                    // Connect to the database to fetch categories (replace database credentials with your own)
                                    $pdo =conx();
                                    $cat=new category();
                                    $result=$cat->fetch_name($pdo);
                                    foreach ($result as $row) { 
                                        echo "<option value=" . $row["nom"] . ">" . $row["nom"] . "</option>";
                                    }
                                    ?>
                                </select>
                <button name="ok" type="submit" class="mb-1 btn mt-3 btn-dark">OK</button>
          </div>
                
        </div>
          </form>
          
      
    </div>
        <div class=" prod_div col-4  position-relative shadow border border-secondary-subtle border-2 bg-white">
        <div class="d-flex justify-content-center align-items-center position-absolute end-0 container row" style="width:350px" >
        <span class="col-4" >sort by:</span>
        <div class="row col mx-1" >
          <div class="position-relative  border border-2 py-1 rounded-start-4 col">
            <a class=" text-decoration-none text-reset d-flex justify-content-center align-items-center" href="sortPrix.php">
              <span class="fw-bold" >prix</span>
              <i class="px-2 position-absolute end-0 fa-solid fa-sort-up"></i>
              <i class="px-2 position-absolute end-0 fa-solid fa-sort-down"></i>
            </a>
           </div>
        <div class="position-relative col d-flex justify-content-center align-items-center border border-2 py-1 rounded-end-4 ">
        <a class=" text-decoration-none text-reset d-flex justify-content-center align-items-center" href="sortDate.php">
            <span class="fw-bold">date</span>
            <i class="px-2 position-absolute end-0 fa-solid fa-sort-up"></i>
            <i class="px-2 position-absolute end-0 fa-solid fa-sort-down"></i>
        </a>
          </div>
        </div>
      </div>
        <span class=" fw-bold fs-3" >results:</span>
    <div class=" position-relative row  g-1">
      <?php include("products.php"); ?>
      </div>
    </div>
    
      </div>
      

    
</body>
</html>