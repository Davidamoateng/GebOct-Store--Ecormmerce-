<?php 
  require_once $_SERVER['DOCUMENT_ROOT'].'/GebOct Store/core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';

  $sql = "SELECT * FROM categories WHERE parent = 0";
  $result = $db->query($sql);
  $errors = array();
  $category = '';
  $post_parent = '';

  // EDIT CATEGORY //
  if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
    $edit_result = $db->query($edit_sql);
    $edit_category = mysqli_fetch_assoc($edit_result);
  }

  // DELETE CATEGORY //
  if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id =  (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);

    // DELETE PARENT //
    $sql = "SELECT * FROM categories WHERE id = '$delete_id'";
    $result = $db->query($sql);
    $delete_category = mysqli_fetch_assoc($result);
  
    if($category['parent'] == 0){
      $sql = "DELETE FROM categories WHERE parent = '$delete_id'";
      $db->query($sql);
    }
    $dSql = "DELETE FROM categories WHERE id = '$delete_id'";
    $db->query($dSql);
    header('Location: categories.php');
  }
  
  ///// PROCESS FORM /////

  if(isset($_POST) && !empty($_POST)){
    $post_parent = sanitize($_POST['parent']);
    $category = sanitize($_POST['category']);
    $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";
    if(isset($_GET['edit'])){
      $id = $edit_category['id'];
      $sqlform = "SELECT * FROM categories WHERE  category = '$category' AND parent = '$post_parent' AND id != '$id'";
    }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);

  // CHECK IF CATEGORY IS BLANK //
    if($category == ''){
      $errors[] .= 'Please enter a category ...';
    }

    // CHECK IF CATEGORY EXITS IN DATABASE //
    if($count > 0){
      $errors[] .= $category.' already exits, Please choose a new category name ...';
    }

    // DISPLAY ERRORS OR UPDATE DATBASE //
    if(!empty($errors)){
      // DISPLAY ERRORS //
      $display = display_errors($errors); ?>
      <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?=$display?>');
        });
      </script>
   <?php
    }else{
      // UPDATE DATABASE //
      $updateSql = "INSERT INTO categories (category, parent) VALUES ('$category','$post_parent')";
      if(isset($_GET['edit'])){
        $updateSql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
      }
      $db->query($updateSql);
      header('Location: categories.php');
    }
  }
  $category_value = '';
  $parent_value = 0;
  if(isset($_GET['edit'])){
    $category_value = $edit_category['category'];
    $parent_value = $edit_category['parent'];
  }
  else{
    if(isset($_Post)){
       $category_value = $category;
       $parent_value = $post_parent;
    }
  }
?>
<h2 class="text-center">Categories</h2>
<hr>
<div class="row" style="margin:0 1%;">
   <!-- CATEGORY FORM -->
  <div class="col-md-6">
    <form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <legend><?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Category</legend>
      <hr>

      <div id="errors"></div>

      <div class="form-group">
       <label for="parent">Parent:</label>
       <select class="form-control" name="parent" id="parent">
         <option value="0"<?=(($parent_value == 0)?'selected="selected"':'');?>>parent</option>
          <?php while($parent = mysqli_fetch_assoc($result)): ?>
            <option value="<?=$parent['id'];?>" <?=(($parent_value == $parent['id'])?' selected="selected"':'');?>><?=$parent['category']; ?></option>
          <?php endwhile;?>
       </select>
      </div>
      <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" class="form-control" id="category" name="category" placeholder="category" value="<?=$category_value;?>">
      </div>
      <div class="form-group">
        <input class="btn btn-success" type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> Category">
      </div>
    </form>
  </div>

  <!-- CATEGORY TABLE -->
  <div class="col-md-6">
    <table class="table table-bordered table-responsive-md">
      <thead>
        <th>Category</th><th>Parent</th><th>Action</th>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM categories WHERE parent =0";
          $result = $db->query($sql);
          while($parent = mysqli_fetch_assoc($result)):
          $parent_id = (int)$parent['id'];
          $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
          $cResult = $db->query($sql2);
        ?>
            <tr class="bg-primary text-light">
            <td><?= $parent['category'];?></td>
            <td>Parent</td> 
            <td>
                <a href="categories.php?edit=<?= $parent['id'];?>" class="btn btn-sm btn-light mr-sm-1"><span class="fa fa-pencil-alt"></span> edit</a>
                <a href="categories.php?delete=<?= $parent['id'];?>" class="btn btn-sm btn-light mr-sm-1"><span class="fa fa-times-circle"></span> delete</a>
            </td>
            </tr>
         <?php while($child = mysqli_fetch_assoc($cResult)): ?>
         <tr class="bg-secondary text-light">
            <td><?=$child['category'];?></td>
            <td><?=$parent['category'];?></td> 
            <td>
                <a href="categories.php?edit=<?= $child['id'];?>" class="btn btn-sm btn-light"><span class="fa fa-pencil-alt"></span> edit</a>
                <a href="categories.php?delete=<?= $child['id'];?>" class="btn btn-sm btn-light"><span class="fa fa-times-circle"></span> delete</a>
            </td>
            </tr>
         <?php endwhile; ?> 
       <?php endwhile; ?> 
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>