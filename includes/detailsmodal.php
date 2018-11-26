  <?php
    require_once '../core/init.php';
    $id = $_POST['id'];
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = $db->query($sql);
    $product = mysqli_fetch_assoc($result);
    $brand_id = $product['brand'];
    $sql = "SELECT brand FROM brands WHERE id = '$brand_id'";
    $brand_query = $db->query($sql);
    $brand = mysqli_fetch_assoc($brand_query);
    $modelstring = $product['models'];
    $modelstring = rtrim($modelstring,',');
    $model_array = explode(',',$modelstring);
  ?>

  <!-- DETAILS MODAL BOX -->
  <?php ob_start(); ?>
  <div class="modal fade details-1" data-keyboard="false" data-backdrop="static" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
         <div class="modal-dialog modal-lg">
           <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-centre"><?= $product['title']; ?></h4>
              

                <button class="close" id="close_icon" type="button" onclick="closeModal()" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body">
             <div class="container-fluid">
               <div class="row">
                 <div class="col-sm-6">
                   <div class="center-block">
                     <img src="<?= $product['image'];?>" alt="<?= $product['title']; ?>" class="details img-responsive">
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <h4>Details</h4>
                   <p><?= nl2br($product['description']); ?></p>
                   <hr>
                   <h6>Price: $<?= $product['our_price'];?></h6> 
                   <h6>Brand: <?= $brand['brand'];?></h6>
                   <hr>
                   <form action="add_cart.php" method="post">
                     <div class="form-group">
                       <label for="model">Model:</label>
                        <select name="model" id="model" class="form-control">
                          <option class="" value=""></option>
                            <?php foreach($model_array as $string){
                                $string_array = explode(':', $string);
                                $model = $string_array[0];
                                $quantity = $string_array[1];
                                echo '<option value="'.$model.'">'.$model.' ('.$quantity.' Available)</option>';
                             }?>
                       </select>
                     </div>
                     <div class="form-group">
                       <div class="col-xs-3">
                         <label for="quantity">Quantity:</label>
                         <input type="text" class="form-control" id="quantity" name="quantity">
                       </div>
                     </div>
                   </form>
                 </div>
               </div>
             </div>
           </div>
            <div class="modal-footer">
             <button class="btn btn-warning" type="submit"><span class="fa fa-shopping-cart"></span> Add To Cart</button>
             <button class="btn btn-outline-danger" onclick="closeModal()">Close</button>
            </div>
           </div>
         </div>
       </div>
       <hr>

       <script>
         function closeModal(){
           jQuery('#details-modal').modal('hide');
           setTimeout(function() {
            jQuery('#details-modal').remove();
            jQuery('.modal-backdrop').remove();
           }, 500);
         }
       </script>
       <style>
           #close_icon:hover{color: red;}
       </style>
       <?php echo ob_get_clean(); ?>

       