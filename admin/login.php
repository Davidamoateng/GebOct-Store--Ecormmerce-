<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/GebOct Store/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>

<style>
  body{
      background-image:url("/GebOct Store/images/business-cart.png");
      background-size: 100vw 100vh;
      background-attachment: fixed;
    }
</style>

<div id="login-form">
  <div>

    <?php 
      if ($_POST) {
          // FORM VALIDATION //
          if (empty($_POST['email']) || empty($_POST['password'])) {
             $errors[] = 'Please email and password are required...!';
          }

          // VALIDATE EMAIL //
          if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
              $errors[] = 'Please enter a valid email...!';
          }

          // PASSWORD IS LESS THAN 6 CHARACTERS //
          if (strlen($password) < 6) {
              $errors[] = 'Please password must be atleast 6 characters...!';
          }

          // CHECK IF THE EMAIL EXITS IN THE DATABASE //
          $query = $db->query("SELECT * FROM users WHERE email = '$email'");
          $user = mysqli_fetch_assoc($query);
          $userCount = mysqli_num_rows($query);
          if ($userCount < 1) {
              $errors[] = 'Please this email doesn\'t exist our database...!';
          }

          if (!password_verify($password, $user['password'])) {
              $errors[] = 'Please the password is incorrect. Please try again...!';
          }

          // CHECK FOR ERRORS //
          if (!empty($errors)) {
              echo display_errors($errors);
          }else{
              // LOG USER IN //
              $user_id = $user['id'];
              login($user_id);
          }
      }
    ?>

  </div>
  <h2 class="text-center font-weight-bold">LOGIN</h2><hr>
  <form action="login.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input class="form-control" type="text" name="email" id="email" value="<?=$email;?>">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" id="password" value="<?=$password;?>">
    </div>
    <div class="form-group">
      <input class="btn btn-primary" type="submit" value="Login">
    </div>
  </form>
  <p class="text-right"><a href="/GebOct Store/index.php" alt="home">Visit Site</a></p>
</div>

<?php include 'includes/footer.php'; ?>