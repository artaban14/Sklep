<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Dodawnie produktu</title>
  </head>
  <body style="font-family: 'Lato', sans-serif;">

    <form id="uploadForm" method="post">

    <div id="uploadFormLayer">
    <input name="fileToUpload" type="file" class="inputFile"  /><br/>
    <input type="submit" value="Submit" class="btnSubmit" />
    </form>

    <div class="container" style="display: flex; justify-content: space-between;">


    <form class="" id="form_add_product">
      Dodaj Produkt: <br>
      <input type="text" name="name" placeholder="Nazwa" style="display: block; margin-top: 10px">
      <input type="text" name="category" placeholder="Kategoria" style="display: block; margin-top: 10px">
      <input type="text" name="categoryid" placeholder="ID kategorii" style="display: block; margin-top: 10px">
      <input type="text" name="producer" placeholder="Producent" style="display: block; margin-top: 10px">
      <input type="text" name="price" placeholder="Cena" style="display: block; margin-top: 10px">
      <input type="text" name="amount" placeholder="Ilość" style="display: block; margin-top: 10px">
      <input type="text" name="shortDescription" placeholder="Krótki opis" style="display: block; margin-top: 10px">
      <input type="text" name="longDescription" placeholder="Długi opis" style="display: block; margin-top: 10px">
      <input type="text" name="cartDescription" placeholder="Opis w koszyku" style="display: block; margin-top: 10px">
      <button id="btn_add_product" type="button" name="button">Dodaj produkt</button>
      <button id="clear_form" type="button" name="button">Wyczyść</button>
    </form>
    <div class="msg" style="background-color: #555555; width: 300px; height: 300px"></div>
    </div>
<br><br><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {

		    },
		  	error: function()
	    	{
	    	}
	   });
	}));
});


$("#clear_form").on("click", function(){
      $("#form_add_product").trigger('reset');
});
$("#btn_add_product").on("click", function(){
var items = $('#form_add_product').serializeArray();
console.log(items);
var data = JSON.stringify(items);
console.log(data);


  $.ajax({
   type: "POST",
   url: "admin_functions.php",
   data: { what: "add_product", data: data}
 }).done(function( msg ) {
    console.log("WIADOMOSĆ: "+msg);
    $(".msg").html(msg);
  });

});

$("body").on("click", ".menu_label", function(){
console.log(this.id);
var id = this.id.slice(4);
var name = $("#"+this.id).html();
console.log(id);
$("input[name=categoryid]").val(id);
$("input[name=category]").val(name);

});


</script>


  </body>
</html>

<?php
require_once 'config.php';
require_once 'dbfunctions.php';

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
$query = mysqli_query( $conn,"SELECT * FROM categories");
$table = null;
while($row = mysqli_fetch_assoc($query)){
 $arrayCategories[$row['id']] = array("parent_id" => $row['parent_id'], "name" =>
 $row['name'], "id" => $row['id']);
  }
// print_r($arrayCategories);
createTreeView($arrayCategories, 0);
echo "</ol>";
 ?>
