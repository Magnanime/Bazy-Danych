<?php
session_start();
$klient = $_SESSION['id'];
$id = $_REQUEST['id'];
require_once 'config.php';
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno == 0) {
	$zapytanie = "DELETE FROM koszyk WHERE kto = '$klient' AND id = '$id'";
	mysqli_query($polaczenie, $zapytanie);
}
header("Location: cart.php");