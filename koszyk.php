<?php
	session_start();
	
	if(isset($_POST['Przycisk_kontynnuj']))
	{
		header('Location: produkt.php');
		exit();
	}
	else 
	if(isset($_POST['Przycisk_odswiez']))
	{
		$produkty = $_SESSION['koszyk_pr'];
		for($i = 0; $i <= $_SESSION['liczba']; $i++)
		{
			if(!($_POST['ilosc'.$i]== $produkty[$i][1]))
			{
				$produkty[$i][1]= $_POST['ilosc'.$i];
			}
		}
		$_SESSION['koszyk_pr'] = $produkty;
	}
	else 
	if(isset($_POST['Przycisk_wyslij']))
	{
		if(isset($_SESSION['user']))
		{
			header('Location: email.php');
			exit();
		}
		else
		{
			$_SESSION['Przycisk_wyslij'] = true;
			header('Location: login.php');
			exit();
		}
	}
	else
	{
		if(isset($_SESSION['koszyk_pr']))
		{
			$produkty = $_SESSION['koszyk_pr'];
			$il = $_SESSION['liczba'];
			for($i = $_SESSION['liczba']; $i >=0; $i--)
			{
				if(isset($_POST['usun'.$i]))
				{
					$produkty[$i][0] = $produkty[$il][0];
					$produkty[$i][1] = $produkty[$il][1];
					$produkty[$il][0] = 0;
					$produkty[$il][1] = 0;
					$il--;
				}
			}
			$_SESSION['liczba'] = $il;
			$_SESSION['koszyk_pr'] = $produkty;
		}
	}
	
		require_once "connect.php";
	
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	$connection->query('SET NAMES utf8');
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
		close();
	}
	$w = array_search("Dodaj", $_POST);
	if(isset($w) && !($w ==""))
	{
		if(!isset($_SESSION['liczba']))
		{
			$l_koszyk = 0;
			$koszyk[$l_koszyk][0]= $w;
			$koszyk[$l_koszyk][1]= 1;
			$_POST[$w] ="";
			unset($w);
			$_SESSION['koszyk_pr'] = $koszyk;
			$_SESSION['liczba'] = $l_koszyk;
		}
		else
		{
			$koszyk = $_SESSION['koszyk_pr'];
			$czy_jest = false;
			for($i = 0; $i <= $_SESSION['liczba']; $i++)
			{
				if($koszyk[$i][0] == $w)
				{
					$czy_jest = true;
				}
			}
			if(!($czy_jest))
			{
				$l_koszyk = $_SESSION['liczba'];
				$l_koszyk++;
				$koszyk[$l_koszyk][0]= $w;
				$koszyk[$l_koszyk][1]= 1;
				$_POST[$w] ="";
				$_SESSION['koszyk_pr'] = $koszyk;
				$_SESSION['liczba'] = $l_koszyk;			
				unset($w);
			}
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

	<div class="container">
		<div class="header">
			<a href="index.php"><img src="picture/logo.png" id="logo"/></a>
			<ul>
				<li><a href="produkt.php"> <img src="picture/product.png" class="Icon" /> Produkty</a></li>
				<li><a href="login.php"> <img src="picture/login.png" class="Icon" /> Moje konto</a></li>
				<li><?php
						if(isset($_SESSION['user']))
							echo "<span id ='witaj'>Witaj ".$_SESSION['user']."! <a href='wyloguj.php' id ='wyloguj'>wyloguj</a><br />
								 <a href='koszyk.php' style='letter-spacing:3px;'> <img src='picture/basket.png' class='Icon'/> Mój koszyk</a></span>";
						else
							echo "<a href='koszyk.php'> <img src='picture/basket.png' class='Icon'/> Mój koszyk</a>"
					?>
				</li>
			</ul>
		</div>
		
	
		<div class="content_koszyk">
			<form method="post" >
				<?php
					if(!isset($_SESSION['Wyslany_email']))
					{
						if(isset($_SESSION['liczba']) && isset($_SESSION['koszyk_pr']))
						{
							if(($_SESSION['liczba'])>=0)
							{
								$produkty = $_SESSION['koszyk_pr'];
								$k=0;
								$cena_calk = 0;						
								echo '<table class="t1">
									<caption>Podsumowanie</caption>
									<thead>
										<tr><th>Nr</th><th>Nazwa</th><th>Ilość</th><th>Cena</th><th>Usuń</th></tr>
									</thead>
									<tbody>';
									for($i = 0; $i <= $_SESSION['liczba']; $i++)
									{
										$k++;
										$result = $connection->query('SELECT * FROM towar WHERE id_towar='.$produkty[$i][0]);
										$r = $result->fetch_assoc(); 
										$cena_il = (($r["cena_zl"])+($r["cena_gr"])/100)*($produkty[$i][1]);
										$cena_calk = $cena_calk + $cena_il;
										$cena_il = str_replace(".",",",$cena_il);
										echo '<tr><th>'.$k.'</th><td>'.$r['opis'].'</td><td><input type="text" value='.$produkty[$i][1].' name="ilosc'.$i.'" class="ilosc"/></td><td>'.$cena_il.' zł</td>
										<td><input type="submit" name="usun'.$i.'" value="usuń"/></td></tr>';
									}
									$cena_calk = str_replace(".",",",$cena_calk);
									echo '</tbody>
									<tfoot>
										<tr><th colspan="3">Całość zamówienia:</th><th colspan="2">'.$cena_calk.' zł</th></tr>
									</tfoot>
								</table>
								<div class="koszyk_przyciski">
									<ul>
										<li><input type="submit" name="Przycisk_kontynnuj" value="Kontynuuj zakupy" id="koszyk_button" /></li>
										<li><input type="submit" name="Przycisk_odswiez" value="Odśwież ilość" id="koszyk_button" /></li>
										<li><input type="submit" name="Przycisk_wyslij" value="Wyślij zamówienie" id="koszyk_button" /></li>
									</ul>
								</div>';
							}
							else
							{
								echo '<span id="brak_koszyk">Brak produktów w koszyku.</span >';
							}
						}
						else
						{
							echo '<span id="brak_koszyk">Brak produktów w koszyku.</span >';
						}
					}
					else
					{
						echo '<span id="brak_koszyk">Wiadomość została wysłana.</span >';
						unset($_SESSION['Wyslany_email']);
						unset($_SESSION['koszyk_pr']);
						unset($_SESSION['liczba']);
					}
						$connection->close();
				?>
			</form>
			<div class="czysc"></div>
		</div>
		<div class="content_odstep"></div>

		<div class="footer">
			<ul>
				<li>E-mail<br /> biuro@iow.pl<br /> sklep@iow.pl</li>
				<li>IOW Industrial S.A.<br /> ul. Powolna 17 <br/> 02-220 Warszawa</li>
				<li>Kontakt<br /> tel. +48 22 511 463 444<br /> fax +48 22 511 463 459</li>
			</ul>
		</div>
	</div>
</body>

</html>