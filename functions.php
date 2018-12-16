<?php
// header('Content-Type: text/html; charset=utf-8');
require_once 'config.php';
require_once 'dbfunctions.php';
require_once 'connect_pdo.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

session_start();
$what = $_POST['what'];
$item = $_POST['item'];
$email = $_SESSION['email'];

if ($what == "add_to_cart") {
		$cart = $_SESSION['cart'];
		if($cart == NULL || $cart == '' || $cart == false){
			$_SESSION['cart'] = '["'.$item.'"]';
		}
		else{
		$cart = json_decode($_SESSION['cart'], true);
		array_push($cart, $item);
		$cartjson = json_encode($cart);
		$_SESSION['cart'] = $cartjson;
	}
		if ($_SESSION['loggedin']) {
			$stmt = $pdo->prepare('UPDATE users SET cart = :cart WHERE email = :email');
			$stmt->bindValue(':cart', $cartjson, PDO::PARAM_STR);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();

	}
}

if ($what == "get_cart_item_amount"){

	$item = $_POST['item'];
	$amount = 0;
	$cart = json_decode($_SESSION['cart'], true);
	foreach ($cart as $key => $value) {
		 if($value == $item){
	    $amount++;
		}
	}
	echo $amount;
}

if ($what == "del_from_cart") {
$item = $_POST['item'];
$cart = json_decode($_SESSION['cart'], true);
foreach ($cart as $key => $value) {
	 if($value == $item){
    unset($cart[$key]);
	}
}
	$cartjson = json_encode($cart);
	echo $cartjson;
	$_SESSION['cart'] = $cartjson;
	if ($email != "") {
		$stmt = $pdo->prepare('UPDATE users SET cart = :cart WHERE email = :email');
		$stmt->bindValue(':cart', $cartjson, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$stmt->closeCursor();
	}
}

if($what == "change_amount_from_value"){

	if($_POST['value']>0){

$item = $_POST['item'];
$value = $_POST['value'];

$amount = 0;
$cart = json_decode($_SESSION['cart'], true);
foreach ($cart as $key => $element) {
	 if($element == $item){
		$amount++;
	}
}
if($value == $amount){
}
// DODAWANIE---------------------------------------------
else if($value > $amount){
	$to_add = $value - $amount;
	for($i = 0; $i<$to_add; $i++){
	array_push($cart, $item);

	}
}
// DODAWANIE---------------------------------------------

// ODEJMOWANIE--------------------------------------------
else if($value < $amount){
	$to_remove =  $amount - $value;
	$count = 0;
	foreach ($cart as $key => $value) {
		 if($value == $item && $count<$to_remove){
			unset($cart[$key]);
			$count++;
		}
		if($count == $to_remove) break;
	}
}
// ODEJMOWANIE--------------------------------------------
$cartjson = json_encode($cart);
$_SESSION['cart'] = $cartjson;
if ($_SESSION['loggedin']) {
	$stmt = $pdo->prepare('UPDATE users SET cart = :cart WHERE email = :email');
	$stmt->bindValue(':cart', $cartjson, PDO::PARAM_STR);
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
	$stmt->closeCursor();
}
}
}

if($what == "cart_increase_amount"){

		$item = $_POST['item'];
		$cart = json_decode($_SESSION['cart'], true);
		array_push($cart, $item);
		$cartjson = json_encode($cart);
		$_SESSION['cart'] = $cartjson;
		if ($_SESSION['loggedin']) {
			$stmt = $pdo->prepare('UPDATE users SET cart = :cart WHERE email = :email');
			$stmt->bindValue(':cart', $cartjson, PDO::PARAM_STR);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
		}
}

if($what == "cart_decrease_amount"){

	$item = $_POST['item'];
	$cart = json_decode($_SESSION['cart'], true);
	foreach ($cart as $key => $value) {
		 if($value == $item){
	    unset($cart[$key]);
			break;
		}
	}
			$cartjson = json_encode($cart);
			$_SESSION['cart'] = $cartjson;
			if ($_SESSION['loggedin']) {
				$stmt = $pdo->prepare('UPDATE users SET cart = :cart WHERE email = :email');
				$stmt->bindValue(':cart', $cartjson, PDO::PARAM_STR);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);
				$stmt->execute();
				$stmt->closeCursor();
			}
}

if($what == "get_category_name"){

	$id = $_POST['category'];
	$stmt = $pdo->prepare('SELECT title
    FROM categories
    WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch();
$title = $row['title'];

  $stmt->closeCursor();
echo $title;

}

if ($what == "get_products") {
    if ($_POST['category'] != "") {
        $getcat = explode("00", $_POST['category']);
        $lenght = count($getcat);
    }

    $stmt = $pdo->query('SELECT * FROM products');
          foreach($stmt as $row)
          {
            if ($_POST['category'] != "") {
                $cat   = explode("00", $row['categoryid']);
                $flag  = 0;
                $count = 0;
                for ($a = 0; $a < $lenght; $a++) {
                    if ($getcat[$a] === $cat[$a])
                        $count++;
                }
                if ($count == $lenght)
                    $flag = 1;
            } else
                $flag = 1;

            if ($flag == 1) {
                $table[] = array(
                    'lenght' => $lenght,
                    'count' => $count,
                    'getcat' => $getcat,
                    'cat' => $cat,
                    'name' => $row['name'],
                    'id' => $row['id'],
                    'price' => $row['price']
                );
            }
          }
    $stmt->closeCursor();
    $productsjson = json_encode($table);
    echo $productsjson;
}

if ($what == "search") {
	$expression = $_POST['expression'];
  $stmt = $pdo->query('SELECT * FROM `products`');
	foreach($stmt as $row) {
		// if (strpos($row['name'], $expression) || strpos($row['name'], $expression) === 0) {
		if(preg_match('/'.$expression.'/i', $row['name'])){
			$table[] = array(
				'expression' => $expression,
				'lenght' => $lenght,
				'count' => $count,
				'getcat' => $getcat,
				'cat' => $cat,
				'name' => $row['name'],
				'id' => $row['id'],
				'price' => $row['price']
			);
		}
		else {
		}
	}
  $stmt->closeCursor();
	$productsjson = json_encode($table);
	echo $productsjson;
}
if ($what == "get_cart_items"){
	$cart_array = json_decode($_SESSION['cart'], true);
foreach ($cart_array as $id){
	$table[$id]['amount']++;
}


	foreach ($cart_array as $id){

  $stmt = $pdo->prepare('SELECT *
    FROM products
    WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch();

	$table[$id]['name'] = $row['name'];
	$table[$id]['price'] = $row['price'];
	$table[$id]['cartDescription'] = $row['cartDescription'];

}
$cartjson = json_encode($table);
echo $cartjson;

}


if ($what == "list_shipment") {

  $stmt = $pdo->query('SELECT * FROM `shipment`');
  foreach($stmt as $row) {

		$table[] = array(
			'id' => $row['id'],
			'name' => $row['name'],
			'price' => $row['price'],
			'time' => $row['time']
		);
	}
  $stmt->closeCursor();
	$productsjson = json_encode($table);
	echo $productsjson;
}

if ($what == "realization") {
	$index = 0;
	$cart = $_SESSION['cart'];
	$info = $_POST['info'];
	$json_array = json_decode($info, true);
	$info_array = array();
	for ($i = 0; $i < sizeof($json_array); $i++) {
		$key = $json_array[$i]['name'];
		$info_array[$key] = $json_array[$i]['value'];
	}

	print_r($info_array);
	$purchase_date = date("Y-m-d H:i:s");
	$deliver_date = 0;
	$deliver_hours = 0;
	$cart = $cart;
	$products_info = $cart;
	$shipment = filter($conn, $info_array['shipment']);
	$price = 0;
	$first_name = filter($conn, $info_array['first_name']);
	$last_name = filter($conn, $info_array['last_name']);
	$email = filter($conn, $info_array['email']);
	$phone_number = filter($conn, $info_array['phone_number']);
	$address = filter($conn, $info_array['address']);
	$postal_code = filter($conn, $info_array['postal_code']);
	$city = filter($conn, $info_array['city']);
	$country = filter($conn, $info_array['country']);
	$message = filter($conn, $info_array['message']);

	// $shipment =
	// purchase_date, deliver_date, deliver_hours, products_info, shipment, price, first_name, last_name, email, phone_number, address, postal_code, city, country, message

	$stmt = $pdo -> prepare('INSERT INTO `orders` (purchase_date, deliver_date, deliver_hours, cart, products_info, shipment, price, first_name, last_name, email, phone_number, address, postal_code, city, country, message)	VALUES(
	      :purchase_date,
	      :deliver_date,
	      :deliver_hours,
	      :cart,
	      :products_info,
	      :shipment,
	      :price,
	      :first_name,
	      :last_name,
	      :email,
	      :phone_number,
	      :address,
	      :postal_code,
	      :city,
	      :country,
	      :message
	    )');
	        $stmt -> bindValue(':purchase_date',$purchase_date, PDO::PARAM_STR);
	        $stmt -> bindValue(':deliver_date',$deliver_date, PDO::PARAM_STR);
	        $stmt -> bindValue(':deliver_hours',$deliver_hours, PDO::PARAM_STR);
	        $stmt -> bindValue(':cart',$cart, PDO::PARAM_STR);
	        $stmt -> bindValue(':products_info',$products_info, PDO::PARAM_STR);
	        $stmt -> bindValue(':shipment',$shipment, PDO::PARAM_STR);
	        $stmt -> bindValue(':price',$price, PDO::PARAM_STR);
	        $stmt -> bindValue(':first_name',$first_name, PDO::PARAM_STR);
	        $stmt -> bindValue(':last_name',$last_name, PDO::PARAM_STR);
	        $stmt -> bindValue(':email',$email, PDO::PARAM_STR);
	        $stmt -> bindValue(':phone_number',$phone_number, PDO::PARAM_STR);
	        $stmt -> bindValue(':address',$address, PDO::PARAM_STR);
	        $stmt -> bindValue(':postal_code',$postal_code, PDO::PARAM_STR);
	        $stmt -> bindValue(':city',$city, PDO::PARAM_STR);
	        $stmt -> bindValue(':country',$country, PDO::PARAM_STR);
	        $stmt -> bindValue(':message',$message, PDO::PARAM_STR);

	        $stmt -> execute();
					$stmt->closeCursor();

	if ($_SESSION['loggedin']) {

		$stmt = $pdo -> query('SELECT id FROM orders ORDER BY ID DESC LIMIT 1');
		      $row = $stmt->fetch();
		      $stmt->closeCursor();

		if ($row) {
			$id = $row['id'];
			echo "IDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD: " . $id . "%%%%%%%%%%";
			$logged_email = $_SESSION['email'];


			$stmt = $pdo->prepare('SELECT orders
				FROM users
				WHERE BINARY email = :email');

	  		$stmt->bindValue(':email', $logged_email, PDO::PARAM_STR);
	 			$stmt->execute();
	  		$row2 = $stmt->fetch();
				$stmt->closeCursor();

			$user_orders = $row2["orders"];
			echo "ORDERS________________________________" . $user_orders;
			if ($_SESSION['loggedin']) {
				if ($user_orders == "") {
					$user_orders = '["' . $id . '"]';
					echo $user_orders;

					$stmt = $pdo->prepare('UPDATE users
						 SET orders  = :orders
						 WHERE email = :email');

						$stmt->bindValue(':orders', $user_orders, PDO::PARAM_STR);
						$stmt->bindValue(':email', $logged_email, PDO::PARAM_STR);
						$stmt->execute();
						$stmt->closeCursor();

				}
				else {
					$user_orders_array = json_decode($user_orders);
					array_push($user_orders_array, $id);
					$user_orders = json_encode($user_orders_array);

					$stmt = $pdo->prepare('UPDATE users
						 SET orders  = :orders
						 WHERE email = :email');

						$stmt->bindValue(':orders', $user_orders, PDO::PARAM_STR);
						$stmt->bindValue(':email', $logged_email, PDO::PARAM_STR);
						$stmt->execute();
						$stmt->closeCursor();
				}
			}
		}
	}

	$cart_array = json_decode($cart);
	foreach($cart_array as & $item) {

		$stmt = $pdo->prepare('SELECT *
			FROM products
			WHERE id = :id');

			$stmt->bindValue(':id', $item, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch();

		$table = array(
			'name' => $row['name'],
			'price' => $row['price'],
			'cartDescription' => $row['cartDescription']
		);
		$productsjson = json_encode($table);
		$string = $productsjson;
		$html_list_products.= '<p class="product" style="padding: 0;margin: 10px;color: #000;border: 1px solid black;background-color: #fafafa">Nazwa: ' . $table['name'] . ' Cena: ' . $table['price'] . ' Opis: ' . $table['cartDescription'] . '</p>';
	}
	$stmt->closeCursor();

	$info_object = json_decode($info);
	foreach($info_object as & $item) {
		$html_list_info.= '<p class="info" style="padding: 0;margin: 10px;color: #000;border: 1px solid red;background-color: #fafafa">' . $item->{'name'} . ': ' . $item->{'value'} . '</p>';
	}

	$html = '<html>
  <head/>
  <body style="padding: 0;margin: 0;color: #000"><center><img src="cid:logo"><br />Lista zakupów:' . $html_list_products . "Informacje o kliencie" . $html_list_info . "</center>" . '
 </body>
</html>';
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
	$mail->SetFrom("mail", "Sickride");
	$mail->Subject = "Test";
	$mail->Body = $html;
	$mail->AddEmbeddedImage('img/logo.png', 'logo');
	$mail->AddAddress("mail", "Klient Sickride");
	if (!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
		$index++;
		if ($index < 5) $mail->Send();
	}
	else {
		echo "Message has been sent";
	}
}

if ($what == "is_cart_empty") {
	if (count(json_decode($_SESSION['cart'])) === 0) {
		$is_cart_empty = 1;
	}
	else {
		$is_cart_empty = 0;
	}

	$table = array(
		'is_cart_empty' => $is_cart_empty,
		'cart' => $_SESSION['cart']
	);
	$productsjson = json_encode($table);
	echo $productsjson;
}

if ($what == "get_cart_price") {
	$cart_price = 0;
	$cart = json_decode($_SESSION['cart']);
	if($cart != ""){
	foreach($cart as $id) {
    $stmt = $pdo->prepare('SELECT price
      FROM products
      WHERE id = :id');
  $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  $stmt->execute();
  	$row = $stmt->fetch();
		$price_item = $row['price'];
		$cart_price = $cart_price + $price_item;
	}

	echo $cart_price;
}
}

if ($what == "get_product_info") {

	$id = $_POST['id'];

	$stmt = $pdo->prepare('SELECT *
		FROM products
		WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch();

$properties = "";
if($row['properties'] != ""){
$properties = $row['properties'];
$properties = explode("#", $properties);
foreach ($properties as $key => $dat){
$properties[$key] = explode("=", $dat);
}
}

$table = array(
		'name' => $row['name'],
		'price' => $row['price'],
		'producer' => $row['producer'],
		'category' => $row['category'],
		'categoryid' => $row['categoryid'],
		'amount' => $row['amount'],
		'properties' => $properties,
		'cartDescription' => $row['cartDescription'],
		'shortDescription' => $row['shortDescription'],
		'longDescription' => $row['longDescription']
	);

	$stmt->closeCursor();
	$productsjson = json_encode($table);
	echo $productsjson;
}
if ($what == "get_user_info"){
	$stmt = $pdo->prepare('SELECT *
		FROM users
		WHERE email = :email');
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch();
$table = array(
		'first_name' => $row['firstname'],
		'last_name' => $row['lastname'],
		'email' => $row['email'],
		'phone_number' => $row['phonenumber'],
		'address' => $row['address'],
		'city' => $row['city'],
		'country' => $row['country'],
		'postal_code' => $row['postalcode']
	);
$productsjson = json_encode($table);
echo $productsjson;
}


if ($what == "get_orders_history_list"){
	$email = $_SESSION['email'];

		$stmt = $pdo->prepare('SELECT orders
			FROM users
			WHERE email = :email');
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
		$row = $stmt->fetch();
		$orders_json = $row['orders'];

		$orders_array = json_decode($orders_json, true);


	foreach($orders_array as $key => $id) {
		$stmt = $pdo->prepare('SELECT *
			FROM orders
			WHERE id = :id');
	$stmt->bindValue(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
		$row = $stmt->fetch();
		$table[$key] = array(
				'purchase_date' => $row['purchase_date'],
				'status' => $row['status'],
				'price' => $row['price'],
				'id' => $row['id']
			);
	}
	$productsjson = json_encode($table);
	echo $productsjson;
}
?>
