<?php
session_start();
 ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Layout</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fontello/css/fontello.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700" rel="stylesheet">
</head>

<body>

  <div class="container">
    <header class="contact_header profile_header">
      <div class="grey_header_top header_top">
        <div class="logo_top"><a href="index.php"><img src="img/logo.png" class="header_logo" alt=""></a></div>
        <div class="search" style="max-width: 378px; height: 44px; border: 1px solid #CCC; border-radius: 40px; background-color: #FFFFFF">
          <input type="text" style=" width: 70%; border: none; font-size: 1.7rem; margin-left: 20px; background-color: #FFFFFF">
          <div class="icon-search-con"><i class="icon-search"></i></div>
        </div>
        <div class="menu"><a href="contact.php">Kontakt</a> <span>|</span><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) echo '<a href="profile.php">Profil</a><span>|</span><a href="login_system/logout.php">Wyloguj</a>'; else echo '<a href="register.php">Zarejestruj</a> <span>|</span> <a href="login.php">Zaloguj</a>';?><span>|</span> <a href="cart.php">Koszyk</a></div>
      </div>

      <div class="profile_header_image_container">
        <div class="profile_header_image">
          <div class="element1"></div>
          <div class="element2"></div>
        </div>
              <div class="mask"></div>
      </div>
      <div class="profle_header_name">
        <span><div style='display: inline' id='profile_first_name_span'></div><div style='display: inline' id='profile_last_name_span'></div></span>

      </div>



      <div class="border_top"></div>
    </header>


    <div class="content_profile">
      <div class="profile_top">
      <div class="left content_profile_side">
        <div class="profile_info"><div id='profile_info_label_email' class="profile_info_label">Email</div><div id='profile_info_value_email' class="profile_info_value"></div></div>
      <br><div class="profile_info"><div id='profile_info_label_address' class="profile_info_label">Adres</div><div id='profile_info_value_address' class="profile_info_value"></div></div>
      <br><div class="profile_info"><div id='profile_info_label_phonenumber' class="profile_info_label">Telefon</div><div id='profile_info_value_phonenumber' class="profile_info_value"></div></div>
      </div>
      <div class="right content_profile_side">
      <div class="profile_info"><div id='profile_info_label_postalcode' class="profile_info_label">Kod pocztowy</div><div id='profile_info_value_postalcode' class="profile_info_value"></div></div>
      <br><div class="profile_info"><div id='profile_info_label_city' class="profile_info_label">Miejscowość</div><div id='profile_info_value_city' class="profile_info_value"></div></div>
      <br><div class="profile_info"><div id='profile_info_label_country' class="profile_info_label">Kraj</div><div id='profile_info_value_country' class="profile_info_value"></div></div>
      </div>
      </div>
<div class="profile_bottom">
<a href="orders_history.php"><button class="button_grey profile_orders_button" type="button" name="button">Historia zamówień</button></a>
<a href="#"><button class="button_red profile_change_button" type="button" name="button">Zmień</button></a>

</div>
    </div>

    <footer>
      <div class="write_to_us_con">

        <form class="write_to_us_form" id="write_to_us_form" action="#" method="post">
          <div class="write_to_us_form_con">
            <div class="top_text">
              <h1>Masz pytania? Napisz do nas</h1>
            </div>
            <div class="top">
              <input type="text" name="" value="" placeholder="Imię">
              <input type="text" name="" value="" placeholder="Adres E-mail">
            </div>
            <div class="bottom">
              <textarea name="name" form="write_to_us_form" rows="8" placeholder="Wiadomość"></textarea>
            </div>
          </div>
          <input type="submit" name="" value="Wyślij">

        </form>
      </div>

      <div class="logo_footer">
        <img src="img/logo.png" class="footer_logo" alt="logo sickride" style="transform: scale(0.6)">
      </div>
    </footer>

  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
  <script type="text/javascript">
  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "get_user_info"}
 }).done(function( json ) {
   var user_info = JSON.parse(json);
   console.log(user_info);
   console.log(user_info['first_name']);
   $('#profile_first_name_span').html(user_info['first_name'] + ' ');
   $('#profile_last_name_span').html(user_info['last_name']);

   $('#profile_info_value_email').html(user_info['email']);
   $('#profile_info_value_address').html(user_info['address']);
   $('#profile_info_value_phonenumber').html(user_info['phone_number']);
   $('#profile_info_value_postalcode').html(user_info['postal_code']);
   $('#profile_info_value_city').html(user_info['city']);
   $('#profile_info_value_country').html(user_info['country']);
  });
  </script>
</body>

</html>
