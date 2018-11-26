<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/GebOct Store/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

// DELETE PRODUCT //
if (isset($_GET['delete'])) {
  $id = sanitize($_GET['delete']);
  $db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
  header('Location: products.php');
}

$dbpath = '';
if(isset($_GET['add']) || isset($_GET['edit'])){
$brandQuery = $db->query("SELECT * FROM brands ORDER BY brand");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
$our_price = ((isset($_POST['our_price']) && $_POST['our_price'] != '')?sanitize($_POST['our_price']):'');
$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
$models = ((isset($_POST['models']) && $_POST['models'] != '')?sanitize($_POST['models']):'');
$models = rtrim($models,',');
$saved_image = '';

if (isset($_GET['edit'])) {
  $edit_id = (int)$_GET['edit'];
  $productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
  $product = mysqli_fetch_assoc($productResults);
  $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
  $title = ((isset($_POST['title']) && !empty($_POST))?sanitize($_POST['title']):$product['title']);
  $brand = ((isset($_POST['brand']) && !empty($_POST))?sanitize($_POST['brand']):$product['brand']);
  $parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
  $parentResult = mysqli_fetch_assoc($parentQ);
  if (isset($_GET['delete_image'])) {
    $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];echo $image_url;
    unlink($image_url);
    $db->query("UPDATE products SET `image` = '' WHERE id = '$edit_id'");
    header('Location: products.php?edit='.$edit_id);
  }
  $parent = ((isset($_POST['parent']) && !empty($_POST))?sanitize($_POST['parent']):$parentResult['parent']);
  $our_price = ((isset($_POST['our_price']) && !empty($_POST))?sanitize($_POST['our_price']):$product['our_price']);
  $list_price = ((isset($_POST['list_price']) && !empty($_POST))?sanitize($_POST['list_price']):$product['list_price']);
  $description = ((isset($_POST['description']) && !empty($_POST))?sanitize($_POST['description']):$product['description']); 
  $models = ((isset($_POST['models']) && !empty($_POST))?sanitize($_POST['models']):$product['models']);
  $models = rtrim($models,',');
  $saved_image = (($product['image'] != '')?$product['image']:'');
  $dbpath = $saved_image;
}
if(!empty($models)){
  $modelString = sanitize($models);
  $modelString  = rtrim($modelString,',');
  $modelsArray = explode(',',$modelString);
  $mArray = array();
  $qArray = array();
  foreach($modelsArray as $ms){
    $m = explode(':',$ms);
    $mArray[] = $m[0];
    $qArray[] = $m[1];
  }
}else{$modelsArray = array();}
if($_POST){
  $dbpath = '';
  $errors = array();
  $modelsArray = array();
  
  $required = array('title','brand','our_price','parent','child','models');
  foreach ($required as $field) {
    if ($_POST[$field] == '') {
      $errors[] = 'All fields with * are required ...';
      break;
    }
  }
  if (!empty($_FILES)) {
    var_dump($_FILES);
    $picture = $_FILES['picture'];
    $name = $picture['name'];
    $nameArray = explode('.',$name);
    $fileName = $nameArray[0];
    $fileExt = $nameArray[1];
    $mime = explode('/',$picture['type']);
    $mimeType = $mime[0];
    $mimeExt = $mime[1];
    $tmpLoc = $picture['tmp_name'];
    $fileSize = $picture['size'];
    $allowed = array('png','jpg','jpeg','gif');
    $uploadName = md5(microtime()).'.'.$fileExt;
    $uploadPath = BASEURL.'images/'.$uploadName;
    $dbpath = '/GebOct Store/images/'.$uploadName;
    if ($mimeType != 'image') {
      $errors[] = 'Please select an image file ...';
    }
    if (!in_array($fileExt, $allowed)) {
      $errors[] = 'Please select an image with png, jpg, jpeg or gif extension ...';
    }
    if ($fileSize > 15000000) {
      $errors[] = 'Please select an image file below 15MB ...';
    }
    if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
      $errors[] = 'Please the file extension does not match the file ...';
    }
  }
  if (!empty($errors)) {
    echo display_errors($errors);
  }else{
    // UPLOAD FILE & INSERT INTO DATABASE //
    move_uploaded_file($tmpLoc,$uploadPath);
    $insertSql = "INSERT INTO products (`title`,`our_price`,`list_price`,`brand`,`categories`,`models`,`image`,`description`) 
    VALUES ('$title','$our_price','$list_price','$brand','$category','$models','$dbpath','$description')";
    if (isset($_GET['edit'])) {
      $insertSql = "UPDATE prodcuts SET title = '$title', our_price='$our_price' list_price='$list_price',
      brand = '$brand', categories='$category', models='$models', `image` ='$dbpath', `description` = 'description'
      WHERE id = '$edit_id'";
    }

    $db->query($insertSql);
    header('Location: products.php');
}
}
?>
   <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2>
   <hr>
   <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data" style="margin:0 1%;">
     <div class="row">
      <div class="form-group col-md-3">
        <label for="title">Title<span class="text-danger" style="font-size:20px;">*</span>:</label>
        <input class="form-control" type="text" name="title" id="title" value="<?=$title;?>">
      </div>
      <div class="form-group col-md-3">
        <label for="brand">Brand<span class="text-danger" style="font-size:20px;">*</span>:</label>
        <select class="form-control" name="brand" id="brand">
          <option value=""<?=(($brand == '')?' selected':''); ?>></option>
          <?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
            <option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected':'')?>><?= $b['brand']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="parent">Parent Category<span class="text-danger" style="font-size:20px;">*</span>:</label>
        <select class="form-control" name="parent" id="parent">
          <option value="" <?= (($parent == '')?' selected':''); ?>></option>
          <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
            <option value="<?= $p['id']; ?>" <?=(($parent == $p['id'])?' selected':'');?>><?= $p['category'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="child">Child Category<span class="text-danger" style="font-size:20px;">*</span>:</label>
        <select class="form-control" name="child" id="child">
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="our_price">Our Price<span class="text-danger" style="font-size:20px;">*</span>:</label>
        <input class="form-control" type="text" id="our_price" name="our_price" value="<?=$our_price;?>">
      </div>
      <div class="form-group col-md-3">
        <label for="list_price">List Price:</label>
        <input class="form-control" type="text" id="list_price" name="list_price" value="<?=$list_price;?>">
      </div>
      <div class="form-group col-md-3">
        <label for="">Quantity & Models<span class="text-danger" style="font-size:20px;">*</span>:</label>
        <button class=" form-control btn btn-default" onclick="jQuery('#modelsModal').modal('toggle');return false;">Quantity & Models</button>
      </div>
      <div class="form-group col-md-3">
        <label for="models">Models & Quantity Preview:</label>
        <input class="form-control" type="text" name="models" id="models" value="<?=$models;?>" readonly> 
      </div>
      <div class="form-group col-md-6">
        <?php if($saved_image != ''): ?>
          <div class="saved-image">
            <img src="<?=$saved_image;?>" alt="saved image"><br><br>
            <a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="btn btn-sm btn-danger">Delete Image</a>
          </div>
        <?php else: ?>
          <label for="picture">Product Picture<span class="text-danger" style="font-size:20px;">*</span>:</label>
           <input class="form-control" type="file" name="picture" id="picture">
        <?php endif;?>
      </div>
      <div class="form-group col-md-6">
        <label for="description">Description:</label>
        <textarea class="form-control" name="description" id="description" rows="3"><?=$description;?></textarea>
      </div>
     </div>
     <div class="form-group float-right">
        <a href="products.php" class="btn btn-info">Cancel</a>
        <input class="btn btn-success" type="submit" value="<?= ((isset($_GET['edit']))?'Edit':'Add');?> Product">
      </div>
      <div class="clearfix"></div>
   </form>
   <!-- MODELS AND QUANTITIES MODAL -->
   <div class="modal fade" id="modelsModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modelsModalLabel" arai-hidden="true">
     <div class="modal-dialog modal-lg">
       <div class="modal-content">
         <div class="modal-header">
        <h4 class="modal-title" id="modelsModalLabel">Model & Quantity</h4>
         <button class="close" id="close_icon" type="button" data-dismiss="modal" arial-label="close">
           <span aria-hidden="true">&times;</span>
         </button>
        </div>
         <div class="modal-body">
         <div class="container-fluid row">
           <?php for($i = 1;$i <= 12;$i++): ?>
              <div class="form-group col-md-4">
                <label for="model<?= $i; ?>">Model:</label>
                <input class="form-control" type="text" name="model<?= $i;?>" id="model<?= $i;?>" value="<?= ((!empty($mArray[$i-1]))?$mArray[$i-1]:''); ?>">
              </div>
              <div class="form-group col-md-2">
                <label for="qty<?= $i; ?>">Quantity:</label>
                <input class="form-control" type="number" name="qty<?= $i;?>" id="qty<?= $i;?>" value="<?= ((!empty($qArray[$i-1]))?$qArray[$i-1]:''); ?>" min="0">
              </div>
           <?php endfor ?>
           </div>
         </div>
         <div class="modal-footer">
           <button class="btn btn-success" type="button" onclick="updateModels();jQuery('#modelsModal').modal('toggle');return false;">Save changes</button>
           <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div> 
<?php
}
else{
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $db->query($sql);
if(isset($_GET['featured'])){
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $db->query($featuredSql);
    header('Location: products.php');
}
?>

<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success float-right" id="add-product-btn" style="margin-top:-35px;">Add Product</a>
<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-striped table-condensed" style="margin:0 1%;">
  <thead class="bg-primary text-light"><th>Action</th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Qty Sold</th></thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($presults)): 
         $childID = $product['categories'];
         $childSql = "SELECT * FROM categories WHERE id = '$childID'";
         $child_result = $db->query($childSql);
         $child = mysqli_fetch_assoc($child_result);
         $parentID = $child['parent'];
         $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
         $pResults = $db->query($pSql);
         $parent = mysqli_fetch_assoc($pResults);
         $category = $parent['category'].'~'.$child['category'];
     ?>
      <tr>
        <td>
          <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-sm btn-outline-dark"><span class="fa fa-pencil-alt"></span></a>
          <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-sm btn-outline-dark"><span class="fa fa-times-circle"></span></a>
        </td>
        <td><?=$product['title'];?></td>
        <td><?=money($product['our_price']);?></td>
        <td><?=$category;?> </td>
        <td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-sm btn-default text-dark"> 
              <span class="fa fa-<?=(($product['featured'] == 1)?'minus':'plus');?>"></span>
            </a>&nbsp <?=(($product['featured'] == 1)?'Featured Product':'');?></td>
        <td>0000</td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php } include 'includes/footer.php';?>
<script>
  jQuery('document').ready(function(){
    get_child_options('<?=$category;?>');
  });
</script>
<style>
  #close_icon:hover{color: red;}
  .saved-image img{width: 157px; height: auto;}
</style>