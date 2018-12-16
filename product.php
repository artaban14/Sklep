<?php
session_start();
$id = $_GET['id'];
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

    <div class="content_product">
      <div class="product_top_container">
        <div class="left">
        <div id='product_top_image' class="product_top_image"></div>
        </div>
        <div class="right">
        <div class="pedzel_long_left"><span></span></div>
        <div class="product_top_description"></div>
        <div class="product_top_price"></div>
        <button class="product_top_addtocart add_to_cart">Dodaj do koszyka</button>
      </div>
      </div>
      <div class="product_bottom_container">
        <div class="pedzel product_bottom_pedzel"><span>Dane techniczne</span></div>
        <div class="product_bottom_properties">
  </div>
      </div>
      <!-- <div class="pedzel pedzel_left"><span style="left: 15px">Product</span></div> -->
      <br>

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

  function close_popup(){
 $('.popup').hide();
  }

id = <?php echo $id ?>;
  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "get_product_info", id: id}
 }).done(function( json ) {
    var product_info = JSON.parse(json);
   console.log(json);
   console.log(product_info);

var url = `../sickride/img/products/${id}.jpg`;
console.log(url);
$('.product_top_image').css('background-image', 'url("'+url+'")');
// $('.product_top_image').css('background-color', 'red');
$('.pedzel_long_left span').append(product_info['name']);
$('.product_top_description').html(product_info['longDescription']);
$('.product_top_price').html(product_info['price']);
var html_properties = "";
var properties = product_info['properties'];
if(properties.length>0){
for (let i=0; i<properties.length; i++) {
  html_properties += `
  <div class="product_property_container">
    <div class="product_property_item product_property_name">${properties[i][0]}</div>
    <div class="product_property_item product_property_value">${properties[i][1]}</div>
  </div>`;
}
}


console.log(properties);
console.log(html_properties);
if(properties.length>0){
$('.product_bottom_properties').append(html_properties);
}
else{
$('.product_bottom_properties').append('<h2>BRAK danych technicznych</h2>');
}
  });

  $('.add_to_cart').click(function() {
    var id =  <?php echo $id ?>;
 $.ajax({
  type: "POST",
  url: "functions.php",
  data: { what: "add_to_cart", item: id}
 }).done(function( msg ) {
   show_popup(id);
 });




 function show_popup(id){
console.log("ID" + id);
   $.ajax({
    type: "POST",
    url: "functions.php",
    data: { what: "get_product_info", id: id}
  }).done(function( json ) {
     var product_info = JSON.parse(json);
    console.log(json);
    console.log(product_info);

// ${product_info['name']}
   lay = `<div class="popup">
   <div class="close_popup" style='cursor: pointer; width: 20px; height: 20px; position: absolute; top: 10px; right: 10px' onclick='close_popup()'>
     <span class='delete_cross_left' style='position: absolute; right: 10px; transform: rotate(45deg); width: 3px; height: 20px; background-color: #C61819'></span>
     <span class='delete_cross_right' style='position: absolute; right: 10px; transform: rotate(-45deg); width: 3px; height: 20px; background-color: #C61819'></span>
   </div>
   <div class="popup_header">Dodano produkt do koszyka</div>
   <div class="popup_content">
     <div class='popup_content_top'>
       <div class='popup_image' style="background-image: url('img/products/${id}.jpg')"></div>
       <div class='popup_content_top_nameprice'>
       <span class='popup_name'>${product_info['name']}</span>
       <span class='popup_price'>${product_info['price']} zł</span>
     </div>
     </div>
     <div class='popup_content_description'>${product_info['longDescription']}</div>
     <div class='popup_buttons'>
     <button class='button_red' onClick='close_popup()'>Kontynuuj zakupy</button>
     <a href='cart.php'><button class='button_red'>Przejdź do koszyka</button></a>

     </div>
   </div>
     </div>`;
     $('.container').append(lay);
 });
}

    });
  </script>
</body>
</html>
