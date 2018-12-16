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

    <div class="content_orders">
      <div class="pedzel pedzel_left"><span>Zamówienia</span></div>
      <br>
      <div class="orders_list">

        <div class="history_order_labels">
          <span>Id</span>
          <span class='history_orders_datelabel'>Data</span>
          <span>Cena</span>
          <span>Status</span>
        </div>


      </div>

    </div>
    <div class="order_back_button_container">
<a href="profile.php"><button class="order_back_button">Wróć</button></a>
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

   $(".cart_items").empty();
     $.ajax({
      type: "POST",
      url: "functions.php",
      data: { what: "get_orders_history_list"}
    }).done(function( json ) {
      console.log(json);
      var history_order_items = JSON.parse(json);
       console.log(history_order_items);

       Object.keys(history_order_items).forEach(key => {
         date = history_order_items[key].purchase_date.substr(0,10);
       var lay = `<a href='order.php?id="${history_order_items[key].id}"'><div class="history_order_container">
         <span class='orders_item_id'>${history_order_items[key].id}</span>
         <span class='orders_item_date history_orders_datevalue'>${date}</span>
         <span class='orders_item_price'>${history_order_items[key].price}</span>
         <span class='orders_item_status'>${history_order_items[key].status}</span>
       </div></a>`;
       $(".orders_list").append(lay);
       });

      //  Object.keys(cart_items).forEach(key => {
      //      var lay = `<div class="cart_item_container">
      //              <div class="cart_item_name"><span>${cart_items[key].name}</span></div>
      //              <div class="cart_item_rest">
      //                <span> <button id=${key} class='decrease_amount'><</button> <span><input type='number' class='cart_amount_input' id='cart_amount_${key}' value='${cart_items[key].amount}'></span><button id=${key} class='increase_amount'>></button></span>
      //                <span id='cart_price_${key}'>${cart_items[key].price}</span>
      //                <span id='${key}' class='del_from_cart' style='cursor: pointer; display: flex; align-items: center; justify-content: space-around'><div style='position: relative'><div class='delete_cross_left' style=' top: -9px; position: absolute; transform: rotate(45deg); width: 3px; height: 20px; background-color: #FFFFFF'></div><div class='delete_cross_right' style='position: absolute; top: -9px;transform: rotate(-45deg); width: 3px; height: 20px; background-color: #FFFFFF'></div><div></span>
      //              </div>
      //            </div>`;
      //          $(".cart_items").append(lay);
      //  });
    });
  </script>
</body>

</html>
