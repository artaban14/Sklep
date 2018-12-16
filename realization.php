<?php
require_once 'config.php';
require_once 'dbfunctions.php';

session_start();
 ?>

<!DOCTYPE html>
<html lang="pl">
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
          <span>TWÓJ KOSZYK</span>
          <span  class="checked">DOSTAWA I PŁATNOŚĆ</span>
          <span>PODSUMOWANIE</span>
        </div>
        <div class="pedzel pedzel_long_left"><span>DOSTAWA I PŁATNOŚĆ</span></div>
        <br>
        <div class="realization_sections_container">
          <div class='realization_section'>
            <span class='realization_section_header'><span>1. </span>DANE DO WYSYŁKI</span>

            <div class="realization_section_client_info_form_container">


            <form class="realization_section_client_info_form" id="form_shipment_data">

              <div class='realization_form_item shipment_first_name_container' id='shipment_first_name_container'><span>Imię: </span><input type="text" name="shipment_first_name" value=""></div>
              <div class='realization_form_item shipment_last_name_container' id='shipment_last_name_container'><span>Nazwisko: </span><input type="text" name="shipment_last_name" value=""></div>
              <div class='realization_form_item shipment_address_container' id='shipment_address_container'><span>Adres: </span><input type="text" name="shipment_address" value=""></div>
              <div class='realization_form_item shipment_postal_code_container' id='shipment_postal_code_container'><span>Kod pocztowy: </span><input type="text" name="shipment_postal_code" value=""></div>
              <div class='realization_form_item shipment_city_container' id='shipment_city_container'><span>Miasto: </span><input type="text" name="shipment_city" value=""></div>
              <div class='realization_form_item shipment_country_container' id='shipment_country_container'><span>Kraj: </span><input type="text" name="shipment_country" value=""></div>
              <div class='realization_form_item shipment_email_container' id='shipment_email_container'><span>Adres E-mail: </span><input type="text" name="shipment_email" value=""></div>
              <div class='realization_form_item shipment_phone_number_container' id='shipment_phone_number_container'><span>Numer telefonu: </span><input type="text" name="shipment_phone_number" value=""></div>
            </form>


          </div>
          </div>

          <div class='realization_section'>
            <span class='realization_section_header'><span>2. </span>DOSTAWA</span>
            <span class='realization_section_subheader'>Wybierz sposób dostawy</span>
            <div class="list_shipment realization_section_list_shipment radio_checkbox">
              <form class="" id='form_shipment' method="post">
              </form>
            </div>
          </div>

          <div class='realization_section'>
            <span class='realization_section_header'><span>3. </span>PŁATNOŚĆ</span>
            <span class='realization_section_subheader'>Wybierz sposób płatności</span>
            <div class="list_payment realization_section_list_payment radio_checkbox">
              <form class="" id='form_payment' method="post">
              <input type="radio" form='form_payment' value="przlew_bankowy" name="payment" id='prl2'><label for='prl2'>Przelew bankowy<label><br>
              <input type="radio" form='form_payment' value="przy_odbiorze" name="payment" id='prl3'><label for='prl3'>Płatność przy odbiorze<label><br>
              </form>
            </div>
          </div>

          <div class='realization_section'>
            <span class='realization_section_header'><span>4. </span>FAKTURA</span>
            <div class='realization_section_list_facture_cb radio_checkbox'><input type="checkbox" form='form_realization' id="facture_cb" name="" value=""><label for="facture_cb">Chcę otrzymać fakturę VAT</label></div>
              <div class="facture_data_form realization_section_client_info_form" style='display: none; margin-top: 30px'>
                <span style='display: table; margin-bottom: 15px; border-bottom: 2px solid #C61819;'>Dane do faktury:</span>


                <form class="realization_section_client_info_form" id='form_facture_data' method="post">
                <div class='realization_form_item facture_first_name_container' id='facture_first_name_container'><span>Imię: </span><input type="text" name="facture_first_name" value=""></div>
                <div class='realization_form_item facture_last_name_container' id='facture_last_name_container'><span>Nazwisko: </span><input type="text" name="facture_last_name" value=""></div>
                <div class='realization_form_item facture_address_container' id='facture_address_container'><span>Adres: </span><input type="text" name="facture_address" value=""></div>
                <div class='realization_form_item facture_postal_code_container' id='facture_postal_code_container'><span>Kod pocztowy: </span><input type="text" name="facture_postal_code" value=""></div>
                <div class='realization_form_item facture_city_container' id='facture_city_container'><span>Miasto: </span><input type="text" name="facture_city" value=""></div>
                <div class='realization_form_item facture_country_container' id='facture_country_container'><span>Kraj: </span><input type="text" name="facture_country" value=""></div>
                <div class='realization_form_item facture_text_container' id='facture_email_container'><span>Adres E-mail: </span><input type="facture_text" name="email" value=""></div>
                <div class='realization_form_item facture_phone_number_container' id='facture_phone_number_container'><span>Numer telefonu: </span><input type="facture_text" name="phone_number" value=""></div>
              </form>


              </div>
          </div>

          <div class='realization_section'>
            <span class='realization_section_header'><span>5. </span>UWAGI KLIENTA</span>
            <textarea id='form_client_comments' class='realization_clientcomments_ta' form='form_client_comments' name="client_comments" rows="8" placeholder="Przekaż nam Swoje uwagi do zamówienia"></textarea>
          </div>

          <div class='realization_section'>
            <div class='realization_section_list_regulations_cb radio_checkbox'>
            <form class="" id='form_regulations' method="post">
            <input type="checkbox" form='form_regulations' id="cb2" name="regulations" value="1"><label for="cb2">Zapoznałem się i akceptuje regulamin i politykę prywatnośći sklepu sickride.pl</label></div>
          </form>
            <div class="realization_section_list_regulations_links">
            <span>Regulamin sklepu: <a href="">Przeczytaj</a></span>
            <span>Polityka prywatności: <a href="">Przeczytaj</a></span>
            </div>
          </div>

          <div class='realization_section'>
            <div class='realization_section_buttons'>
              <a href="cart.php"><button class='button_red realization_button' type="button" name="button">Powrót do koszyka</button></a>
              <button id='summary_button' class='button_red realization_button' type="button" name="button">Podsumowanie</button>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script type="text/javascript">

    $('.realization_form_item').on('keyup', function(event){
      if (event.keyCode === 13) {
     console.log("enter");
     $(this).find('input').blur();
     $(this).next('.realization_form_item').find('input').focus();

      }
    });

    $('.realization_form_item').on('focusout', function(){
      id = this.id;
      var value = $(this).find('input').val();
      if(value.length > 0){
        if(id=='facture_email_container' || id=='shipment_email_container'){
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          var test = re.test(String(value).toLowerCase());
          if(test == true){
            $(this).removeClass('wrong');
            $(this).addClass('correct');
          }
          else{
            $(this).removeClass('correct');
            $(this).addClass('wrong');
          }
        }
        else if(id=='facture_phone_number_container' || id=='shipment_phone_number_container'){
          var re = /^(?:\(?\+?48)?(?:[-\.\(\)\s]*(\d)){9}\)?$/;
          var test = re.test(String(value).toLowerCase());
          if(test == true){
            $(this).removeClass('wrong');
            $(this).addClass('correct');
          }
          else{
            $(this).removeClass('correct');
            $(this).addClass('wrong');
          }
        }
        else if(id=='facture_postal_code_container' || id=='shipment_postal_code_container'){
          var re = /^[\d]{2}-[\d]{3}$/;
          var test = re.test(String(value).toLowerCase());
          if(test == true){
            $(this).removeClass('wrong');
            $(this).addClass('correct');
          }
          else{
            $(this).removeClass('correct');
            $(this).addClass('wrong');
          }
        }
        else{
          $(this).addClass('correct');
        }
      }
      else{
        $(this).removeClass('correct');
      }
    });


    $(document).ready(function() {
      $('#facture_cb').change(function() {
         if(this.checked) {
  $('.facture_data_form').show('fast');
         }
         else{
           $('.facture_data_form').hide('fast');
         }
       });
var shipment;
var shipment_price;
var price;
var cart_price;

//-------------------------------------
function appendtoshipment(item){
  var lay = `<input type="radio" value="${item['name']}" name="shipment" id='rl${item['id']}'><label for='rl${item['id']}'><span class='realization_section_list_shipment_name'>${item['name']}</span><span class='realization_section_list_shipment_price'>${item['price']} zł</span><label><br>`
  // $(".list_shipment").append('<input type="radio" value="'+item['name']+'" name="shipment" id=rl'+item['id']+'><label for=rl'+item['id']+'>'+item['name']+' - '+item['price']+'<label><br>')
  $("#form_shipment").append(lay);
}
    $.ajax({
     type: "POST",
     url: "functions.php",
     data: { what: "list_shipment"}
   }).done(function( json ) {
      shipment = JSON.parse(json);
      shipment.forEach(appendtoshipment);
    });
//-------------------------------------


//-------------------------------------
  //   $.ajax({
  //    type: "POST",
  //    url: "functions.php",
  //    data: { what: "is_cart_empty"}
  //  }).done(function( json ) {
  //    console.log(json);
  //    var data = JSON.parse(json);
  //    console.log(data);
  //    var is_cart_empty = data['is_cart_empty'];
  //    var cart_json = data['cart'];
  //    console.log("IS CART EMPTY: " + is_cart_empty);
  //    console.log(cart_json);
  //    var cart = JSON.parse(cart_json);
  //    });


$("#summary_button").on("click", function(){
var shipment_data = $('#form_shipment_data').serializeArray();
var shipment = $('#form_shipment').serializeArray();
var payment = $('#form_payment').serializeArray();
var facture_data = $('#form_facture_data').serializeArray();
var client_comments = $('#form_client_comments').serializeArray();
var regulations = $('#form_regulations').serializeArray();
console.log(shipment_data);
console.log(shipment);
console.log(payment);
console.log(facture_data);
console.log(client_comments);
console.log(regulations);

// SHIPMENT DATA --------------------------------------------------------------
sd_fn = shipment_data[0].value;
sd_ln = shipment_data[1].value;
sd_a = shipment_data[2].value;
sd_pc = shipment_data[3].value;
sd_city = shipment_data[4].value;
sd_country = shipment_data[5].value;
sd_e = shipment_data[6].value;
sd_pn = shipment_data[7].value;

if(sd_fn != ''){

}
console.log(s_fn);


// SHIPMENT -------------------------------------------------------------------

// PAYMENT --------------------------------------------------------------------

// FACTURE DATA ---------------------------------------------------------------

// CLIENT_COMMENTS -------------------------------------------------------------

// REGULATIONS -----------------------------------------------------------------


// var info = JSON.stringify(items);
// console.log(info);

 //  $.ajax({
 //   type: "POST",
 //   url: "functions.php",
 //   data: { what: "realization", info: info}
 // }).done(function( msg ) {
 //    console.log(msg);
 //  });
});


//-------------------------------------
});
    </script>
  </body>
</html>
