<?php

$wszystkoOK = true;
		
// imie
$imie = $_POST['imie'];
if(strlen($imie)<3 || strlen($imie)>50) $wszystkoOK = false;
$imie = htmlentities($imie,ENT_QUOTES,"UTF-8");
	
// nazwisko
$naz = $_POST['nazwisko'];
if(strlen($naz)<3 || strlen($naz)>50)	$wszystkoOK = false;
$naz = htmlentities($naz,ENT_QUOTES,"UTF-8");
		
// login
$login = $_POST['login'];
if(strlen($login)<3 || strlen($login)>20)	$wszystkoOK = false;
$login = htmlentities($login,ENT_QUOTES,"UTF-8");
		
// hasla
$haslo1 = $_POST['haslo1'];
$haslo2 = $_POST['haslo2'];
if(strlen($haslo1)<8 || strlen($haslo1)>20)	$wszystkoOK = false;
$haslo1 = htmlentities($haslo1,ENT_QUOTES,"UTF-8");
$haslo2 = htmlentities($haslo2,ENT_QUOTES,"UTF-8");
if($haslo1 != $haslo2)	$wszystkoOK = false;
$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

// email
$email = $_POST['email'];
$emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
if(filter_var($emailB,FILTER_VALIDATE_EMAIL) == false || $emailB != $email)	$wszystkoOK = false;

// telefon
$tele = $_POST['tele'];
if(strlen($tele)!= 9)	$wszystkoOK = false;
$tele = htmlentities($tele,ENT_QUOTES,"UTF-8");

// kod pocztowy
$kod = $_POST['kod'];
if(strlen($kod)!= 6)	$wszystkoOK = false;
$kod = htmlentities($kod,ENT_QUOTES,"UTF-8");

// miasto
$miasto = $_POST['miasto'];
if(strlen($miasto)<3)	$wszystkoOK = false;
$miasto = htmlentities($miasto,ENT_QUOTES,"UTF-8");

// wojewodztwo
$woje = $_POST['woje']; 

// miejscowosc
$miejsc = $_POST['miejsc'];
if(strlen($miejsc)<3)	$wszystkoOK = false;
$miejsc = htmlentities($miejsc,ENT_QUOTES,"UTF-8");

// ulica
$ulica = $_POST['ulica'];
if(strlen($ulica)<3)	$wszystkoOK = false;
$ulica = htmlentities($ulica,ENT_QUOTES,"UTF-8");

// numer domu
$nr_d = $_POST['nr_d'];
if(strlen($nr_d)<1)	$wszystkoOK = false;
$nr_d = htmlentities($nr_d,ENT_QUOTES,"UTF-8");

// numer mieszkania
$dom = false;
$nr_m = $_POST['nr_m'];
if(strlen($nr_m)<1) $dom = true;
else	$nr_m = htmlentities($nr_m,ENT_QUOTES,"UTF-8");

if($wszystkoOK == true) {
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno == 0) {
		// kody pocztowe - sprawdzenie i dodanie 
		$zapytanie = "SELECT id_kod FROM kod_pocztowy WHERE kod_po = '$kod'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$ile = mysqli_num_rows($rezultat);
		if ($ile>=1) {
			$row = mysqli_fetch_assoc($rezultat);
			$id_kod = $row['id_kod'];
		} else {
			$zapytanie = "INSERT INTO kod_pocztowy VALUES (NULL,'$kod','$miasto','$woje')";
			mysqli_query($polaczenie, $zapytanie);
			$zapytanie = "SELECT id_kod FROM kod_pocztowy WHERE kod_po = '$kod'";
			$rezultat = mysqli_query($polaczenie, $zapytanie);
			$row = mysqli_fetch_assoc($rezultat);
			$id_kod = $row['id_kod'];
		}
		
		// adres - sprawdzneie i dodanie
		if($dom) $zapytanie = "SELECT id_adres FROM adresy WHERE id_kod = '$id_kod' AND miejscowosc = '$miejsc' AND ulica = '$ulica' AND numer_domu = '$nr_d'";
		else $zapytanie = "SELECT id_adres FROM adresy WHERE id_kod = '$id_kod' AND miejscowosc = '$miejsc' AND ulica = '$ulica' AND numer_domu = '$nr_d' AND numer_mieszkania = '$nr_m'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$ile = mysqli_num_rows($rezultat);
		if ($ile>=1) {
			$row = mysqli_fetch_assoc($rezultat);
			$id_adres = $row['id_adres'];
		} else {
			if($dom) $zapytanie = "INSERT INTO adresy VALUES (NULL,'$id_kod','$miejsc','$ulica','$nr_d',NULL)";
			else $zapytanie = "INSERT INTO adresy VALUES (NULL,'$id_kod','$miejsc','$ulica','$nr_d','$nr_m')";
			mysqli_query($polaczenie, $zapytanie);
			if($dom) $zapytanie = "SELECT id_adres FROM adresy WHERE id_kod = '$id_kod' AND miejscowosc = '$miejsc' AND ulica = '$ulica' AND numer_domu = '$nr_d'";
			else $zapytanie = "SELECT id_adres FROM adresy WHERE id_kod = '$id_kod' AND miejscowosc = '$miejsc' AND ulica = '$ulica' AND numer_domu = '$nr_d' AND numer_mieszkania = '$nr_m'";
			$rezultat = mysqli_query($polaczenie, $zapytanie);
			$row = mysqli_fetch_assoc($rezultat);
			$id_adres = $row['id_adres'];
		}
		
		// klient - sprawdzanie i dodawanie 
		$zapytanie = "SELECT * FROM users WHERE user_login = '$login' AND user_email = '$email' AND id_adres = '$id_adres'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$ile = mysqli_num_rows($rezultat);
		if($ile == 0) {
			$zapytanie = "INSERT INTO users VALUES (NULL,'$imie','$naz','$login','$haslo_hash','$email','$id_adres','$tele')";
			mysqli_query($polaczenie, $zapytanie);
			header('Location: zaloguj.php');
			exit();
		}
	}
	$polaczenie->close();
}
header('Location: rejestracja.php');