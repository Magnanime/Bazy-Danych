<?php
session_start();
$klient = $_SESSION['id'];
$dostawca = $_GET['dos'];
$status = 1;

require_once "config.php";
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno == 0) {
	// koszt calkowity
	$zapytanie = "SELECT cena FROM koszyk WHERE kto = '$klient'";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>0)	for ($i = 1; $i <= $ile; $i++) {
		$row = mysqli_fetch_assoc($rezultat);
		$sum += $row['cena'];
	} else header("Location: cart.php");
	$koszt = $sum;
	// dodanie zamowienia
	$zapytanie = "INSERT INTO zamowienia VALUES (NULL,'$klient',now(),'$dostawca','$koszt','$status')";
	mysqli_query($polaczenie, $zapytanie);
	// id zamowienia
	$zapytanie = "SELECT id_zamowienia FROM zamowienia WHERE id_user = '$klient' ORDER BY id_zamowienia DESC";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>0) {
		$row = mysqli_fetch_assoc($rezultat);
		$id_zam = $row['id_zamowienia'];
	}
	// dodanie szczegolow zamowienia
	$zapytanie = "SELECT id, ilosc, cena FROM koszyk WHERE kto = '$klient'";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>0)	for ($i = 1; $i <= $ile; $i++) {
		$row = mysqli_fetch_assoc($rezultat);
		$id_prod = $row['id'];
		$ilosc = $row['ilosc'];
		$cena = $row['cena'];
		$zapytanie = "INSERT INTO det_zam VALUES (NULL,'$id_zam','$id_prod','$ilosc','$cena')";
		mysqli_query($polaczenie, $zapytanie);
		
		$zapytanie = "SELECT dostepnosc FROM towar WHERE id = '$id_prod'";
		$rezultatp = mysqli_query($polaczenie, $zapytanie);
		$ilep = mysqli_num_rows($rezultatp);
		if ($ilep>0) {
			$rowp = mysqli_fetch_assoc($rezultatp);
			$dostep = $rowp['dostepnosc'] - $ilosc;
			$zapytanie = "UPDATE produkty SET stan_magazynowy = '$dostep' WHERE id_produkt = '$id_prod'";
			mysqli_query($polaczenie, $zapytanie);
		}
		
		$zapytanie = "DELETE FROM koszyk WHERE kto = '$klient' AND id = '$id_prod'";
		mysqli_query($polaczenie, $zapytanie);
		
	}	else header("Location: cart.php");
	
}
header("Location: konto_user.php");


