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
if(isset($_SESSION['search_klient']) && $_SESSION['search_klient'] != "") {
	$id = $_SESSION['search_klient'];
	unset($_SESSION['search_klient']);
	$zapytanie = "SELECT * FROM klient_info WHERE id = '$id'";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
$ile = mysqli_num_rows($rezultat);
if ($ile>=1) {
echo<<<END
<table width="1300" align="center" border="1" bordercolor="#d5d5d5" cellpadding="0" cellspacing="0">     
<tr>
<td width="50" align="center" bgcolor="e5e5e5">ID</td>
<td width="100" align="center" bgcolor="e5e5e5">Imię</td>
<td width="100" align="center" bgcolor="e5e5e5">Nazwisko</td>
<td width="100" align="center" bgcolor="e5e5e5">Telefon</td>
<td width="200" align="center" bgcolor="e5e5e5">E-mail</td>
<td width="100" align="center" bgcolor="e5e5e5">Kod Pocztowy</td>
<td width="125" align="center" bgcolor="e5e5e5">Miasto</td>
<td width="150" align="center" bgcolor="e5e5e5">Województwo</td>
<td width="125" align="center" bgcolor="e5e5e5">Miejscowość</td>
<td width="150" align="center" bgcolor="e5e5e5">Ulica</td>
<td width="50" align="center" bgcolor="e5e5e5">Nr D</td>
<td width="50" align="center" bgcolor="e5e5e5">Nr M</td>
</tr><tr>
END;
	for ($i = 1; $i <= $ile; $i++) 
	{
		$row = mysqli_fetch_assoc($rezultat);
		$id = $row['id'];
		$imie = $row['imie'];
		$naz = $row['nazwisko'];
		$telefon = $row['telefon'];
		$email = $row['email'];
		$kod = $row['kod_poc'];
		$miasto = $row['miasto'];
		$woje = $row['wojewodztwo'];
		$miejsc = $row['miejscowosc'];
		$ulica = $row['ulica'];
		$nr_domu = $row['nr_domu'];
		$nr_mie = $row['nr_mieszkania'];
			
echo<<<END
<td width="50" align="center">$id</td>
<td width="50" align="center">$imie</td>
<td width="50" align="center">$naz</td>
<td width="100" align="center">$telefon</td>
<td width="50" align="center">$email</td>
<td width="50" align="center">$kod</td>
<td width="50" align="center">$miasto</td>
<td width="50" align="center">$woje</td>
<td width="50" align="center">$miejsc</td>
<td width="50" align="center">$ulica</td>
<td width="50" align="center">$nr_domu</td>
<td width="50" align="center">$nr_mie</td>
</tr><tr>
END;
	}
$polaczenie->close();
}
}

?>


<div class='piece'>
<h1>Wyszukaj Klienta</h1>
<form action="search.php" method="post">
	<div class='namek'>ID Klienta</div> <input type="text" name="id_u"/><br/><br/>
	<input type="submit" value="Wyszukaj"/>
</form>
</div>
</body>

<!--  -->
</html>