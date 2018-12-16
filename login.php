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
      // echo "Zalogowano";
      header("Location: /");
         exit;
  } else {
echo "Nie Zalogowano";
  }
}


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="css/login.css">
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700" rel="stylesheet">
  </head>
  <body>
<div class="form_con" >
<div class="form_con_flex">

<img src="img/logo.png" class="header_logo" alt=""  style="margin-top: 90px">
<h2 class="login_top">Zaloguj się</h2>
<form class="login_form" action="login.php" method="post">


  <span class="form_label" style="float:right"><span class="form_label">E-mail</span><input type="email" name="email" value=""></span>
  <br>
  <span class="form_label" style="float:right"><span class="form_label">Hasło</span><input type="password" name="password" value=""></span>
  <br>
  <input type="submit" name="login_post" value="Zaloguj">


</form>
<div class="login_bottom">
<span>Nie masz jeszcze konta?</span>
<br>
<a href="#"><span><b>Zarejestruj się!</b></span></a>
<a href=""><p>Powrót na stronę główną</p></a>
</div>
</div>
</div>
  </body>
</html>
