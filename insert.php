<?php
//insert.php
$connect = mysqli_connect("localhost", "root", "", "test");
if(isset($_POST["person_name"]))
{
 $person_name = $_POST["person_name"];
 $person_surname = $_POST["person_surname"];
 $person_company = $_POST["person_company"];
 $person_phone = $_POST["person_phone"];
 $person_email = $_POST["person_email"];
 $person_web = $_POST["person_web"];
 $query = '';
 for($count = 0; $count<count($person_name); $count++)
 {
  $person_name_clean = mysqli_real_escape_string($connect, $person_name[$count]);
  $person_surname_clean = mysqli_real_escape_string($connect, $person_surname[$count]);
  $person_company_clean = mysqli_real_escape_string($connect, $person_company[$count]);
  $person_phone_clean = mysqli_real_escape_string($connect, $person_phone[$count]);
  $person_email_clean = mysqli_real_escape_string($connect, $person_email[$count]);
  $person_web_clean = mysqli_real_escape_string($connect, $person_web[$count]);
  if($person_name_clean != '' && $person_surname_clean != '' && $person_email_clean != '')
  {
   $query .= '
   INSERT INTO item(person_name, person_surname, person_company, person_phone, person_email, person_web) 
   VALUES("'.$person_name_clean.'", "'.$person_surname_clean.'", "'.$person_company_clean.'", "'.$person_phone_clean.'", "'.$person_email_clean.'","'.$person_web_clean.'"); 
   ';
  }
 }
 if($query != '')
 {
  if(mysqli_multi_query($connect, $query))
  {
   echo 'Kontakti pievienoti';
  }
  else
  {
   echo 'Error';
  }
 }
 else
 {
  echo 'Obligāti ievadi vārdu, uzvārdu un epastu!';
 }
}
?>
