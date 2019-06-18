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
<h1>Wykaz Zamówień</h1>

<?php 
require_once 'config.php';
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_SESSION['search_zam']) && $_SESSION['search_zam'] != "") {
	$id = $_SESSION['search_zam'];
	unset($_SESSION['search_zam']);
	$zapytanie = "SELECT * FROM zamowienie_widok WHERE id_zamowienia = '$id'";
} else $zapytanie = "SELECT * FROM zamowienie_widok ORDER BY id_zamowienia ASC";
$rezultat = mysqli_query($polaczenie, $zapytanie);
$ile = mysqli_num_rows($rezultat);
if ($ile>=1) {
	echo "<div class='tabela'><div class='row'>
	<div class='colk' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>ID</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>ID Klienta</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Data Zamówienia</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Kurier</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Wartość</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Status</div>
	<div style='clear:both;'></div></div>
	";
	for ($i = 1; $i <= $ile; $i++) 
	{
		$row = mysqli_fetch_assoc($rezultat);
		$id = $row['id_zamowienia'];
		$klient = $row['id_klienta'];
		$data = $row['data_zamowienia'];
		$kurier = $row['kurier'];
		$cena = $row['wartosc'];
		$status = $row['status_zamowienia'];
		switch($status) {
			case "1": $status = "Złożone"; break;
			case "2": $status = "W realizacji"; break;
			case "3": $status = "Gotowe do wysyłki"; break;
			case "4": $status = "Wysłane"; break;
			case "5": $status = "Zakończone"; break;
		}
		
		echo "<div class='row'>
		<div class='colk'>".$id."</div>
		<div class='cols'>".$klient."</div>
		<div class='cols'>".$data."</div>
		<div class='cols'>".$kurier."</div>
		<div class='cols'>"; printf ("%.2f", $cena); echo "zł</div>
		<div class='cols'>".$status."  ";
		if($status != "Zakończone") echo "<a href='update_status.php?id=".$id."'><img src='../img/plus.jpg' height='10px'/></a>";
		echo "</div><div style='clear:both;'></div></div>";
	}
	echo "</div>";
}
?>
</div>

<div class='piece'>
<h1>Wyszukaj Zamowienie</h1>
<form action="search.php" method="post">
	<div class='namek'>ID Zamówienia</div><input type="text" name="id_zam"/><br/><br/>
	<input type="submit" value="Wyszukaj"/>
</form>
</div>

</body>

<!--  -->
</html>