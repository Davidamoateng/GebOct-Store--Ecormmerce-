<?php 
       require_once 'core/init.php';
       include 'includes/head.php';
       include 'includes/navigation.php';
       include 'includes/headerfull.php';
       include 'includes/leftbar.php';

       $sql = "SELECT * FROM products WHERE featured = 1";
       $featured = $db->query($sql);
 ?>

            <!-- MAIN CONTENT -->
                <div class="col-md-8 col-lg-8 col-xl-8" style="background-color:">
                <!-- <h2 class="text-center text-weight-bold">Featured Products</h2> -->
                <hr>
                  <div class="row">
                  <?php while($products = mysqli_fetch_assoc($featured)) : ?>
                    <div class="col-md-3 col-lg-3 col-xl-3">
                    <h4 class=""><?= $products['title']; ?></h4>
                    <img style="size:20px" src="<?= $products['image'];?>" alt="<?= $products['title']; ?>">
                    <p class="list-price text-danger">List Price: <s>$<?= $products['list_price']; ?></s></p>
                    <p class="price">Our Price: $<?= $products['our_price']  ?></p>
                    <button type="button" class="btn btn-sm btn-success btn-center" onclick="detailsmodal(<?= $products['id']; ?>)" style="margin:0 20%;">Details</button>
                  </div><hr>
                  <?php endwhile; ?>
                  
                  </div> 
                </div>

                <?php
                    include 'includes/rightbar.php';
                    include 'includes/footer.php';
                  ?>
                  