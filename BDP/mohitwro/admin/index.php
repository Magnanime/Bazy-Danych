<?php
	session_start();
	
	if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: main.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <title>MOHITwrO - Sklep Internetowy</title> 
	<meta name="description" content="Strona internetowa oraz sklep najlepszego sklepu elektronicznego we Wrocławiu. Znajdź na stronie i wybierz coś dla siebie." />
    <link rel="stylesheet" href="./style/style.css" type="text/css"/>
  </head>
  <body>

<form class="box" action="login_admin.php" method="post">
  <h1>Panel admina</h1>
  <input type="text" name="login" placeholder="Nazwa użytkownika">
  <input type="password" name="haslo" placeholder="Hasło">
  <input type="submit" name="submit" value="Login">
</form>


  </body>
</html>