<?php
	session_start();
	
	
	if((!isset($_SESSION['user'])) || ((isset($_SESSION['user'])) && ($_SESSION['user'] !== "admin")))
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
	if(isset($_POST['Wroc']))
	{
		header('Location: admin.php');
		exit();
	}
	else 
	if(isset($_POST['Zatwierdz']))
	{
		$produkt = $_SESSION['numer_id_towar'];
		for($i = 0; $i < count($produkt); $i++)
		{
			$connection->query("UPDATE towar SET zdjecie='".$_POST['zdjecie'.$i]."', cena_zl='".$_POST['cena_zl'.$i]."', cena_gr='".$_POST['cena_gr'.$i]."', opis='".$_POST['opis'.$i]."' WHERE id_towar='$produkt[$i]'");
		}
	}
	if(isset($_SESSION['numer_id_towar']))
	{	
		$usun_licz = $_SESSION['numer_id_towar'];
		for($i = 0; $i < count($usun_licz); $i++)
		{
			if(isset($_POST['usun'.$i]))
			{
				$connection->query("DELETE FROM towar WHERE id_towar='$usun_licz[$i]'");
			}
		}
		unset($usun_licz);
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Hydraulika siłowa </title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
</head>

<body>

	<div class="container">
			<form method="post" >
				<?php
					echo '<table class="t3">
						<caption>Dane produktów</caption>
						<thead>
							<tr><th>ID</th><th>nazwa produktu</th><th>cena [zł]</th><th>cena [gr]</th><th>ścieżka produktu</th><th>Usuń</th></tr>
						</thead>
						<tbody>';
							$result = $connection->query("SELECT * FROM towar");
							if($result->num_rows >0) 
							{
								$i=0;
								while ($r = $result->fetch_assoc()) 
								{
									$produkt[$i] = $r['id_towar'];
									echo '<tr><th>'.$r['id_towar'].'</th>
									<td><input type="text" value="'.$r['opis'].'" name="opis'.$i.'" size="50"/></td>
									<td><input type="text" value='.$r['cena_zl'].' name="cena_zl'.$i.'"size="5"/></td>
									<td><input type="text" value='.$r['cena_gr'].' name="cena_gr'.$i.'" size="3"/></td>
									<td><input type="text" value="'.$r['zdjecie'].'" name="zdjecie'.$i.'"size="30"/></td>
									<td><input type="submit" name="usun'.$i.'" value="usuń"/></td></tr>';
									$i++;
								}
								$_SESSION['liczba_pol'] = $i;
							}
						echo '</tbody>';
						$_SESSION['numer_id_towar'] = $produkt;
					echo '</table>
					<div class="koszyk_przyciski">
						<ul>
							<li><input type="submit" name="Wroc" value="Wróć" id="Dane_button1" /></li>
							<li><input type="submit" name="Zatwierdz" value="Zatwierdź" id="Dane_button1" /></li>
						</ul>
					</div>';
					$connection->close();
				?>
			</form>
			<div class="czysc"></div>

	</div>
</body>

</html>