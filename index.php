<?php
require_once 'config.php';
require_once 'dbfunctions.php';
require_once 'connect_pdo.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

session_start();

if(isset($_POST['write_to_us_post'])){
$email = $_POST['email'];
$name = $_POST['name'];
$message = $_POST['message'];
$date = date('d-m-Y h:i:s A');

$html = 'Adres E-mail: '.$email.'<br>Data wysłania: '.$date.'<br><br>Wiadomość: <br><br>'.$message;

$mail = new PHPMailer();
$mail->CharSet = "UTF-8";
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // 587
$mail->IsHTML(true);
$mail->SetLanguage("pl", "vendor/phpmailer/phpmailer/language/");
$mail->Username = "mail";
$mail->Password = "pass";
$mail->SetFrom('mail', "Sickride");
$mail->Subject = 'Pytanie od: '.$name;
$mail->Body = $html;
// $mail->AddEmbeddedImage('img/logo.png', 'logo');
$mail->AddAddress("mail", "Klient Sickride");
if (!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  $index++;
  if ($index < 5) $mail->Send();
}
else {
}
}
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
    <header>
      <div class="header_top">

        <div class="logo_top"><a href="index.php"><img src="img/logo.png" class="header_logo" alt=""></a></div>
        <div class="search" style="max-width: 378px; height: 44px; border: 1px solid #CCC; border-radius: 40px; background-color: #FFFFFF">
          <input id="search_text" type="text" name="search" value="" placeholder="Szukaj" style=" width: 70%; border: none; font-size: 1.7rem; margin-left: 20px; background-color: #FFFFFF">
          <!-- <input type="text" style=" width: 70%; border: none; font-size: 1.7rem; margin-left: 20px; background-color: #FFFFFF"> -->
          <div id="search_button" class="icon-search-con"><i class="icon-search" style="cursor: pointer"></i></div>

        </div>
        <div class="menu"><a href="contact.php">Kontakt</a> <span>|</span><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) echo '<a href="profile.php">Profil</a><span>|</span><a href="login_system/logout.php">Wyloguj</a>'; else echo '<a href="register.php">Zarejestruj</a> <span>|</span> <a href="login.php">Zaloguj</a>';?><span>|</span> <a href="cart.php">Koszyk</a></div>
      </div>

      <div class="header_text"><span><b>LEPSZY</b><br> POZIOM JAZDY</span></div>

      <div class="border"></div>
    </header>

    <div class="content" style="border-top: 35px solid #C61819;">
      <div class="border_curve"></div>
      <nav class="sidebar">
        <h1>KATEGORIE</h1>
        <?php
        function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
          $index = 0;
        foreach ($array as $categoryId => $category) {
        if ($currentParent == $category['parent_id']) {
            if ($currLevel > $prevLevel) echo " <ol> ";
            if ($currLevel == $prevLevel) echo " </li> ";
            echo '<li><label for="cat'.$category['id'].'" class="menu_label" id="lcat'.$category['id'].'">'.$category['name'].'</label><input type="checkbox" id="cat'.$category['id'].'"/>';
            if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
            $currLevel++;
            createTreeView ($array, $categoryId, $currLevel, $prevLevel);
            $currLevel--;
            }
        $index++;
        }
        if ($currLevel == $prevLevel) echo " </li>  </ol>";
        }
        echo '<ol class="ol_menu">';
        $stmt = $pdo -> query('SELECT * FROM categories');
        foreach ($stmt as $row) {
         $arrayCategories[$row['id']] = array("parent_id" => $row['parent_id'], "name" =>
         $row['name'], "id" => $row['id']);
          }
            $stmt->closeCursor();
        createTreeView($arrayCategories, 0);
        echo "</ol>";
         ?>
      </nav>

      <div class="products_container">

        <h1 class="products_header">Najnowsze Produkty</h1>

        <div class="products_list"></div>
      </div>

    </div>

    <footer>
      <div class="write_to_us_con">

        <form class="write_to_us_form" id="write_to_us_form" action="index.php" method="post">
          <div class="write_to_us_form_con">
            <div class="top_text">
              <h1>Masz pytania? Napisz do nas</h1>
            </div>
            <div class="top">
              <input type="text" name="name" value="" placeholder="Imię">
              <input type="text" name="email" value="" placeholder="Adres E-mail">
            </div>
            <div class="bottom">
              <textarea name="message" form="write_to_us_form" rows="8" placeholder="Wiadomość"></textarea>
            </div>
          </div>
          <input type="submit" class="write_to_us_submit" name="write_to_us_post" value="Wyślij">

        </form>
      </div>

      <div class="logo_footer">
        <img src="img/logo.png" class="footer_logo" alt="logo sickride" style="transform: scale(0.6)">
      </div>
    </footer>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript">
  // $('.write_to_us_submit').on('click', function(){
  //   console.log('send ssssssss');
  //   $('.popup_header').html('Dziękujemy za wysłanie wiadomości');
  //   $('.popup_content').html('aoishduashd haushd iuashd uihasuid hasui hduiash diuash duihsauidhiuas hdasdhiuh auisd');
  //   $('.popup').show();
  // });

  function list_products(products){
    $(".products_list").empty();
     if(products){

    products.forEach(function(item){
      var image_url = item.id;


var lay = `
      <div class="product">

        <a href='product.php?id="${item.id}"'><div class="product_photo" style="background-image: url('img/products/${image_url}.jpg')"></div></a>
        <div class="product_labels">
          <a style="color: #000000" href='product.php?id="${item.id}"'><div class="product_name">${item.name}</div></a>
          <div class="product_price">${item.price}</div>
          <button class="add_to_cart" type="button" name="add_to_cart" id=${item.id}>Dodaj do koszyka</button>
        </div>
      </div>`
$(".products_list").append(lay);

    // $(".products").append("<br>"+item['expression']+"##"+item['lenght']+"##"+item['count']+"##"+item['getcat']+"##"+item['cat']+"<a href='product.php?id="+item['id']+"'>"+item['id']+" "+item['name']+" - CENA: "+item['price']+"</a>");
    })
  }
  else{
    $(".products_list").empty();
    $(".products_header").html('Brak przedmiotów w danej kategorii');
  }
  }

  $("#search_text").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#search_button").click();
    }
});
$('body').on('click', '.add_to_cart', function(){

var id = this.id;
$.ajax({
type: "POST",
url: "functions.php",
data: { what: "add_to_cart", item: this.id }
}).done(function( msg ) {
  console.log(msg);
  show_popup(id);
});

  });
  $("#search_button").on("click", function(){
    var text = $("#search_text").val();
    $.ajax({
     type: "POST",
     url: "functions.php",
     data: { what: "search", expression: text}
   }).done(function( json ) {
     var products = JSON.parse(json);
     if(products){
       console.log(products);
       list_products(products);
       $(".products_header").html('Wyniki wyszukiwania -  ' +'"' + text +'"' );
     }
     else{
       $(".products_list").empty();
       $(".products_header").html('Brak wyników wyszukiwania - ' + '"' + text +'"');
     }

    });
    $('html, body').animate({
            scrollTop: $(".content").offset().top + 'px'
        }, 'slow');
  });


$('body').on('click', '.menu_label', function(event) {
  var categoryid = this.id.substr(4, this.id.length - 3);
  var categoryname;
  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "get_category_name", category: categoryid }
 }).done(function( title ) {
   $(".products_header").html(title);
  });
  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "get_products", category: categoryid }
 }).done(function( json ) {

   var products = JSON.parse(json);
   list_products(products);
  });
});


  $.ajax({
   type: "POST",
   url: "functions.php",
   data: { what: "get_products"}
 }).done(function( json ) {
   var products = JSON.parse(json);
   list_products(products);
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
  function close_popup(){
$('.popup').hide();
  }
  </script>
  <script src="js/script.js"></script>
</body>

</html>
