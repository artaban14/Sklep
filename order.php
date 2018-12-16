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

  <div class="container order_container">
    <header class="cart_header">
      <div class="grey_header_top header_top">
        <div class="logo_top"><a href="index.php"><img src="img/logo.png" class="header_logo" alt=""></a></div>
        <div class="search" style="max-width: 378px; height: 44px; border: 1px solid #CCC; border-radius: 40px; background-color: #FFFFFF">
          <input type="text" style=" width: 70%; border: none; font-size: 1.7rem; margin-left: 20px; background-color: #FFFFFF">
          <div class="icon-search-con"><i class="icon-search"></i></div>
        </div>
        <div class="menu"><a href="contact.php">Kontakt</a> <span>|</span><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) echo '<a href="profile.php">Profil</a><span>|</span><a href="login_system/logout.php">Wyloguj</a>'; else echo '<a href="register.php">Zarejestruj</a> <span>|</span> <a href="login.php">Zaloguj</a>';?><span>|</span> <a href="cart.php">Koszyk</a></div>
      </div>

      <div class="border_top"></div>
    </header>

    <div class="content_order">
      <div class="pedzel pedzel_left"><span style="left: 15px">Historia</span></div>
      <br>
      <div class="order_items">
        <div class="order_items_labels">
          <span>Ilość</span>
          <span>Cena za sztukę</span>
          <span>Razem</span>
        </div>
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->
        <!-- ------------- -->
        <div class="order_item_container">
          <div class="order_item_name"><span>Jakisi fajny produkcikt tylko musi miec dlugi opis... fest dlugi</span></div>
          <div class="order_item_rest">
            <span>3</span>
            <span>22.99</span>
            <span>68.97</span>
          </div>
        </div>
        <!-- ------------- -->

      </div>

    </div>
    <div class="order_back_button_container">
<a href="orders_history.php"><button class="order_back_button">Wróć</button></a>
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
</body>

</html>
