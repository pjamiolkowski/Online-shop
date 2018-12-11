<?php
	session_start();
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
			<h1 class="title"> O nas </h1 >
			<br/>
			<p class="text">Firma jest głównym dystrybutorem elemenetów hydrauliki siłowej. Posiadamy w swojej sprzedaży następujący asortyment: rozdzielacze hydrauliczne, silniki hydrauliczne, pompy tłoczkowe i zębate, orbitrole, zawory hydrauliczne, cylindry hydrauliczne, czujniki ciśnieniowe, sprzęgła i łączniki dzwonowe, joysticki, sterowniki hydrauliczne, filtry hydrauliczne, zbiorniki hydrauliczne, poziomowskazy, korki wlewowe i wiele innych.</p >
			<p class="text"> Produkty dostarczane przez naszą firmę są najwyższej jakości. Zapewniamy wsparcie techniczne i doractwo w doborze odpowiednich komponentów. Jesteśmy w stanie zaprojektować każdy układ hydrauliczny a w razie potrzeby zapewniamy serwis.</p >
			<p class="text">Dostarczamy hydraulikę do następujacych aplikacji: maszyny rolnicze i leśne, ciągniki rolnicze, maszyny budowlane, ciężarówki i autobusy,  kolejnictwo, górnictwo, instalacje przemysłowe itp. Jeśli mają Państwo jakieś pytania prosimy o kontakt z nami. Zapraszamy do współpracy!</p >
		</div>
		
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