<?php
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno==0) {
		if($_POST['nazwa'] != "") {
		$nazwa = $_POST['nazwa'];
		$nazwa = htmlentities($nazwa,ENT_QUOTES,"UTF-8");
		$rezultat = @$polaczenie->query(sprintf("SELECT * FROM producenci WHERE nazwa = '%s'", mysqli_real_escape_string($polaczenie,$nazwa)));
		$ile = $rezultat->num_rows;
		if($ile == 0) {
			@$polaczenie->query(sprintf("INSERT INTO producenci VALUES (NULL,'$nazwa')"));
		}
		}
		$polaczenie->close();
	}
header('Location: producent.php');