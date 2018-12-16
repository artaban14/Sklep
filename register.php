<?php

require_once '/sickride/config.php';
require_once '/sickride/dbfunctions.php';

if(isset($_POST['register_post'])){

$password = filter($conn, $_POST['password']);
$password_confirm = filter($conn, $_POST['password_confirm']);
$email = filter($conn, $_POST['email']);

$first_name = filter($conn, $_POST['first_name']);
$last_name = filter($conn, $_POST['last_name']);
$address = filter($conn, $_POST['address']);
$postal_code = filter($conn, $_POST['postal_code']);
$city = filter($conn, $_POST['city']);
$country = filter($conn, $_POST['country']);
$phone_number = filter($conn, $_POST['phone_number']);


$options = [
    'cost' => 9,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];

$hash = password_hash($password, PASSWORD_BCRYPT, $options);
$date = date("Y-m-d H:i:s");

if (mysqli_num_rows(mysqli_query($conn, "SELECT 'login' FROM users WHERE email = '$email'")) == 0){
  if($password_confirm === $password){

         $sql = "INSERT INTO users (password, email, firstname, lastname, address, postalcode, city, country, phonenumber, registered)
         VALUES ('$hash', '$email', '$first_name', '$last_name', '$address', '$postal_code', '$city', '$country', '$phone_number', '$date' )";

         if (mysqli_query($conn, $sql)) {
             echo "New record created successfully";
         } else {
             echo "Error: " . $sql . "<br>" . mysqli_error($conn);
         }
  }
  else{
    echo "Hasła nie pasują";
  }
}
else{
echo "Error: ". mysqli_error($conn);
}
}
// header("Location: /");
//  exit;

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
<div class="form_con">
<div class="form_con_flex">

<img src="img/logo.png" class="header_logo" alt="">
<h2 class="register_top">Zarejestruj się</h2>
<form class="register_form" action="register.php" method="post">


  <span class="form_label" style="float:right"><span class="form_label">Imię</span><input type="text" name="first_name" value="" ></span>
  <br>
  <span class="form_label" style="float:right"><span class="form_label"> Nazwisko</span><input type="text" name="last_name" value=""></span>
  <br>
  <span class="form_label" style="float:right"><span class="form_label">E-mail</span><input type="email" name="email" value=""></span>
  <br>
  <span class="form_label" style="float:right"><span class="form_label">Hasło</span><input type="password" name="password" value=""></span>
  <br>
  <span class="form_label" style="float:right"><span class="form_label">Powtórz hasło</span><input type="password" name="password_confirm" value=""></span>
  <br>
  <input type="submit" name="register_post" value="Zarejestruj">


</form>
<div class="register_bottom">
<span>Posiadasz już konto?</span>
<br>
<a href="#"><span><b>Zaloguj się</b></span></a>
<a href=""><p>Powrót na stronę główną</p></a>
</div>
</div>
</div>
  </body>
</html>
