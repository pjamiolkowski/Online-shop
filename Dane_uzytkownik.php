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
		$uzytkownik = $_SESSION['numer_id'];
		for($i = 0; $i < count($uzytkownik); $i++)
		{
			$connection->query("UPDATE users SET name='".$_POST['name'.$i]."', surname='".$_POST['surname'.$i]."', login='".$_POST['login'.$i]."', password='".$_POST['password'.$i]."', email='".$_POST['email'.$i]."', education='".$_POST['education'.$i]."', street='".$_POST['street'.$i]."', number='".$_POST['number'.$i]."', kod='".$_POST['kod'.$i]."', city='".$_POST['city'.$i]."' WHERE id='$uzytkownik[$i]'");
			$connection->query("DELETE FROM hobby WHERE id_osoby='$uzytkownik[$i]'");
			for($j = 0; $j < count($_POST['hobby'.$i]); $j++)
			{	
				$connection->query("INSERT INTO hobby VALUES(NULL, '$uzytkownik[$i]', '".$_POST['hobby'.$i][$j]."')");
			}
		}
	}
	if(isset($_SESSION['numer_id']))
	{	
		$usun_licz = $_SESSION['numer_id'];
		for($i = 0; $i < count($usun_licz); $i++)
		{
			if(isset($_POST['usun'.$i]))
			{
				$connection->query("DELETE FROM users WHERE id='$usun_licz[$i]'");
				$connection->query("DELETE FROM hobby WHERE id_osoby='$usun_licz[$i]'");
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
						<caption>Dane użytkowników</caption>
						<thead>
							<tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Login</th><th>Hasło</th><th>E-mail</th>
							<th>Edukacja</th><th>Hobby</th><th>Ulica</th><th>Nr domu</th><th>Kod pocztowy</th>
							<th>Miasto</th><th>Usuń</th></tr>
						</thead>
						<tbody>';
							$result = $connection->query("SELECT * FROM users");
							if($result->num_rows >0) 
							{
								$i=0;
								while ($r = $result->fetch_assoc()) 
								{
									$uzytkownik[$i] = $r['id'];
									echo '<tr><th>'.$r['id'].'</th>
									<td><input type="text" value='.$r['name'].' name="name'.$i.'"/></td>
									<td><input type="text" value='.$r['surname'].' name="surname'.$i.'"/></td>
									<td><input type="text" value='.$r['login'].' name="login'.$i.'"/></td>
									<td><input type="text" value='.$r['password'].' name="password'.$i.'"/></td>
									<td><input type="text" value='.$r['email'].' name="email'.$i.'"/></td>
									<td><select name="education'.$i.'">';
									if(($r['education'])=="podstawowe")
									{
										echo '<option selected="selected">podstawowe</option >';
									}
									else
									{
										echo '<option>podstawowe</option >';
									}
									if(($r['education'])=="średnie")
									{
										echo '<option selected>średnie</option >';
									}
									else
									{
										echo '<option>średnie</option >';
									}
									if(($r['education'])=="wyższe")
									{
										echo '<option selected>wyższe</option >';
									}
									else
									{
										echo '<option>wyższe</option >';
									}
																		
									$hobby = $connection->query("SELECT hobby FROM hobby WHERE id_osoby='".$r['id']."'");
									$S_Film ="";
									$S_Ksiazka ="";
									$S_Sport ="";
									$S_Muzyka ="";
									$S_Podroze ="";
									while($r_hobby = $hobby->fetch_assoc())
									{
										if(($r_hobby['hobby'])=="Film")
										{
											$S_Film = 'selected="selected"';
										}
										if(($r_hobby['hobby'])=="Książka")
										{
											$S_Ksiazka = 'selected="selected"';
										}
										if(($r_hobby['hobby'])=="Sport")
										{
											$S_Sport = 'selected="selected"';
										}
										if(($r_hobby['hobby'])=="Muzyka")
										{
											$S_Muzyka = 'selected="selected"';
										}
										if(($r_hobby['hobby'])=="Podróże")
										{
											$S_Podroze = 'selected="selected"';
										}
									}
									echo '<td><select name="hobby'.$i.'[]" multiple="multiple">
										<option value="Film"'.$S_Film.'>Film</option >
										<option value="Książka"'.$S_Ksiazka.'>Książka</option >
										<option value="Sport"'.$S_Sport.'>Sport</option >
										<option value="Muzyka"'.$S_Muzyka.'>Muzyka</option >
										<option value="Podróże"'.$S_Podroze.'>Podróże</option >
									</select ></td>
									<td><input type="text" value='.$r['street'].' name="street'.$i.'"/></td>
									<td><input type="text" value='.$r['number'].' name="number'.$i.'"/></td>
									<td><input type="text" value='.$r['kod'].' name="kod'.$i.'"/></td>
									<td><input type="text" value='.$r['city'].' name="city'.$i.'"/></td>
									<td><input type="submit" name="usun'.$i.'" value="usuń"/></td></tr>';
									$i++;
									$hobby->close();
								}
								$_SESSION['liczba_pol'] = $i;
							}
						echo '</tbody>';
						$_SESSION['numer_id'] = $uzytkownik;
					echo '</table>
					<div class="koszyk_przyciski">
						<ul>
							<li><input type="submit" name="Wroc" value="Wróć" id="Dane_button" /></li>
							<li><input type="submit" name="Zatwierdz" value="Zatwierdź" id="Dane_button" /></li>
						</ul>
					</div>';
					$connection->close();
				?>
			</form>
			<div class="czysc"></div>

	</div>
</body>

</html>