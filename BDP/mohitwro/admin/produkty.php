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

<?php 
require_once 'config.php';
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_SESSION['search_produkt']) && $_SESSION['search_produkt'] != "") {
	$id = $_SESSION['search_produkt'];
	unset($_SESSION['search_produkt']);
	$zapytanie = "SELECT * FROM towar WHERE id = '$id'";
} else $zapytanie = "SELECT * FROM towar ORDER BY id ASC";
$rezultat = mysqli_query($polaczenie, $zapytanie);
$ile = mysqli_num_rows($rezultat);
if ($ile>=1) {	
echo"<table width='1200' align='center' border='1' bordercolor='#d5d5d5' cellpadding='0' cellspacing='0' style='margin: auto;'>     
<tr>
<td width='25' align='center' bgcolor='e5e5e5'>ID</td>
<td width='50' align='center' bgcolor='e5e5e5'>Kategoria</td>
<td width='100' align='center' bgcolor='e5e5e5'>Nazwa</td>
<td width='50' align='center' bgcolor='e5e5e5'>Producent</td>
<td width='75' align='center' bgcolor='e5e5e5'>Cecha</td>
<td width='50' align='center' bgcolor='e5e5e5'>Cena</td>
<td width='100' align='center' bgcolor='e5e5e5'>Obraz</td>
<td width='50' align='center' bgcolor='e5e5e5'>Dostępność</td>
<td width='450' align='center' bgcolor='e5e5e5'>Opis</td>
</tr><tr>";
	for ($i = 1; $i <= $ile; $i++) 
	{
		$row = mysqli_fetch_assoc($rezultat);
		$id = $row['id'];
		$kat = $row['kategoria'];
		$nazwa = $row['nazwa'];
		$producent = $row['producent'];
		$cecha = $row['cecha'];
		$cena = $row['cena'];
		$obraz = $row['obraz'];
		$stan_magazynowy = $row['dostepnosc'];
		$opis = $row['opis'];
			
echo "<td width='25' align='center'>$id</td>
<td width='50' align='center'>$kat</td>
<td width='100' align='center'>$nazwa</td>
<td width='50' align='center'>$producent</td>
<td width='50' align='center'>$cecha</td>
<td width='75' align='center'>$cena zł</td>
<td width='50' align='center'>$obraz</td>
<td width='50' align='center'>$stan_magazynowy</td>
<td width='450' align='center'>$opis</td>
</tr><tr>";
	}
$polaczenie->close();
}
?>

<div class='piece'>
<h1>Wyszukaj Produkt</h1>
<form action="search.php" method="post">
	ID Produktu: <input type="text" name="id_p"/><br/><br/>
	<input type="submit" value="Wyszukaj"/>
</form>
</div>

<div class='piece'>
<h1>Dodaj Produkt</h1>
<form action="add_product.php" method="post">
	Kategoria: <select name="kategoria">
	<?php 
	require_once 'config.php';
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	$zapytanie = "SELECT * FROM kategorie";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>=1) {
		for ($i = 1; $i <= $ile; $i++) {
			$row = mysqli_fetch_assoc($rezultat);
			$nazwa = $row['nazwa'];
			echo "<option>$nazwa</option>";
		}
	}
	?>
	</select>
	<br><br>
	Nazwa Produktu: <input type="text" name="nazwa"/><br/><br/>
	Producent: <select name="producent">
	<?php 
	require_once 'config.php';
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	$zapytanie = "SELECT * FROM producenci";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>=1) {
		for ($i = 1; $i <= $ile; $i++) {
			$row = mysqli_fetch_assoc($rezultat);
			$nazwa = $row['nazwa'];
			echo "<option>$nazwa</option>";
		}
	}
	?>
	</select>
	<br><br>
	Cecha: <input type="text" name="cecha"/><br/><br/>
	Cena: <input type="text" name="cena"/>zł<br/><br/>
	Obraz: <input type="text" name="obraz"/><br/><br/>
	Stan Magazynowy: <input type="text" name="liczba"/><br/><br/>
	Opis: <textarea name="opis" cols="40" rows="5"></textarea><br/><br/>
	<input type="submit" value="Dodaj"/>
</form>
</div>

<div class='piece'>
<h1>Zaktualizuj Produkt</h1>
<form action="update_produkt.php" method="post">
	ID Produktu: <input type="text" name="id"/><br/><br/>
	Nazwa Produktu: <input type="text" name="nazwa"/><br/><br/>
	Cecha: <input type="text" name="cecha"/><br/><br/>
	Cena: <input type="text" name="cena"/>zł<br/><br/>
	Obraz: <input type="text" name="obraz"/><br/><br/>
	Stan Magazynowy: <input type="text" name="liczba"/><br/><br/>
	Opis: <textarea name="opis" cols="40" rows="5"></textarea><br/><br/>
	<input type="submit" value="Zmien"/>
</form>
</div>


</body>

<!--  -->
</html>