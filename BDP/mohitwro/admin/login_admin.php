<?php
session_start();

try
{
	require_once "config.php";
	$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
	if($polaczenie->connect_errno!=0)	throw new Exception(mysqli_connect_errno());
	else
	{
		$login = 	$_POST['login'];
		$haslo 	= 	$_POST['haslo'];
		$login = htmlentities($login,ENT_QUOTES,"UTF-8");

		if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM log_admin WHERE login = '%s'", mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_adminow = $rezultat->num_rows;
			if($ilu_adminow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				if(password_verify($haslo,$wiersz['haslo']))
				{
					$_SESSION['logged'] = true;
					header('Location: main.php');
				}
				else
				{
					header('Location: index.php');
				}
			}
			else
			{
				header('Location: index.php');
			}			
		}
	}
	$polaczenie->close();
}
catch(Exception $e)
{
	echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
	//echo '<br/>Informacja developerska: '.$e;
}
exit();

