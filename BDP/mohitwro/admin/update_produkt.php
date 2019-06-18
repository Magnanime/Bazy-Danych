<?php
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno==0) {
		if($_POST['id'] != "") {
			$id = $_POST['id'];
			$id = htmlentities($id,ENT_QUOTES,"UTF-8");
			$text = "";
			$c = 0;
			
			if($_POST['nazwa'] != ""){
				$nazwa = $_POST['nazwa'];
				$nazwa = htmlentities($nazwa,ENT_QUOTES,"UTF-8");
				if($c>0) $text .= ",";
				$text .= "nazwa = '$nazwa'";
				$c++;
			}
			
			if($_POST['cecha'] != "") {
				$cecha = $_POST['cecha'];
				$cecha = htmlentities($cecha,ENT_QUOTES,"UTF-8");
				if($c>0) $text .= ",";
				$text .= "cecha = '$cecha'";
				$c++;
			}
			
			if($_POST['cena'] != "") {
				$cena = $_POST['cena'];
				$cena = htmlentities($cena,ENT_QUOTES,"UTF-8");
				if($c>0) $text .= ",";
				$text .= "cena = '$cena'";
				$c++;
			}	
			
			if($_POST['obraz'] != "") {
				$obraz = $_POST['obraz'];
				$obraz = htmlentities($obraz,ENT_QUOTES,"UTF-8");
				if($c>0) $text .= ",";
				$text .= "obraz = '$obraz'";
				$c++;
			}
			
			if($_POST['liczba'] != "") {
				$liczba = $_POST['liczba'];
				$liczba = htmlentities($liczba,ENT_QUOTES,"UTF-8");
				if($c>0) $text .= ",";
				$text .= "stan_magazynowy = '$liczba'";
				$c++;
			}
			
			if($_POST['opis'] != "") {
				$opis = $_POST['opis'];
				$opis = htmlentities($opis,ENT_QUOTES,"UTF-8");
				if($c>0) $text .= ",";
				$text .= "opis ='$opis'";
				$c++;
			}
			
			if($c > 0) {
				$zapytanie = "UPDATE produkty SET ";
				$zapytanie .= $text;
				$zapytanie .= " WHERE id_produkt = '$id'";
				mysqli_query($polaczenie, $zapytanie);
			}
			
		}
		$polaczenie->close();
	}
header('Location: produkty.php');