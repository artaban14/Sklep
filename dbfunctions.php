<?php

function filter($conn, $string){
$filtered = mysqli_real_escape_string($conn, htmlspecialchars(trim($string)));
return $filtered;

}


?>
