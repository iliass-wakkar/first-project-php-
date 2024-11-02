<?php require_once("../head/head.php") ?>
<body>
    <header>
    <?php
require_once('../nav/nav.php')?>
    </header>
    <div class="cover-title shadow img_bg " >
    <h4 class="cost_txt" >Tout ce dont vous avez besoin avec une haute qualité et un bon prix</h4>
    <h1 class="cost_logo " style="font-family: 'Quicksand';color: rgb(255, 255, 255)">E-com</h1>        
    <button type="button" class="cover-title shadow cost_btn btn btn-lg btn-warning position-absolute   mt-3 ml-3"><a class="text-decoration-none text-reset" href="#product-list">Acheter maintenant</a></button>
    <a class="text-decoration-none" href="#product-list">    <i class="cost_icon fa-solid fa-5x fa-sort-down" style="color: #ffc107;"></i></a> 
    </div>
    <div id="product-list"class="d-flex  container justify-content-center align-items-start" >
        <img src="logo.png" class="bg-white shadow logo rounded-circle" >
      </div>
      <div  class="shadow row " >
        <div class="prod_div col  position-relative shadow border border-secondary-subtle border-2 bg-white">
        <div class="d-flex justify-content-center align-items-center position-absolute start-0 container row" style="width:350px" >
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
      </div><br>
    <div class=" position-relative row  g-1">
    <?php if(isset($_SESSION['admin'])){ ?>
    <div class="position-relative col-5 prod_fdiv pad d-flex flex-wrap justify-content-around">
    <div class="  mb-3" >
      <a href="../addproduct/addproduct.php">
                    <i class="position-absolute top-50 start-50 fa-solid fa-plus fa-2xl"></i>

      </a>
            </div>
        </div><?php }?>
      <?php include("products.php"); ?>
      </div>
      
    </div>
    
      </div>
      

    
</body>
</html>
