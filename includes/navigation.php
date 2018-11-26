 <!-- NAV BAR -->
<?php
    $sql = "SELECT * FROM categories WHERE parent = 0";
    $pquery = $db->query($sql);
  ?>

 <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" id="navBar">
        <div class="container">
            <a class="navbar-brand text-weight-bold" href="index.php"><img src="./images/Geboct-header-logo-small.png" alt="Geboct-header-logo-small"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav mr-auto">
              <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
                <?php 
                   $parent_id = $parent['id'];
                   $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
                   $cquery = $db->query($sql2);
                ?>

              <!-- MENU ITEMS -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><?php echo $parent['category'];?><span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
                    <li><a href="#"><?php echo $child['category']; ?></a></li>
                  <?php endwhile; ?>
                  </ul>
                </li> 
                <?php endwhile; ?> 
              </ul>
              
            </div>
          </div>
          <a href="#"><img src="./images/shop-cart3.png" alt="shop-cart3"><span>0</span></a>
        </nav>