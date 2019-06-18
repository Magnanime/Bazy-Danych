<?php
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno==0) {
		if($_POST['nazwa'] != "" && $_POST['id'] != "") {
			$id = $_POST['id'];
			$nazwa = $_POST['nazwa'];
			$id = htmlentities($id,ENT_QUOTES,"UTF-8");
			$nazwa = htmlentities($nazwa,ENT_QUOTES,"UTF-8");
			$zapytanie = "UPDATE kategorie SET nazwa = '$nazwa' WHERE id_kat = '$id'";
			mysqli_query($polaczenie, $zapytanie);
		}
		$polaczenie->close();
	}
header('Location: kategorie.php');