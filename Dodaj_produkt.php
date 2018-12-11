<?php
	
	session_start();
	
	if((!isset($_SESSION['user'])) || ((isset($_SESSION['user'])) && ($_SESSION['user'] !== "admin")))
	{
		header('Location: index.php');
		exit();
	}
	
	if(isset($_POST['opis']))
	{
		$wszystko_ok = true;
		if(empty($_POST['opis']))
		{
			$wszystko_ok = false;
			$_SESSION['e_opis'] = "Puste pole, wprowadź opis produktu";
		}
		
		if(empty($_POST['cena_zl']))
		{
			$wszystko_ok = false;
			$_SESSION['e_cena_zl'] = "Puste pole, wprowadź cenę (zł) produktu";
		}
		
		if(empty($_POST['cena_gr']))
		{
			$wszystko_ok = false;
			$_SESSION['e_cena_gr'] = "Puste pole, wprowadź cenę (gr) produktu";
		}
		if($wszystko_ok ==true)
		{
			$_SESSION['wszystko_ok1'] = true;
			$_SESSION['opis_produkt1'] = $_POST['opis'];
			$_SESSION['zdjecie_produkt1'] = $_POST['zdjecie'];	
			$_SESSION['cena_zl1'] = $_POST['cena_zl'];
			$_SESSION['cena_gr1'] = $_POST['cena_gr'];
			
			header('Location:podsumowanie_produkt.php');
			exit();
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
	<div id="register">
		<form method="post">
			<h1 class="title">Dodaj produkt<br/></h1><br/>
			<?php

		
				if(isset($_POST['opis']))
				{
					echo 'Opis: <input type="text" name="opis" value="'.$_POST['opis'].'" class="field" />';
				} else
				{
					echo 'Opis: <input type="text" name="opis" class="field" />';
				}
				if(isset($_SESSION['e_opis']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_opis'].'</div>';
					unset($_SESSION['e_opis']);
				}
				else
					echo '<br /><br />';
				
				if(isset($_POST['zdjecie']))
				{
					echo 'Ścieżka zdjęcia: <input type="text" name="zdjecie" value="'.$_POST['zdjecie'].'" class="field" />';
				} else
				{
					echo 'Ścieżka zdjęcia: <input type="text" name="zdjecie" class="field" />';
				}	
				echo '<br /><br />';				
				
				if(isset($_POST['cena_zl']))
				{
					echo 'Cena[zł]: <input type="text" name="cena_zl" value="'.$_POST['cena_zl'].'" class="field" />';
				} else
				{
					echo 'Cena[zł]: <input type="text" name="cena_zl" class="field" />';
				}
				if(isset($_SESSION['e_cena_zl']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_cena_zl'].'</div>';
					unset($_SESSION['e_cena_zl']);
				}
				else
					echo '<br /><br />';
				
				if(isset($_POST['cena_gr']))
				{
					echo 'Cena[gr]: <input type="text" name="cena_gr" value="'.$_POST['cena_gr'].'" class="field" />';
				} else
				{
					echo 'Cena[gr]: <input type="text" name="cena_gr" class="field" />';
				}
				if(isset($_SESSION['e_cena_gr']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_cena_gr'].'</div>';
					unset($_SESSION['e_cena_gr']);
				}
				else
					echo '<br /><br />';
			?>
			<br/><input type="submit" value="Dodaj" id="button" /><br /><br/>
		</form>
	</div>
</body>

</html>