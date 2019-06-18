<?php
session_start();
if((!isset($_SESSION['log'])) || (!$_SESSION['log']==true))
{
	header("Location: zaloguj.php");
	exit();
}

$klient = $_SESSION['id'];
$id = $_GET['id'];
$nazwa = $_GET['nazwa'];
$cena = $_GET['cena'];
$ilosc = $_GET['ilosc'];
echo $ilosc."<br>";

require_once "config.php";
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno == 0) {
	$zapytanie = "SELECT * FROM koszyk WHERE id = '$id' AND kto = '$klient'";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile==1) {
		$row = mysqli_fetch_assoc($rezultat);
		$i = $row['ilosc'];
		$c = $row['cena'];
		if(!isset($_GET['kosz'])) $ilosc = $row['ilosc'] + $ilosc;
		$cena = $ilosc * ($c/$i);
		echo $cena;
		$zapytanie = "UPDATE koszyk SET ilosc = '$ilosc', cena = '$cena' WHERE id = '$id' AND kto = '$klient'";
		mysqli_query($polaczenie, $zapytanie);
	} else {
		$zapytanie = "INSERT INTO koszyk VALUES ('$klient','$id','$nazwa','$ilosc','$cena')";
		mysqli_query($polaczenie, $zapytanie);
	}
	header("Location: cart.php");
	exit();
}
$text = "Location: przedmiot.php?id='".$id."'";
header($text);