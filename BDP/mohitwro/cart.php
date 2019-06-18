<?php
	session_start();
	$zalogowany = false;
	if((isset($_SESSION['log'])) && ($_SESSION['log']==true))
	{
		$zalogowany = true;
	}
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
	if((isset($_SESSION['log'])) && ($_SESSION['log']==true)) {
		require_once "config.php";
		$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
		if($polaczenie->connect_errno == 0) {
			$klient = $_SESSION['id'];
			$zapytanie = "SELECT * FROM koszyk WHERE kto = '$klient'";
			$rezultat = mysqli_query($polaczenie, $zapytanie);
			$ile = mysqli_num_rows($rezultat);
			echo $ile;
		}
	} else echo "0";
		?></div><img src="img/basket.jpg" height="100%"/></a></div>
		<span style="margin-left: 15px; margin-right: 15px; margin-top: 5px; float: right;"><img src="img/line.jpg" height="50px"/></span>
		<!--<a href="#"><div class="search"><img src="img/search.jpg" height="100%"/></div></a>-->
		<div style="clear:both;"></div>
	</header>
	
	<div style="height:80px;"></div>
			
	<main>	
	
	<div class="containercart">
	<h1>Koszyk</h1>
	<?php 
if($zalogowany) {
	require_once 'config.php';
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno == 0) {
		$klient = $_SESSION['id'];
		$zapytanie = "SELECT * FROM koszyk WHERE kto = '$klient' ORDER BY id ASC";
		$rezultat = mysqli_query($polaczenie, $zapytanie);
		$ile = mysqli_num_rows($rezultat);
		if ($ile>0) {
			echo "<div class='cartrow' style='height: 20px;'>
						<div class='cartid' style='height: 20px;'>ID</div>
						<div class='cartname' style='height: 20px; text-align: center;'>NAZWA</div>
						<div class='cartilosc' style='height: 20px;'>ILOSC</div>
						<div class='cartcena' style='height: 20px;'>CENA</div>
						<div class='cartusun' style='height: 20px;'>USUN</div><div style='clear:both;'></div></div>";
			$sum = 0;
			for ($i = 1; $i <= $ile; $i++) {
				$row = mysqli_fetch_assoc($rezultat);
				$id = $row['id'];
				$nazwa = $row['nazwa'];
				$ilosc = $row['ilosc'];
				$cena = $row['cena'];
				$sum += $cena;
			
				echo "<div class='cartrow'><div class='cartid'>#".$id."</div><div class='cartname'>".$nazwa."</div><div class='cartilosc'><form action='add_to_cart.php' method='GET'><input type='text' name='ilosc' value='".$ilosc."' size='10' maxlength='10'><input type='hidden' name='id' value='".$id."'><input type='hidden' name='nazwa' value='".$nazwa."'><input type='hidden' name='cena' value='".$cena."'><input type='hidden' name='kosz' value='1'><input type='submit' style='text-align: center;' value='~'></form></div><div class='cartcena'>";
				printf ("%.2f", $cena);
				echo "zł</div><div class='cartusun'><a href='usun_cart.php?id=".$id."'><img src='img/minus.png' height='70%'/></a></div><div style='clear:both;'></div></div>";
			}
			echo "<div class='cartrow'><div class='cartid'></div><div class='cartname'></div><div class='cartilosc'>SUMA</div><div class='cartcena'>";
			printf ("%.2f", $sum);
			echo "zł</div><div class='cartusun'></div><div style='clear:both;'></div></div>";
			echo "<br><form style='margin-right: 5%; text-align: right;' action='realizuj_zamowienie.php'><input type='submit' value='Realizuj'></form>";
			
		} else echo "<h1>Koszyk jest pusty !</h1>";
	}
} else {
	header('Location: zaloguj.php');
	exit();
}
	
	?>
		
	</div>
	
	
	
	
	
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