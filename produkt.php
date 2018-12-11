<?php
	session_start();
	
	
		require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$connection->query('SET NAMES utf8');
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
		close();
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
		
	
		<div class="content">
			<?php
				$result = $connection->query("SELECT * FROM towar");
				if($result->num_rows >0) 
				{
					$i=0;
					while ($r = $result->fetch_assoc()) 
					{
						if($i%5 == 0)
						{
							echo '<div class="rzad"></div>';
						}
						echo '<div class="produkt">
								<img src="'.$r["zdjecie"].'" class="foto"/>
								<div class="opis_produkt">'.$r["opis"].'</div>
								<div class="cena">'.$r["cena_zl"].','.$r["cena_gr"].' zł</div>
								<form action="koszyk.php" method="post">
									<input type="submit" name="'.$r["id_towar"].'" value="Dodaj" class="btn_dodaj" /><br /><br/>
								</form>
							 </div>';
						$i++;
					}
					echo '<div class="rzad"></div>';
				}
				$connection->close();
			?>		
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