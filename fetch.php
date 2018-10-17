<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "test");
$output = '';
$query = "SELECT * FROM item ORDER BY item_id DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<h3 align="center">Kontakti datubāzē</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th width="15%">Vārds</th>
  <th width="15%">Uzvārds</th>
  <th width="25%">Uzņēmums</th>
  <th width="15%">Telefona nr.</th>
  <th width="15%">Epasts</th>
  <th width="15%">Mājaslapa</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["person_name"].'</td>
  <td>'.$row["person_surname"].'</td>
  <td>'.$row["person_company"].'</td>
  <td>'.$row["person_phone"].'</td>
  <td>'.$row["person_email"].'</td>
  <td>'.$row["person_web"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>

