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
    <link rel="stylesheet" href="fontello2/css/fontello.css">
   <link rel="stylesheet" href="fontello/css/fontello.css">

   <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700" rel="stylesheet">
 </head>

 <body>

   <div class="container cart_container">
     <header class="cart_header order_header">
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

     <div class="content content_cart">
       <div class="cart_strap">
         <span class="checked">TWÓJ KOSZYK</span>
         <span>DOSTAWA I PŁATNOŚĆ</span>
         <span>PODSUMOWANIE</span>
       </div>
       <div class="pedzel pedzel_left"><span>TWÓJ KOSZYK</span></div>
       <br>

<div class="cart_help_container">
         <div class="cart_items_labels">
           <span>Ilość</span>
           <span>Cena</span>
           <span>Usuń z koszyka</span>
         </div>
         <div class="cart_items"></div>
</div>
     </div>
     <div class="cart_price_container">
     <div class="cart_price">
       <span>Razem:</span>
       <span id="cart_price"></span>
     </div>
     </div>
     <div class="cart_button_container">
       <a href="realization.php"><button class="next_button">Dalej</button></a>
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

function is_cart_empty(){
   $.ajax({
    type: "POST",
    url: "functions.php",
    data: { what: "is_cart_empty"}
  }).done(function( json ) {
    console.log(json);
    var data = JSON.parse(json);
    console.log(data);
    var is_cart_empty = data['is_cart_empty'];
    console.log("IS CART EMPTY: " + is_cart_empty);


   if(is_cart_empty == 0){
     list_cart();
     get_cart_price();
}
else{
  $('.cart_help_container').html('<div style="text-align: center">Brak produktów koszyku</div>');
  $('.cart_price_container').empty();
  $('.cart_button_container').empty();
 console.log("Brak produktów w koszyku");
}
});
}
is_cart_empty();
 $('body').on('keyup', '.cart_amount_input', function(event){
   if (event.keyCode === 13) {
  console.log("enter");
  this.blur();
   }
 });

$('body').on('focusout', '.cart_amount_input', function(){
    id = this.id;
    console.log("focusout: "+this.id);
    console.log(this.value);
    value = this.value;
    item = this.id.slice(12);
    console.log(item);

    $.ajax({
     type: "POST",
     url: "functions.php",
     data: { what: 'change_amount_from_value', item: item, value: value}
   }).done(function( msg ) {
     console.log(msg);
     id = id.slice(12);
     list_cart_fill_only(id);
     get_cart_price();
    });
});

    function get_cart_price(){
   $.ajax({
    type: "POST",
    url: "functions.php",
    data: { what: "get_cart_price"}
  }).done(function( price ) {
    console.log("$$$$$$$$$$$$$$$$$$$$$$$$");
     console.log("Cena: "+price);
     $("#cart_price").html(price);
   });
 }

 function list_cart_fill_only(item){
   amount_id = item;
   $.ajax({
    type: "POST",
    url: "functions.php",
    data: { what: "get_cart_item_amount", item: item}
  }).done(function( amount ) {
    console.log("ITEM"+item);
    console.log("AMOUNTJS: "+amount);
        $(`#cart_amount_${amount_id}`).val(amount);
     });
  }


 function list_cart(){
  $(".cart_items").empty();
    $.ajax({
     type: "POST",
     url: "functions.php",
     data: { what: "get_cart_items"}
   }).done(function( json ) {
     var cart_items = JSON.parse(json);
      console.log(cart_items);
      Object.keys(cart_items).forEach(key => {
          var lay = `<div class="cart_item_container">
                  <div class="cart_item_name"><span>${cart_items[key].name}</span></div>
                  <div class="cart_item_rest">
                    <span> <button id=${key} class='decrease_amount'><</button> <span><input type='text' class='cart_amount_input' id='cart_amount_${key}' value='${cart_items[key].amount}'></span><button id=${key} class='increase_amount'>></button></span>
                    <span id='cart_price_${key}'>${cart_items[key].price}</span>
                    <span id='${key}' class='del_from_cart' style='cursor: pointer; display: flex; align-items: center; justify-content: space-around'><div style='position: relative'><div class='delete_cross_left' style=' top: -9px; position: absolute; transform: rotate(45deg); width: 3px; height: 20px; background-color: #FFFFFF'></div><div class='delete_cross_right' style='position: absolute; top: -9px;transform: rotate(-45deg); width: 3px; height: 20px; background-color: #FFFFFF'></div><div></span>
                  </div>
                </div>`;
              $(".cart_items").append(lay);
      });
   });
 }

$('body').on('click', '.decrease_amount', function(){
  var id = this.id;
  console.log("zmniejszam: "+this.id);
  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "cart_decrease_amount", item: this.id }
  }).done(function( msg ) {
    console.log(msg);
    list_cart_fill_only(id);
    get_cart_price();
  });
});

$('body').on('click', '.increase_amount', function(){
  var id = this.id;
  console.log("zwiekszam: "+this.id);
  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "cart_increase_amount", item: this.id }
  }).done(function( msg ) {
    console.log(msg);
    list_cart_fill_only(id);
    get_cart_price();
  });
});

   $('body').on('click', '.del_from_cart', function() {

  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "del_from_cart", item: this.id }
  }).done(function( msg ) {
    console.log(msg);
    get_cart_price();
    is_cart_empty();
  });

     });
   </script>
 </body>

 </html>
