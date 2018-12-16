<?php

require_once 'config.php';
require_once 'dbfunctions.php';
require_once 'connect_pdo.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/sickride/vendor/phpmailer/phpmailer/src/Exception.php';
require '/sickride/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/sickride/vendor/phpmailer/phpmailer/src/SMTP.php';

session_start();
$what  = $_POST['what'];
$item  = $_POST['item'];
$email = $_SESSION['email'];

if ($what == "add_category") {
    $data       = $_POST['data'];
    $json_array = json_decode($data, true);
    $data_array = array();
    for ($i = 0; $i < sizeof($json_array); $i++) {
        $key              = $json_array[$i]['name'];
        $data_array[$key] = $json_array[$i]['value'];
    }


    $add_date = date("Y-m-d H:i:s");


    $name      = filter($conn, $data_array['name']);
    $title     = filter($conn, $data_array['title']);
    $parent_id = filter($conn, $data_array['parent_id']);


    $stmt = $pdo->prepare('SELECT id
    FROM categories
    WHERE parent_id = :parent_id');
    $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_STR);
    $stmt->execute();
    $number_of_rows = $stmt->rowCount();


    $id_array = Array();

    if ($number_of_rows != 0) {



        foreach ($stmt as $row) {
            array_push($id_array, $row['id']);
        }
        sort($id_array);
        $last_item   = end($id_array);
        $last_number = end(explode("00", $last_item));
        $new_number  = $last_number + 1;
        $items       = explode("00", $last_item);
        array_pop($items);
        foreach ($items as &$value) {
            $new_category_id .= $value . '00';
        }
        $new_id = $new_category_id . $new_number;
    } else
        $new_id = $parent_id . "00" . "1";


    $stmt = $pdo->prepare('INSERT INTO categories (name, id, parent_id, title)    VALUES(
      :name,
      :new_id,
      :parent_id,
      :title
    )');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':new_id', $new_id, PDO::PARAM_STR);
    $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_STR);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);

    $stmt->execute();
    $stmt->closeCursor();


    echo "Pomyślnie kategorie!";
    echo "<br>";
    echo "<b>Nazwa</b> --------> $name <br>";
    echo "<b>Id</b> ----> $new_id <br>";
    echo "<b>Parent Id</b> ---------> $parent_id <br>";
    echo "<b>Długa nazwa</b> ----------> $title <br>";


}


if ($what == "add_product") {
    $data = $_POST['data'];

    $json_array = json_decode($data, true);
    $data_array = array();
    for ($i = 0; $i < sizeof($json_array); $i++) {
        $key              = $json_array[$i]['name'];
        $data_array[$key] = $json_array[$i]['value'];
    }


    $add_date = date("Y-m-d H:i:s");


    $name             = filter($conn, $data_array['name']);
    $category         = filter($conn, $data_array['category']);
    $categoryid       = filter($conn, $data_array['categoryid']);
    $producer         = filter($conn, $data_array['producer']);
    $price            = filter($conn, $data_array['price']);
    $amount           = filter($conn, $data_array['amount']);
    $shortDescription = filter($conn, $data_array['shortDescription']);
    $longDescription  = filter($conn, $data_array['longDescription']);
    $cartDescription  = filter($conn, $data_array['cartDescription']);


    $stmt = $pdo->prepare('SELECT id
      FROM products
      WHERE categoryid = :categoryid');
    $stmt->bindValue(':categoryid', $categoryid, PDO::PARAM_STR);
    $stmt->execute();

    $id_array = array();
    foreach ($stmt as $row) {
        array_push($id_array, $row['id']);
    }

    sort($id_array);
    $last_item   = end($id_array);
    $last_number = end(explode("00", $last_item));
    $new_number  = $last_number + 1;
    $items       = explode("00", $last_item);
    array_pop($items);
    if (count($items) > 1) {
        foreach ($items as &$value) {
            $new_category_id .= $value . '00';
            $new_id = $new_category_id . $new_number;
        }
    } else {
        $new_id = $categoryid . '00' . $new_number;
    }


    $stmt = $pdo->prepare('SELECT name
    FROM products
    WHERE name = :name');

    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    $stmt->closeCursor();

    if ($count == 0) {

        $stmt = $pdo->prepare('INSERT INTO products (id, addDate, name, category, categoryid, producer, price, amount, shortDescription, longDescription, cartDescription)    VALUES(
           :id,
         :add_date,
         :name,
         :category,
         :categoryid,
         :producer,
         :price,
         :amount,
         :shortDescription,
         :longDescription,
         :cartDescription
          )');
        $stmt->bindValue(':id', $new_id, PDO::PARAM_STR);
        $stmt->bindValue(':add_date', $add_date, PDO::PARAM_STR);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':categoryid', $categoryid, PDO::PARAM_STR);
        $stmt->bindValue(':producer', $producer, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':shortDescription', $shortDescription, PDO::PARAM_STR);
        $stmt->bindValue(':longDescription', $longDescription, PDO::PARAM_STR);
        $stmt->bindValue(':cartDescription', $cartDescription, PDO::PARAM_STR);


        $stmt->execute();
        $stmt->closeCursor();

        if (1) {
            echo "Pomyślnie dodano produkt!";
            echo "<br>";
            echo "<b>Nazwa</b> --------> $name <br>";
            echo "<b>Kategoria</b> ----> $category <br>";
            echo "<b>Cena</b> ---------> $price <br>";
            echo "<b>Ilość</b> ----------> $amount <br>";
            echo "<b>Krótki opis</b> ---> $shortDescription <br>";
            echo "<b>Długi opis</b> ----> $longDescription <br>";
            echo "<b>Koszyk opis</b> --> $cartDescription <br>";
        } else {
        }

    } else {
        echo "<font size=5><center>BŁĄD</center></font>";
        echo "Nie dodano produktu<br>";
        echo "Istnieje produkt o takiej nazwie<br>";
        echo "<b>Nazwa</b> --------> $name";
    }
}

if ($what == "get_products") {
    if ($_POST['category'] != "") {
        $getcat = explode("00", $_POST['category']);
        $lenght = count($getcat);
    }

    $stmt = $pdo->query('SELECT * FROM products');
    foreach ($stmt as $row) {
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
    $stmt       = $pdo->query('SELECT * FROM `products`');
    foreach ($stmt as $row) {
        if (strpos($row['name'], $expression) || strpos($row['name'], $expression) === 0) {
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
        } else {
        }
    }
    $stmt->closeCursor();
    $productsjson = json_encode($table);
    echo $productsjson;
}

if ($what == "get_product_cart_info") {
    $id = $_POST['id'];

    $stmt = $pdo->prepare('SELECT *
    FROM products
    WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();

    $table = array(
        'name' => $row['name'],
        'price' => $row['price'],
        'cartDescription' => $row['cartDescription']
    );

    $stmt->closeCursor();
    $productsjson = json_encode($table);
    echo $productsjson;
}

if ($what == "list_shipment") {

    $stmt = $pdo->query('SELECT * FROM `shipment`');
    foreach ($stmt as $row) {

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


?>
