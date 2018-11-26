<?php
    require_once '../core/init.php';
    include 'includes/head.php';
    include 'includes/navigation.php';
    ///// GET BRANDS FROM DATABASE /////
    $sql = "SELECT * FROM brands ORDER BY brand";
    $results = $db->query($sql);
    $errors = array();

    ///// EDIT BRAND /////
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
      $edit_id = (int)$_GET['edit'];
      $edit_id = sanitize($edit_id);
      $sql2 = "SELECT * FROM brands WHERE id = '$edit_id'";
      $edit_result = $db->query($sql2);
      $eBrand = mysqli_fetch_assoc($edit_result);
    }

    ///// DELETE BRAND /////
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
      $delete_id = (int)$_GET['delete'];
      $delete_id = sanitize($delete_id);
      $sql = "DELETE FROM brands WHERE id = '$delete_id'";
      $db->query($sql);
      header('Location: brands.php');
    }

    ///// IF ADD BRAND FORM IS SUBMITTED /////
    if (isset($_POST['add_submit'])) {
      $brand = sanitize($_POST['brand']);

      //CHECK IF BRAND IS BLANK//
      if($_POST['brand'] == ''){
        $errors[] .= 'Please enter a brand ...';
      }

      //CHECK IF BRAND EXISTS IN DATABASE//
      $sql = "SELECT * FROM brands WHERE brand = '$brand'";
      if(isset($_GET['edit'])){
        $sql = "SELECT * FROM brands WHERE brand = '$brand' AND id != '$edit_id'";
      }
      $result = $db->query($sql);
      $count = mysqli_num_rows($result);
      if($count > 0){
        $errors[] .= $brand.' already exists, Please choose a new brand name ...';
      }

      //DISPLAY ERRORS
      if(!empty($errors)){
         echo display_errors($errors);
      }
      else{
        //ADD BRAND TO DATABASE//
        $sql = "INSERT INTO brands (brand) VALUES ('$brand')";
        if(isset($_GET['edit'])){
          $sql = "UPDATE brands SET brand = '$brand' WHERE id = '$edit_id'";
        }
        $db->query($sql);
        header('Location: brands.php');
      }
    }
?> 
  <h2 id="me" class="text-center">Brands</h2>
  <hr>
  <!-- BRAND FORM -->
  <div class="text-center font-weight-bold" >
     <form class="form-inline " action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post" >
       <div class="form-group " style="margin:0 auto;">
         <?php 
         $brand_value = '';
         if(isset($_GET['edit'])){
           $brand_value = $eBrand['brand'];
         }
         else{
           if(isset($_POST['edit'])){
             $brand_value = sanitize($_POST['brand']);
           }
         }
         ?>
         <label class="font-weight-bold m-1" for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A');?> Brand:</label>
         <input type="text" name="brand" id="brand" class="form-control m-1" value="<?=$brand_value; ?>">
         <?php if(isset($_GET['edit'])):?>
           <a href="brands.php" class="text-light btn btn-info m-1">Cancel</a>
         <?php endif ?>
         <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> Brand" class="btn btn-success">
       </div>
     </form>
  </div>
  <hr>

  <table class="table table-striped table-auto table-condensed table-responsive-sm text-center">
    <thead class="bg-primary text-light">
        <th></th><th><h4>Brand</h4></th><th></th>
    </thead>
    <tbody>
      <?php while($brand = mysqli_fetch_assoc($results)): ?>
        <tr>
           <td><a href="brands.php?edit=<?=$brand['id'];?>" class="btn btn-sm btn-outline-dark"><span class="fa fa-pencil-alt"></span> edit</a></td>
           <td><?=$brand['brand'];?></td>
           <td><a href="brands.php?delete=<?=$brand['id'];?>" class="btn btn-sm btn-outline-dark"><span class="fa fa-times-circle"></span> delete</a></td> 
        </tr>
       <?php endwhile;?>
    </tbody>
  </table>
<?php include 'includes/footer.php';?>