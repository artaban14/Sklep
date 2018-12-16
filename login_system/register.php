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
            //  echo "New record created successfully";
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
header("Location: /");
   exit;

 ?>
