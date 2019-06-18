<?php
session_start();	

$wszystkoOK = true;

// login
$login = $_POST['login'];
if(strlen($login)<3 || strlen($login)>20)	$wszystkoOK = false;
$login = htmlentities($login,ENT_QUOTES,"UTF-8");

// hasla
$haslo = $_POST['haslo'];
if(strlen($haslo)<8 || strlen($haslo)>20)	$wszystkoOK = false;
$haslo = htmlentities($haslo,ENT_QUOTES,"UTF-8");

if($wszystkoOK == true) {
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno == 0) {
		$zapytanie = "SELECT * FROM users WHERE user_login = '$login'";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$ile = mysqli_num_rows($rezultat);
		if($ile>0) {
			$row = mysqli_fetch_assoc($rezultat);
			if(password_verify($haslo,$row['user_password'])) {
				$_SESSION['log'] = true;
				$_SESSION['id'] = $row['id_user'];
				$_SESSION['imie'] = $row['user_imie'];
			}	
		}
	}
}
header('Location: index.php');