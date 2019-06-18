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
<h1>Pokaż Szczegóły Zamówienia</h1>
<form action="search.php" method="post">
	<div class='namek'>ID Zamówienia</div> <input type="text" name="id_det"/><br/><br/>
	<input type="submit" value="Pokaż"/>
</form>
</div>



<div class='piece'>
<?php 
require_once 'config.php';
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_SESSION['search_det']) && $_SESSION['search_det'] != "") {
	$id = $_SESSION['search_det'];
	unset($_SESSION['search_det']);
	$zapytanie = "SELECT * FROM det_zam WHERE id_zamowienia = '$id' ORDER BY id_produkt ASC";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>=1) {
echo "<h1>Szczegóły Zamówienia</h1><div class='tabela'><div class='row'>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>ID Produktu</div>
	<div class='cold' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Nazwa Produktu</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Sztuk</div>
	<div class='cols' style='font-weight: bolder; text-transform: uppercase; background-color:#3EE300;'>Wartość</div>
	<div style='clear:both;'></div></div>
	";
	for ($i = 1; $i <= $ile; $i++) 
	{
		$row = mysqli_fetch_assoc($rezultat);
		$id_p = $row['id_produkt'];
		$sztuki = $row['liczba'];
		$cena = $row['wartosc'];
		
		$zapytanie = "SELECT nazwa FROM towar WHERE id = '$id_p'";
		$rezultatp = mysqli_query($polaczenie, $zapytanie);
		$ilep = mysqli_num_rows($rezultatp);
		if($ilep > 0) {
			$rowp = mysqli_fetch_assoc($rezultatp);
			$nazwa = $rowp['nazwa'];
			
			echo "<div class='row'>
			<div class='cols' style='height: 75px'>#".$id_p."</div>
			<div class='cold' style='height: 75px'>".$nazwa."</div>
			<div class='cols' style='height: 75px'>".$sztuki."</div>
			<div class='cols' style='height: 75px'>"; printf ("%.2f", $cena); echo " zł</div>
			<div style='clear:both;'></div></div>";
		}
		
	}
	echo "</div>";
	}
}
?>
</div>

</body>

<!--  -->
</html>