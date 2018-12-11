<?php
	session_start();
	
	if((!isset($_SESSION['user'])) || ((isset($_SESSION['user'])) && ($_SESSION['user'] !== "admin")))
	{
		header('Location: index.php');
		exit();
	}
	if((empty($_SESSION['wszystko_ok1'])) ||(!$_SESSION['wszystko_ok1']))
	{
		header('Location:admin.php');
		unset($_SESSION['wszystko_ok1']);
		exit();
	}
	else
	{
		
		$opis = $_SESSION['opis_produkt1'];
		$zdjecie = $_SESSION['zdjecie_produkt1'];	
		$cena_zl = $_SESSION['cena_zl1'];
		$cena_gr = $_SESSION['cena_gr1'];
			
		require_once "connect.php";
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);	
			$connection->query('SET NAMES utf8');
			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				if((isset($_POST['send'])) && ($_POST['send']=="Zatwierdź"))
				{
					unset($_POST['send']);
					$connection->query("INSERT INTO towar VALUES(NULL, '$zdjecie', '$cena_zl', '$cena_gr', '$opis')");
					header('Location:admin.php');
					exit();	
				}
				if((isset($_POST['return'])) && ($_POST['return']=="Wróć"))
				{
						header('Location:admin.php');
						exit();		
				}
			}
			
			$connection->close();
		}
		catch(Exception $e)
		{
			echo 'Błąd serwera! Prosimy o rejestrację w innym terminie.'.$e;
		}
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
	<div id="register1">
			<div>
			<h1 class="title">Podsumowanie</h1>
			<label class="preview"><span class="text1">Opis: </span ><?php echo $opis ?></label><br /><br />
			<label class="preview"><span class="text1">Ścieżka zdjęcia: </span ><?php echo $zdjecie ?></label><br /><br />
			<label class="preview"><span class="text1">Cena: </span ><?php echo $cena_zl.','.$cena_gr.' zł' ?></label><br /><br />
			</div>
			<form method="post" style="float: left">
				<input type="submit" name="return" value="Wróć" id="button1" />
			</form><form method="post" style="float: left">
				<input type="submit" name="send" value="Zatwierdź" id="button1" />
			</form><br /><br /><br />
	</div>
</body>

</html>