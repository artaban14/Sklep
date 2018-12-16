<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    REJESTRACJA
    <div class="register_container">
      <form class="register_form" action="login_system/register.php" method="post">
        
      <input type="email" name="email" value="" placeholder="Adres E-mail">
      <br>
      <input type="password" name="password" value="" placeholder="Hasło">
      <br>
      <input type="password" name="password_confirm" value="" placeholder="Powtórz hasło">
      <br>
      <input type="text" name="first_name" value="" placeholder="Imię">
      <br>
      <input type="text" name="last_name" value="" placeholder="Nazwisko">
      <br>
      <input type="text" name="address" value="" placeholder="Adres">
      <br>
      <input type="text" name="postal_code" value="" placeholder="Kod pocztowy">
      <br>
      <input type="text" name="city" value="" placeholder="Miasto">
      <br>
      <input type="text" name="country" value="" placeholder="Kraj">
      <br>
      <input type="text" name="phone_number" value="" placeholder="Numer telefonu">

      <input type="submit" name="register_post" value="Zarejestruj się" >
      </form>
    </div>
  </body>
</html>
