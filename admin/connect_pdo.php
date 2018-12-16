<?php
$mysql_host = 'host';
$port = '3306';
$username = 'username';
$password = 'pass';
$database = 'name';

try{
	$pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$database.';charset=utf8', $username, $password );
  // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo -> query ('SET NAMES utf8');
  $pdo -> query ('SET CHARACTER_SET utf8_unicode_ci');
}catch(PDOException $e){
  exit();
}
if(version_compare(phpversion(), '6.0.0-dev', '<'))
{

  function removeSlashes(&$value){
    if(is_array($value))
    {
      return array_map('removeSlashes', $value);
    }
    else
    {
      return stripslashes($value);
    }
  }

  set_magic_quotes_runtime(0);

  if(get_magic_quotes_gpc())
  {
    $_POST = array_map('removeSlashes', $_POST);
    $_GET = array_map('removeSlashes', $_GET);
    $_COOKIE = array_map('removeSlashes', $_COOKIE);
  }
}

?>
