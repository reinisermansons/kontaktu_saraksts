<?php
session_start();
require 'database.php';
if( isset($_SESSION['user_id']) ){
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$user = NULL;
	if( count($results) > 0){
		$user = $results;
	}
}
?>


<!DOCTYPE html>

<html>
 <head>
  <title>Kontaktu saraksts</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
  
 </head>
 <body>
 <?php if( !empty($user) ): ?>

		<br />Sveicināti! <?= $user['email']; ?> 
		<br /><br />Autorizēšanās sekmīga!!
		<br /><br />
		<a href="logout.php">Iziet?</a>

	<?php else: ?>

		<h1>Lūdzu autorizējaties!</h1>
		<a href="login.php">Ienākt</a>

	<?php endif; ?>

  <br /><br />
  <div class="container">

   <br />
   <h2 align="center">Kontaktu pievienošana datubāzei</h2>
   <br />
   <div class="table-responsive">
    <table class="table table-bordered" id="crud_table">
     <tr>
      <th width="15%">Vārds</th>
      <th width="15%">Uzvārds</th>
      <th width="20%">Uzņēmums</th>
      <th width="15%">Telefona nr.</th>
	  <th width="15%">Epasts</th>
	  <th width="15%">Mājaslapa</th>
      <th width="5%"></th>
     </tr>
     <tr>
      <td contenteditable="true" class="person_name"></td>
      <td contenteditable="true" class="person_surname"></td>
      <td contenteditable="true" class="person_company"></td>
      <td contenteditable="true" class="person_phone"></td>
	  <td contenteditable="true" class="person_email"></td>
	  <td contenteditable="true" class="person_web"></td>
      <td></td>
     </tr>
    </table>
    <div align="right">
     <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
    </div>
    <div align="center">
     <button type="button" name="save" id="save" class="btn btn-info">Pievienot</button>
    </div>
    <br />
    <div id="inserted_item_data"></div>
   </div>
   
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td contenteditable='true' class='person_name'></td>";
   html_code += "<td contenteditable='true' class='person_surname'></td>";
   html_code += "<td contenteditable='true' class='person_company'></td>";
   html_code += "<td contenteditable='true' class='person_phone'></td>";
    html_code += "<td contenteditable='true' class='person_email'></td>";
	 html_code += "<td contenteditable='true' class='person_web' ></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";  
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var person_name = [];
  var person_surname = [];
  var person_company = [];
  var person_phone = [];
  var person_email = [];
  var person_web = [];
  $('.person_name').each(function(){
   person_name.push($(this).text());
  });
  $('.person_surname').each(function(){
   person_surname.push($(this).text());
  });
  $('.person_company').each(function(){
   person_company.push($(this).text());
  });
  $('.person_phone').each(function(){
   person_phone.push($(this).text());
  });
    $('.person_email').each(function(){
   person_email.push($(this).text());
  });
    $('.person_web').each(function(){
   person_web.push($(this).text());
  });
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:{person_name:person_name, person_surname:person_surname, person_company:person_company, person_phone:person_phone, person_email:person_email, person_web:person_web},
   success:function(data){
    alert(data);
    $("td[contentEditable='true']").text("");
    for(var i=2; i<= count; i++)
    {
     $('tr#'+i+'').remove();
    }
    fetch_item_data();
   }
  });
 });
 
 function fetch_item_data()
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   success:function(data)
   {
    $('#inserted_item_data').html(data);
   }
  })
 }
 fetch_item_data();
 
});
</script>
