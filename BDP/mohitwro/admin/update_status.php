<?php
$zam = $_REQUEST['id'];
require_once 'config.php';
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno == 0) {
	$zapytanie = "SELECT status_zam FROM zamowienia WHERE id_zamowienia = '$zam'";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>0) {
		$row = mysqli_fetch_assoc($rezultat);
		$stat = $row['status_zam'] + 1;
		$zapytanie = "UPDATE zamowienia SET status_zam = '$stat' WHERE id_zamowienia = '$zam'";
		mysqli_query($polaczenie, $zapytanie);
	}
}
header("Location: zamowienia.php");