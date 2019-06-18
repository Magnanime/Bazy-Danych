<?php
session_start();	
$zalogowany = false;
if((!isset($_SESSION['log'])) || (!$_SESSION['log']==true))
{
	header('Location: zaloguj.php');
	exit();
} else $zalogowany = true;
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/> 	
	<title>MOHITwrO - Sklep Internetowy</title> 
	<meta name="description" content="Strona internetowa oraz sklep najlepszego sklepu elektronicznego we Wrocławiu. Znajdź na stronie i wybierz coś dla siebie." /> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<link rel="stylesheet" href="./style/style.css" type="text/css"/>
	
</head>

<body>
	<header>
		<div class="logwin">
			<div class="logwin">
				<?php
		if(!$zalogowany) echo "<a href='rejestracja.php'><img src='img/plus.jpg' height='13px'/><span style='margin-left: 5px;'>Zarejestruj się</span></a>
			<a href='zaloguj.php'><img src='img/user.jpg' height='13px' style='margin-left: 10px;'/><span style='margin-left: 5px; padding-right: 10px;'>Zaloguj się</span></a>";
		else {
				echo "<span style='margin-left: 5px; margin-right: 2%;'>Witaj, ".$_SESSION['imie']."</span>
				<a href='konto_user.php'><span style='margin-left: 5px; margin-right: 2%;'>Twoje Konto</span></a>
				<a href='outlog_user.php'><span style='margin-left: 5px; margin-right: 2%;'>Wyloguj się</span></a>";
			}
		?>
		</div>
		</div>
		<a href="index.php"><div class="logo"><img src="img/logo.jpg" height="100%" width="100%"/></div></a>
		<nav>
		<?php
		require_once 'config.php';
		$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
		$zapytanie = "SELECT * FROM kategorie ORDER BY id_kat ASC LIMIT 4";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$ile = mysqli_num_rows($rezultat);
		if ($ile>=1) {
			for ($i = 1; $i <= $ile; $i++) {
				$row = mysqli_fetch_assoc($rezultat);
				$nazwa = $row['nazwa'];
				echo "<a href='kate.php?kategoria=".$nazwa."'><div class='menu'>$nazwa</div></a>";
			}
		}
		?>
			<a href="kontakt.php"><div class="menu">Kontakt</div></a>
		</nav>
		<a href="cart.php"><div class="basket"><div class="many"><?php 
		require_once "config.php";
		$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
		if($polaczenie->connect_errno == 0) {
			$klient = $_SESSION['id'];
			$zapytanie = "SELECT * FROM koszyk WHERE kto = '$klient'";
			$rezultat = mysqli_query($polaczenie, $zapytanie);
			$ile = mysqli_num_rows($rezultat);
			echo $ile;
		}
		?></div><img src="img/basket.jpg" height="100%"/></a></div>
		<span style="margin-left: 15px; margin-right: 15px; margin-top: 5px; float: right;"><img src="img/line.jpg" height="50px"/></span>
		<!--<a href="#"><div class="search"><img src="img/search.jpg" height="100%"/></div></a>-->
		<div style="clear:both;"></div>
	</header>
	
	<div style="height:80px;"></div>
		
	<main>
	
	<?php
require_once "config.php";
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno == 0) {
	$zapytanie = "SELECT * FROM zamowienie_widok WHERE id_klienta = '$klient' ORDER BY id_zamowienia DESC LIMIT 5";
	$rezultat = mysqli_query($polaczenie, $zapytanie);
	$ile = mysqli_num_rows($rezultat);
	if ($ile>0){
		echo "<div class='update_klient'><h1 style='text-align: center;'>Twoje Ostatnie Zamówienia</h1><div class='rowzam'><div class='kolzam'>NUMER ZAMÓWIENIA</div><div class='kolzam' style='width: 50%;'>PRODUKTY</div><div class='kolzam'>DATA ZAMÓWIENIA</div><div class='kolzam'>WARTOŚĆ ZAMÓWIENIA</div><div class='kolzam'>STATUS ZAMÓWIENIA</div><div style='clear:both;'></div></div>";
		for ($i = 1; $i <= $ile; $i++) {
			$row = mysqli_fetch_assoc($rezultat);
			$id_zam = $row['id_zamowienia'];
			$data = $row['data_zamowienia'];
			$wartosc = $row['wartosc'];
			$status = $row['status_zamowienia'];
			switch($status) {
				case "1": $status = "Złożone"; break;
				case "2": $status = "W realizacji"; break;
				case "3": $status = "Gotowe do wysyłki"; break;
				case "4": $status = "Wysłane"; break;
				case "5": $status = "Zakończone"; break;
			}
			echo "<div class='rowzam'><div class='kolzam'>#".$id_zam."</div><div class='kolzamprod'>";
			// produkty
			$zapytanie = "SELECT * FROM det_zam WHERE id_zamowienia = '$id_zam' ORDER BY id_produkt ASC";
			$rezdet = mysqli_query($polaczenie, $zapytanie);
			$iledet = mysqli_num_rows($rezdet);
			if ($iledet>0){
				for ($j = 1; $j <= $iledet; $j++) {
					$rowdet = mysqli_fetch_assoc($rezdet);
					$id_p = $rowdet['id_produkt'];
					$liczba = $rowdet['liczba'];
					$cenadet = $rowdet['wartosc'];
					$zapytanie = "SELECT nazwa FROM towar WHERE id = '$id_p'";
					$rezp = mysqli_query($polaczenie, $zapytanie);
					$ilep = mysqli_num_rows($rezp);
					if ($ilep==1){
						$rowp = mysqli_fetch_assoc($rezp);
						$nazwa = $rowp['nazwa'];
						echo "<div class='nazwa'>".$nazwa."</div><div class='ilosc'>".$liczba."</div><div class='cena'>";
						printf ("%.2f", $cenadet);
						echo " zł</div><div style='clear:both;'></div>";
					}
				}
			}
			
			echo "</div><div class='kolzam'>".$data."</div><div class='kolzam'>";
			printf ("%.2f", $wartosc);
			echo " zł</div><div class='kolzam'>".$status."</div><div style='clear:both;'></div></div>";
			
		}
		echo "</div>";
	}	
}
?>
	
	
	
	<?php
		require_once "config.php";
		$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
		if($polaczenie->connect_errno == 0) {
			$zapytanie = "SELECT * FROM klient_info WHERE id = '$klient'";
			$rezultat = mysqli_query($polaczenie, $zapytanie);
			$ile = mysqli_num_rows($rezultat);
			if ($ile>0){
				$row = mysqli_fetch_assoc($rezultat);
				$imie = $row['imie'];
				$naz = $row['nazwisko'];
				$tel = $row['telefon'];
				$email = $row['email'];
				$kod = $row['kod_poc'];
				$miasto = $row['miasto'];
				$woje = $row['wojewodztwo'];
				$miejsc = $row['miejscowosc'];
				$ulica = $row['ulica'];
				$nr_d = $row['nr_domu'];
				$nr_m = $row['nr_mieszkania'];
				echo "<div class='update_klient' style='border: none;'><h1 style='text-align: center;'>Twoje Dane</h1>
				
				<div class='koldane'><div class='naz'>Imie</div><div class='naz'>".$imie."</div><div style='clear:both;'></div><div class='naz'>Nazwisko</div><div class='naz'>".$naz."</div><div style='clear:both;'></div><div class='naz'>Telefon</div><div class='naz'>".$tel."</div><div style='clear:both;'></div><div class='naz'>E-mail</div><div class='naz'>".$email."</div><div style='clear:both;'></div></div>
				
				<div class='koldane' style='margin: 10px 15% 10px 5%;'><div class='naz'>Kod pocztowy</div><div class='naz'>".$kod."</div><div style='clear:both;'></div><div class='naz'>Miasto</div><div class='naz'>".$miasto."</div><div style='clear:both;'></div><div class='naz'>Województwo</div><div class='naz'>".$woje."</div><div style='clear:both;'></div><div class='naz'>Miejscowość</div><div class='naz'>".$miejsc."</div><div style='clear:both;'></div><div class='naz'>Ulica</div><div class='naz'>".$ulica."</div><div style='clear:both;'></div><div class='naz'>Numer Domu</div><div class='naz'>".$nr_d."</div><div style='clear:both;'></div><div class='naz'>Numer Mieszkania</div><div class='naz'>".$nr_m."</div><div style='clear:both;'></div></div>
				<div style='clear:both;'></div></div>";
			}
		}
	?>
	
	
<div class="update_klient">	
	<div class="okno">
		<h1>Zaktualizuj Dane</h1>
		<form action="update_user.php" method="post">
		<div class="kolform">
		<div class="formco">Imię</div><input type="text" name="imie"/><br/><br/>
		<div class="formco">Nazwisko</div><input type="text" name="nazwisko"/><br/><br/>
		<div class="formco">Haslo</div><input type="password" name="haslo1"/><br/><br/>
		<div class="formco">Powtórz Haslo</div><input type="password" name="haslo2"/><br/><br/>
		<div class="formco">E-mail</div><input type="email" name="email"/><br/><br/>
		<div class="formco">Telefon</div><input type="text" name="tele"/><br/><br/>
		</div>
		<div class="kolform">
		<div class="formco">Kod pocztowy</div><input type="text" name="kod"/><br/><br/>
		<div class="formco">Miasto</div><input type="text" name="miasto"/><br/><br/>
		<div class="formco">Województwo</div><select name="woje">
		<option>Dolnośląskie</option>
		<option>Kujawsko-Pomorskie</option>
		<option>Lubelskie</option>
		<option>Lubuskie</option>
		<option>Łódzkie</option>
		<option>Małopolskie</option>
		<option>Mazowieckie</option>
		<option>Opolskie</option>
		<option>Podkarpackie</option>
		<option>Podlaskie</option>
		<option>Pomorskie</option>
		<option>Śląskie</option>
		<option>Świętokrzyskie</option>
		<option>Warmińsko-Mazurskie</option>
		<option>Wielkopolskie</option>
		<option>Zachodniopomorskie</option>
		</select><br/><br/>
		<div class="formco">Miejscowość</div><input type="text" name="miejsc"/><br/><br/>
		<div class="formco">Ulica</div><input type="text" name="ulica"/><br/><br/>
		<div class="formco">Numer Domu</div><input type="text" name="nr_d"/><br/><br/>
		<div class="formco">Numer Mieszkania</div><input type="text" name="nr_m"/><br/><br/>
		</div><div style="clear:both;"></div>
		<input type="submit" value="Zaktualizuj Dane"/>
		</form>
	</div></div>




</div>


</div>
<br><br>
	</main>
	<div style="clear:both;"></div>
	
	
	
	
	
	<footer>
		<div class="information">
			<span style="font-weight: bolder; font-size: 20px; letter-spacing: 1px;">Kontakt</span><br>
			<div style="height:30px;"></div>
			<span style="float: left; margin-right: 25px;"><img src="img/open.jpg" height="40px"/></span>
			<span style="float: left; margin-right: 50px;">Pn-Pt<br>8-18<br></span>
			<span style="float: left; margin-right: 25px;"><img src="img/open.jpg" height="40px"/></span>
			<span style="float: left;">Sb<br>8-14<br></span>
			<div style="clear:both;"></div>
			<div style="height:15px;"></div>
			<span style="float: left; margin-right: 25px;"><img src="img/house.jpg" height="40px"/></span>
			<span style="float: left;">ul. Wróblewskiego 27<br>51-627 Wrocław<br></span>
			<div style="clear:both;"></div>
			<div style="height:15px;"></div>
			<span style="float: left; margin-right: 25px;"><img src="img/mail.jpg" height="40px"/></span>
			<span style="float: left; margin-top: 8px;">przykladowy_email@przyklad.com</span>
			<div style="clear:both;"></div>
			<div style="height:15px;"></div>
			<span style="float: left; margin-right: 25px;"><img src="img/phone.jpg" height="40px"/></span>
			<span style="float: left;">(+40) 500 500 500<br>(+40) 600 600 600<br></span>
			<div style="clear:both;"></div>
			<div style="height:20px;"></div>
		</div>
		<div class="information">
			<span style="font-weight: bolder; font-size: 20px; letter-spacing: 1px; padding-left: 40px;">Informacje</span><br>
			<ul>
				<li><div style="height:20px;"></div></li>
				<li><a href="dostawa.php">Dostawa i Płatności</a></li>
				<li><a href="zwrot.php">Zwrot</a></li>
				<li><a href="none.php">Regulamin</a></li>
				<li><a href="none.php">Informacje o firmie</a></li>
				<li><a href="none.php">Polityka Prywatności</a></li>
		</div>
		<div class="information">
			<span style="font-weight: bolder; font-size: 20px; letter-spacing: 1px; padding-left: 40px;">Social Media</span><br>
			<div style="height:30px;"></div>
			<a href="#"><div class="social" style="padding-left: 40px;"><img src="img/fb.jpg" height="75px"/></div></a>
			<a href="#"><div class="social" style="padding-left: 20px;"><img src="img/insta.jpg" height="75px"/></div></a>
			<div style="clear:both;"></div>
			<a href="#"><div class="social" style="padding-left: 40px;"><img src="img/twitter.jpg" height="75px"/></div></a>
			<a href="#"><div class="social" style="padding-left: 20px;"><img src="img/gplus.jpg" height="75px"/></div></a>
			<div style="clear:both;"></div>
		</div>
		<div class="information">
			<span style="font-weight: bolder; font-size: 20px; letter-spacing: 1px;">Mapa</span><br>
			<div style="height:30px;"></div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d313.1585383368615!2d17.085567148202912!3d51.103509666818056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470fc2a00188de3b%3A0x4f09333d26850775!2sIkar+(T-17)!5e0!3m2!1spl!2spl!4v1560302497825!5m2!1spl!2spl" width="90%" height="225" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
		<div style="clear:both;"></div>
		<div class="down-footer">Witryna sklepu internetowego &copy; Wszelkie prawa zastrzeżone 2019</div>
	</footer>
	
	
	
<script src="js/jquery-1.11.3.min.js"></script>
	
</body>
</html>