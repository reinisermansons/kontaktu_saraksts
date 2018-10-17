<?php
session_start();
if( isset($_SESSION['user_id']) ){
	header("Location: /");
}
require 'database.php';
if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$message = '';
	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){
		$_SESSION['user_id'] = $results['id'];
		header("Location: index.php");
	} else {
		$message = 'Atvainojiet, autorizēšanās nav bijusi pareiza!';
	}
endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Kontaktu saraksts</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Kontaktu datubāze</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Ienākt</h1>
	

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Ievadi epastu" name="email">
		<input type="password" placeholder="Ievadi paroli" name="password">

		<input type="submit">

	</form>

</body>
</html>