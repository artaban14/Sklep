<?php
    define('DB_SERVER', 'server');
    define('DB_USERNAME', 'username');
    define('DB_PASSWORD', 'pass');
    define('DB_NAME', 'name');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    mysqli_query($conn,"SET CHARACTER SET 'utf8'");
    mysqli_query($conn,"SET SESSION collation_connection ='utf8_unicode_ci'");

    if($conn === false){
       die("ERROR: Could not connect. " . mysqli_connect_error());
     }
     else{
     }




    ?>
