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
    <header class="contact_header">
      <div class="grey_header_top header_top">
        <div class="logo_top"><a href="index.php"><img src="img/logo.png" class="header_logo" alt=""></a></div>
        <div class="search" style="max-width: 378px; height: 44px; border: 1px solid #CCC; border-radius: 40px; background-color: #FFFFFF">
          <input type="text" style=" width: 70%; border: none; font-size: 1.7rem; margin-left: 20px; background-color: #FFFFFF">
          <div class="icon-search-con"><i class="icon-search"></i></div>
        </div>
        <div class="menu"><a href="contact.php">Kontakt</a> <span>|</span><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) echo '<a href="profile.php">Profil</a><span>|</span><a href="login_system/logout.php">Wyloguj</a>'; else echo '<a href="register.php">Zarejestruj</a> <span>|</span> <a href="login.php">Zaloguj</a>';?><span>|</span> <a href="cart.php">Koszyk</a></div>
        <div class="border"></div>
      </div>

      <div class="header_title_text"><span><span style="color: #C61819;">O NAS/</span>KONTAKT</span>
      </div>

      <div class="border_top"></div>
    </header>

    <div class="content_contact">
      <div class="pedzel pedzel_left"><span>O NAS</span></div>
      <br>
        <div class="contact_text">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in leo ac felis auctor bibendum. Suspendisse semper turpis et blandit eleifend. Nunc rutrum purus ac accumsan bibendum. Vestibulum efficitur et quam sed tincidunt. Fusce mattis feugiat ipsum,
          sed facilisis augue eleifend vel. Suspendisse potenti. Mauris scelerisque vitae purus ut vulputate. Sed tincidunt tortor lacus, vel sagittis nunc dictum et. Curabitur congue ipsum a odio aliquam, quis dapibus ligula tristique. Integer porttitor,
          metus in congue aliquet, urna nulla ultrices purus, eget ultricies nulla mauris eu ante. Maecenas quis porta felis. Etiam sodales, tortor et condimentum efficitur, felis sem viverra leo, non mattis justo sem a odio. Suspendisse eu lorem et enim
          feugiat sodales. Curabitur eu augue sed ipsum tempor pellentesque eget sit amet ligula. Quisque pretium quam id tincidunt commodo. Donec iaculis ligula efficitur dui molestie, non scelerisque metus vestibulum. Proin sem mauris, suscipit ac eros
          sit amet, auctor volutpat nisi.
        </div>
      <br>
      <div class="pedzel pedzel_right"><span>KONTAKT</span></div>

        <div class="contact_text">
          Donec porta quam ligula, eget molestie est facilisis eget. Nam vulputate tempor risus, quis finibus nunc sagittis a. Integer sed arcu libero. Etiam facilisis nec nulla in elementum. Curabitur nec maximus sapien. Quisque iaculis id diam id rhoncus. Nam
          aliquam, lorem in cursus blandit, lacus lorem ultricies purus, non laoreet elit sem id dui. Phasellus a efficitur odio, vitae semper erat. Duis laoreet dui non consequat fermentum. Vivamus cursus, magna ac accumsan porta, purus neque fermentum
          arcu, a lacinia sem nisi sed eros. Integer placerat consectetur tempus. Vivamus rutrum posuere vestibulum. In tincidunt tellus ac odio iaculis pharetra.
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
</body>

</html>
