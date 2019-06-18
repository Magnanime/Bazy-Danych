<?php
session_start();
if((!isset($_SESSION['log'])) || (!$_SESSION['log']==true)) {
	header('Location: zaloguj.php');
	exit();
}

require_once "config.php";
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno==0) {
	$countu = 0;
	$countk = 0;
	$counta = 0;
	$textu = "";
	$textk = "";
	$texta = "";
	$id = $_SESSION['id'];
	
	// imie
	if(strlen($_POST['imie'])>3) {
		$a = $_POST['imie'];
		if(strlen($a)>3 && strlen($a)<50) {
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			$textu .= " user_imie = '$a'";
			$countu++;
		}	
	}
	
	// nazwisko
	if(strlen($_POST['nazwisko'])>3) {
		$a = $_POST['nazwisko'];
		if(strlen($a)>3 && strlen($a)<50)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($countu>0) $textu .= ",";
			$textu .= " user_nazwisko = '$a'";
			$countu++;
		}	
	}
	
	// haslo
	if(strlen($_POST['haslo1'])>8 && strlen($_POST['haslo2'])>8) {
		$a = $_POST['haslo1'];
		$b = $_POST['haslo2'];
		if(strlen($a)>8 && strlen($a)<20)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			$b = htmlentities($b,ENT_QUOTES,"UTF-8");
			if($a == $b)	{
				$a_hash = password_hash($a, PASSWORD_DEFAULT);
				if($countu>0) $textu .= ",";
				$textu .= " user_password = '$a_hash'";
				$countu++;
			}
		}
	}
	
	// email
	if(strlen($_POST['email'])>5) {
		$a = $_POST['email'];
		$b = filter_var($a,FILTER_SANITIZE_EMAIL);
		if(filter_var($b,FILTER_VALIDATE_EMAIL) == true && $b == $a)	{
			if($countu>0) $textu .= ",";
			$textu .= " user_email = '$a'";
			$countu++;
		}
	}
	
	// telefon
	if(strlen($_POST['tele']) == 9) {
		$a = $_POST['tele'];
		$a = htmlentities($a,ENT_QUOTES,"UTF-8");
		if(strlen($a)== 9)	{
			if($countu>0) $textu .= ",";
			$textu .= " user_phone = '$a'";
			$countu++;
		}
	}
	
	if($countu != 0) {
		$zapytanie = "UPDATE users SET ";
		$zapytanie .= $textu;
		$zapytanie .= " WHERE id_user = '$id'";
		mysqli_query($polaczenie, $zapytanie);
	}
	
	
	
	
	// kod pocztowy
	if(strlen($_POST['kod']) == 6) {
		$a = $_POST['kod'];
		if(strlen($a) == 6)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			$textk .= " kod_po = '$a'";
			$countk++;
		}
	}
	
	// miasto
	if(strlen($_POST['miasto'])>3) {
		$a = $_POST['miasto'];
		if(strlen($a)>3)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($countk>0) $textk .= ",";
			$textk .= " miasto = '$a'";
			$countk++;
		}
	}
	
	// wojewodztwo
	if(strlen($_POST['woje'])>3) {
		$a = $_POST['woje'];
		if(strlen($a)>3)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($countk>0) $textk .= ",";
			$textk .= " wojewodztwo = '$a'";
			$countk++;
		}
	}
	
	if($countk != 0) {
		$zapytanie = "SELECT id_adres FROM users WHERE id_user = '$id'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$row = mysqli_fetch_assoc($rezultat);
		$id_adres = $row['id_adres'];
		
		$zapytanie = "SELECT id_kod FROM adresy WHERE id_adres = '$id_adres'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$row = mysqli_fetch_assoc($rezultat);
		$id_kod = $row['id_kod'];
		
		$zapytanie = "UPDATE kod_pocztowy SET ";
		$zapytanie .= $textk;
		$zapytanie .= " WHERE id_kod = '$id_kod';";
		mysqli_query($polaczenie, $zapytanie);
	}
	

	
	
	// miejscowosc
	if(strlen($_POST['miejsc'])>3) {
		$a = $_POST['miejsc'];
		if(strlen($a)>3)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($counta>0) $texta .= ",";
			$texta .= " miejscowosc = '$a'";
			$counta++;
		}
	}
	
	// ulica
	if(strlen($_POST['ulica'])>3) {
		$a = $_POST['ulica'];
		if(strlen($a)>3)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($counta>0) $texta .= ",";
			$texta .= " ulica = '$a'";
			$counta++;
		}
	}
	
	// numer domu
	if(strlen($_POST['nr_d'])>1) {
		$a = $_POST['nr_d'];
		if(strlen($a)>1)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($counta>0) $texta .= ",";
			$texta .= " numer_domu = '$a'";
			$counta++;
		}
	}
	
	// numer mieszkania
	if(strlen($_POST['nr_m'])>1) {
		$a = $_POST['nr_m'];
		if(strlen($a)>1)	{
			$a = htmlentities($a,ENT_QUOTES,"UTF-8");
			if($counta>0) $texta .= ",";
			$texta .= " numer_mieszkania = '$a'";
			$counta++;
		}
	}
	
	
	if($counta != 0) {
		$zapytanie = "SELECT id_adres FROM users WHERE id_user = '$id'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$row = mysqli_fetch_assoc($rezultat);
		$id_adres = $row['id_adres'];
		
		$zapytanie = "UPDATE adresy SET ";
		$zapytanie .= $texta;
		$zapytanie .= " WHERE id_adres = '$id_adres';";
		mysqli_query($polaczenie, $zapytanie);
	}
	
	
}

header('Location: konto_user.php');