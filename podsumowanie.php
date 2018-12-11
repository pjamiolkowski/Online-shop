<?php
	session_start();
	
	if((empty($_SESSION['wszystko_ok'])) ||(!$_SESSION['wszystko_ok']))
	{
		header('Location:register.php');
		unset($_SESSION['wszystko_ok']);
		exit();
	}
	else
	{
		
		$education =  $_SESSION['education'];
		$city = $_SESSION['city'];	
		$street = $_SESSION['street'];
		$number = $_SESSION['number'];
		$postcode = $_SESSION['postcode'];
		$imie = $_SESSION['imie'];
		$surname = $_SESSION['surname'];
		$nick = $_SESSION['login'];
		$email = $_SESSION['email'];
		$haslo = $_SESSION['password'];
		$hobby = $_SESSION['hobby'];
		$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
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
					//wszystkie dane wpisane poprawnie
					if($connection->query("INSERT INTO users VALUES(NULL, '$imie', '$surname', '$nick', '$haslo_hash', '$email', '$education', '$street','$number', '$postcode', '$city')"))
					{
						$id_osoby = $connection->query("SELECT id FROM users WHERE login = '$nick'");
						$id = $id_osoby->fetch_array();
						
						if(isset($id))
						{
							for($i=0;$i<count($hobby);$i++)
							{	
								$connection->query("INSERT INTO hobby VALUES(NULL, '$id[0]', '$hobby[$i]')");
							}
						}
					}
					else
					{
						throw new Exception($connection->error);
					}
					if((isset($_SESSION['user'])) && ($_SESSION['user'] == "admin"))
					{
						header('Location:admin.php');
						exit();	
					}
					header('Location:login.php');					
					exit();
				}
				if((isset($_POST['return'])) && ($_POST['return']=="Wróć"))
				{
					if((isset($_SESSION['user'])) && ($_SESSION['user'] == "admin"))
					{
						header('Location:admin.php');
						exit();	
					}
					
						header('Location:register.php');
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
			<label class="preview"><span class="text1">Imię: </span ><?php echo $imie ?></label><br /><br />
			<label class="preview"><span class="text1">Nazwisko: </span ><?php echo $surname ?></label><br /><br />
			<label class="preview"><span class="text1">Login: </span ><?php echo $nick ?></label><br /><br />
			<label class="preview"><span class="text1">Hasło: </span ><?php echo $haslo ?></label><br /><br />
			<label class="preview"><span class="text1">Email: </span ><?php echo $email ?></label><br /><br />
			<label class="preview"><span class="text1">Wykształcenie: </span ><?php echo $education ?></label><br /><br />
			<label class="preview"><span class="text1">Hobby: </span >
			<?php
				for($i=0;$i<count($hobby);$i++)
				{			
					echo $hobby[$i].", ";
				}
			?>
			</label><br /><br />
			<label class="preview"><span class="text1">Ulica: </span ><?php echo $street ?></label><br /><br />
			<label class="preview"><span class="text1">Nr domu: </span ><?php echo $number ?></label><br /><br />
			<label class="preview"><span class="text1">Kod pocztowy: </span ><?php echo $postcode ?></label><br /><br />
			<label class="preview"><span class="text1">Miasto: </span ><?php echo $city ?></label><br /><br />
			</div>
			<form method="post"style="float: left">
				<input type="submit" name="return" value="Wróć" id="button1" />
			</form><form method="post"style="float: left">
				<input type="submit" name="send" value="Zatwierdź" id="button1" />
			</form><br /><br /><br />
	</div>
</body>

</html>