<?php
session_start();
if(isset($_POST['id_p'])) {
	$_SESSION['search_produkt'] = $_POST['id_p'];
	header('Location: produkty.php');
	exit();
} else if(isset($_POST['id_k'])) {
	$_SESSION['search_kat'] = $_POST['id_k'];
	header('Location: kategorie.php');
	exit();
} else if(isset($_POST['id_f'])) {
	$_SESSION['search_fac'] = $_POST['id_f'];
	header('Location: producent.php');
	exit();
} else if(isset($_POST['id_zam'])) {
	$_SESSION['search_zam'] = $_POST['id_zam'];
	header('Location: zamowienia.php');
	exit();
} else if(isset($_POST['id_det'])) {
	$_SESSION['search_det'] = $_POST['id_det'];
	header('Location: det_zamowienia.php');
	exit();
} else if(isset($_POST['id_u'])) {
	$_SESSION['search_klient'] = $_POST['id_u'];
	header('Location: klienci.php');
	exit();
} else {
	header('Location: index.php');
	exit();
}
