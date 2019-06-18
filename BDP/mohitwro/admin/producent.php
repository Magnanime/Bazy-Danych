<?php
	session_start();
	
	if((!isset($_SESSION['logged'])) && ($_SESSION['logged']==false))
	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/> 	
	<title>MOHITwrO - Sklep Internetowy</title> 
	<meta name="description" content="Strona internetowa oraz sklep najlepszego sklepu elektronicznego we Wrocławiu. Znajdź na stronie i wybierz coś dla siebie." /> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<link rel="stylesheet" href="./style/admin.css" type="text/css"/>
	
</head>

<body>
<header>
	<a href="produkty.php"><div class='menu'>Produkty</div></a>
	<a href="kategorie.php"><div class='menu'>Kategorie</div></a>
	<a href="producent.php"><div class='menu'>Producenci</div></a>
	<a href="zamowienia.php"><div class='menu'>Zamówienia</div></a>
	<a href="det_zamowienia.php"><div class='menu'>Detale Zamówienia</div></a>
	<a href="klienci.php"><div class='menu'>Klienci</div></a>
	<a href="outlog_admin.php"><div class='menu'>Wyloguj się</div></a>
	<div style="clear:both;"></div>
</header><div style='height: 55px;'></div>

<div class='piece'>
<h1>Wykaz Producentów</h1>

<?php 
require_once 'config.php';
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_SESSION['search_fac']) && $_SESSION['search_fac'] != "") {
	$id = $_SESSION['search_fac'];
	unset($_SESSION['search_fac']);
	$zapytanie = "SELECT * FROM producenci WHERE id_producent = '$id'";
} else $zapytanie = "SELECT * FROM producenci ORDER BY id_producent ASC";
$rezultat = mysqli_query($polaczenie, $zapytanie);
$ile = mysqli_num_rows($rezultat);
if ($ile>=1) {
echo "<div class='tabela'><div class='row'>
	<div class='colk' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>ID</div>
	<div class='cold' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Producent</div>
	<div style='clear:both;'></div></div>
	";
	for ($i = 1; $i <= $ile; $i++) 
	{
		$row = mysqli_fetch_assoc($rezultat);
		$id = $row['id_producent'];
		$nazwa = $row['nazwa'];
		
		echo "<div class='row'>
		<div class='colk'>".$id."</div>
		<div class='cold'>".$nazwa."</div>
		<div style='clear:both;'></div></div>";
	}
	echo "</div>";
}
?>
</div>

<div class='piece'>
<h1>Wyszukaj Producenta</h1>
<form action="search.php" method="post">
	<div class='namek'>ID Producenta</div> <input type="text" name="id_f"/><br/><br/>
	<input type="submit" value="Wyszukaj"/>
</form>
</div>

<div class='piece'>
<h1>Dodaj Producenta</h1>
<form action="add_factory.php" method="post">
	<div class='namek'>Nazwa Producenta</div> <input type="text" name="nazwa"/><br/><br/>
	<input type="submit" value="Dodaj"/>
</form>
</div>

<div class='piece'>
<h1>Zaktualizuj Producenta</h1>
<form action="update_factory.php" method="post">
	<div class='namek'>ID Producenta</div><input type="text" name="id"/><br/><br/>
	<div class='namek'>Nazwa Producenta</div><input type="text" name="nazwa"/><br/><br/>
	<input type="submit" value="Zmien"/>
</form>
</div>

</body>

<!--  -->
</html>