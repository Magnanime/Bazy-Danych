<?php
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	$mainzapy = "INSERT INTO produkty VALUES (NULL,";
	if($polaczenie->connect_errno==0) {
		if(isset($_POST['kategoria']) && isset($_POST['nazwa']) && isset($_POST['cecha']) && isset($_POST['cena']) && isset($_POST['liczba']) && isset($_POST['opis']) ) {
			
			$kat = $_POST['kategoria'];	
			$zapytanie = "SELECT * FROM kategorie WHERE nazwa = '$kat'";
			$rezultat = mysqli_query($polaczenie, $zapytanie);
			$ile = mysqli_num_rows($rezultat);
			if ($ile>=1) {
				for ($i = 1; $i <= $ile; $i++) {
					$row = mysqli_fetch_assoc($rezultat);
					$kat = $row['id_kat'];
				}
			}
			$mainzapy .= "'$kat',";
			
			$nazwa = $_POST['nazwa'];
			$nazwa = htmlentities($nazwa,ENT_QUOTES,"UTF-8");
			$mainzapy .= "'$nazwa',";
			
			if(isset($_POST['producent']) && $_POST['producent'] != "") {
				$producent = $_POST['producent'];
				$zapytanie = "SELECT * FROM producenci WHERE nazwa = '$producent'";
				$rezultat = mysqli_query($polaczenie, $zapytanie);
				$ile = mysqli_num_rows($rezultat);
				if ($ile>=1) {
					for ($i = 1; $i <= $ile; $i++) {
						$row = mysqli_fetch_assoc($rezultat);
						$producent = $row['id_producent'];
					}
				}
				$mainzapy .= "'$producent',";
			} else $mainzapy .= "NULL,";
				
			$cecha = $_POST['cecha'];
			$cecha = htmlentities($cecha,ENT_QUOTES,"UTF-8");
			$mainzapy .= "'$cecha',";
			
			$cena = $_POST['cena'];
			$cena = htmlentities($cena,ENT_QUOTES,"UTF-8");
			$mainzapy .= "'$cena',";
			
			if(isset($_POST['obraz']) && $_POST['obraz'] != "") {
				$obraz = $_POST['obraz'];
				$obraz = htmlentities($obraz,ENT_QUOTES,"UTF-8");
				$mainzapy .= "'$obraz',";
			} else $mainzapy .= "NULL,";
			
			$liczba = $_POST['liczba'];
			$liczba = htmlentities($liczba,ENT_QUOTES,"UTF-8");
			$mainzapy .= "'$liczba',";
			
			$opis = $_POST['opis'];
			$opis = htmlentities($opis,ENT_QUOTES,"UTF-8");
			$mainzapy .= "'$opis')";
			
			
			$rezultat = @$polaczenie->query(sprintf("SELECT * FROM produkty WHERE nazwa = '%s'", mysqli_real_escape_string($polaczenie,$nazwa)));
			$ile = $rezultat->num_rows;
			if($ile == 0) {
				mysqli_query($polaczenie, $mainzapy);
			}
		$polaczenie->close();
		}
	}
	
header('Location: produkty.php');