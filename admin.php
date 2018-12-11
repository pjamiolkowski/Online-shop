<?php

	session_start();
	
	if((!isset($_SESSION['user'])) || ((isset($_SESSION['user'])) && ($_SESSION['user'] !== "admin")))
	{
		header('Location: index.php');
		exit();
	}
	if(isset($_POST['Wyloguj']))
	{
		header('Location: wyloguj.php');
		exit();
	}
	if(isset($_POST['Dane_uzytkownik']))
	{
		header('Location: Dane_uzytkownik.php');
		exit();
	}
	if(isset($_POST['Dodaj_uzytkownik']))
	{
		header('Location: Dodaj_uzytkownik.php');
		exit();
	}
	if(isset($_POST['Dane_produkt']))
	{
		header('Location: Dane_produkt.php');
		exit();
	}
	if(isset($_POST['Dodaj_produkt']))
	{
		header('Location: Dodaj_produkt.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Hydraulika siłowa </title>
	<meta charset="UTF-8" />
	<meta name="description" content="Najlepsza hydraulika siłowa, najlepsze ceny!!!" />
	<meta name="keywords" content="rozdzielacze, pompy hydrauliczne, akumulatory hydrauliczne, orbitrole, zaowry hydrauliczne" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
</head>

<body>
	<div id="pole_admin">
		<form method="post">
			<table class="t2">
			<tr>
				<td><input type="submit" name="Dane_uzytkownik" value="Dane użytkownika" class="button2" /></td><td><input type="submit" name="Dodaj_uzytkownik" value="Dodaj użytkownika" class="button2" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="Dane_produkt" value="Produkty" class="button2" /></td><td><input type="submit" name="Dodaj_produkt" value="Dodaj produkt" class="button2" /></td>
			</tr>
			<tr>
				<td><input type="submit" name="Wyloguj" value="Wyloguj" class="button2" /></td>
			</tr>
			</table>
		</form>
	</div>
</body>

</html>