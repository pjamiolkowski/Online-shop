<?php
	session_start();
	if(!isset($_SESSION['user']))
	{
		header('Location: index.php');
		exit();
	}
	require_once "connect.php";
	
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	$connection->query('SET NAMES utf8');
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
		close();
	}
	
	if(isset($_SESSION['liczba']) && isset($_SESSION['koszyk_pr']))
	{
		if(($_SESSION['liczba'])>=0)
		{
			$produkty = $_SESSION['koszyk_pr'];
			$k=0;
			$cena_calk = 0;	
			$wiadomosc1="";
			for($i = 0; $i <= $_SESSION['liczba']; $i++)
			{
				$k++;
				$result = $connection->query('SELECT * FROM towar WHERE id_towar='.$produkty[$i][0]);
				$r = $result->fetch_assoc(); 
				$cena_il = (($r["cena_zl"])+($r["cena_gr"])/100)*($produkty[$i][1]);
				$cena_calk = $cena_calk + $cena_il;
				$cena_il = str_replace(".",",",$cena_il);
				$wiadomosc2 = '<tr><th>'.$k.'</th><td>'.$r['opis'].'</td><td>'.$produkty[$i][1].'</td><td>'.$cena_il.' zł</td></tr>';
				$wiadomosc1=$wiadomosc1.$wiadomosc2;
			}
			$cena_calk = str_replace(".",",",$cena_calk);
		}
	}
	
	
	$naglowki  = "From: biuro@iow.pl <biuro@iow.pl>" . "\r\n";
	$naglowki .= "MIME-Version: 1.0" . "\r\n";
	$naglowki .= "Content-type: text/html; charset=UTF-8" . "\r\n"; 	
	
	
	$wiadomosc ='<html>
					<head>
						<style>
							.t1 caption
							{
								font-weight: bold;
								margin-top: 20px;
								font-size: 30px;
								margin-bottom: 25px;
							}
							.t1 
							{
								margin: 1em auto;
								border-collapse: collapse;
							}
							.t1 th, .t1 td 
							{
								padding: 10px 10px;
								border: 1px solid #000000;
							}
						</style>
					</head>
					<body>
						<table  class="t1">
							<caption>Zamówienie</caption>
							<thead>
								<tr><th>Nr</th><th>Nazwa</th><th>Ilość</th><th>Cena</th></tr>
							</thead>
							<tbody>';
						
	$wiadomosc3=		   '</tbody>
							<tfoot>
								<tr><th colspan="3">Całość zamówienia:</th><th colspan="2">'.$cena_calk.' zł</th></tr>					
							</tfoot>
						</table>	
					</body>
				</html>';

	$wiadomosc = $wiadomosc.$wiadomosc1.$wiadomosc3;
	
   if(mail('biur@yzqwert.pl', 'Zamówienie od: '.$_SESSION['user'],$wiadomosc, $naglowki))
   {
	   $_SESSION['Wyslany_email'] = true;
	   header('Location: koszyk.php');
   }
?>