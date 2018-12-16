<?php
require_once '/sickride/config.php';
require_once '/sickride/dbfunctions.php';

session_start();

if(isset($_POST['login_post'])){
  $email = filter($conn, $_POST['email']);
  $password = filter($conn, $_POST['password']);

  $query = mysqli_query( $conn,"SELECT password, cart FROM users WHERE BINARY email = '$email'");
  $table = null;
  while ($row = mysqli_fetch_array($query)) {
      $table = $row;
  }
$hash = $table["password"];
$cart = $table["cart"];
  if (password_verify($password, $hash)) {

      $_SESSION['loggedin'] = true;
      $_SESSION['email'] = $email;
      $_SESSION['cart'] = $cart;
  } else {
  }

}

header("Location: /");
   exit;


 ?>
