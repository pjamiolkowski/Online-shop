<?php
	
	session_start();
	
	if((!isset($_SESSION['user'])) || ((isset($_SESSION['user'])) && ($_SESSION['user'] !== "admin")))
	{
		header('Location: index.php');
		exit();
	}
	
	if(isset($_POST['email']))
	{
		$wszystko_ok = true;
		$education = $_POST['education'];
		$city = $_POST['city'];
		$hobby = $_POST['hobby'];
		if(empty($hobby))
		{
			$wszystko_ok = false;
			$_SESSION['e_hobby'] = "Wybierz przynajmniej 1 hobby";
		}
		if(empty($city))
		{
			$wszystko_ok = false;
			$_SESSION['e_city'] = "Puste pole, wprowadź miasto";
		}
		
		$street = $_POST['street'];
		if(empty($street))
		{
			$wszystko_ok = false;
			$_SESSION['e_street'] = "Puste pole, wprowadź ulicę";
		}
		
		$number = $_POST['number'];
		if(empty($number))
		{
			$wszystko_ok = false;
			$_SESSION['e_number'] = "Puste pole, wprowadź numer domu/mieszkania.";
		}
		
		$postcode = $_POST['postcode'];
		if (!preg_match('/^[0-9]{2}-?[0-9]{3}+$/Du', $postcode)) 
		{
			$wszystko_ok = false;
			$_SESSION['e_postcode'] = "Niepoprawny kod pocztowy (**-***)";
		}
		$imie = $_POST['imie'];
		if (!preg_match('/^[a-ząśżźćęółńŁŻŻŚŹĆŃ]+$/i', $imie)) 
		{
			$wszystko_ok = false;
			$_SESSION['e_imie'] = "Niepoprawne imię użytkownika";
		}
		
		$surname = $_POST['surname'];
		if (!preg_match('/^[a-ząśżźćęółńŁŻŻŚŹĆŃ]+$/i', $surname)) 
		{
			$wszystko_ok = false;
			$_SESSION['e_surname'] = "Niepoprawne nazwisko użytkownika";
		}		
		
		$nick = $_POST['login'];
		if((strlen($nick)<3)||(strlen($nick)>15))
		{
			$wszystko_ok = false;
			$_SESSION['e_nick'] = "Login musi posiadać od 3 do 15 znaków";
		}
		
		if(ctype_alnum($nick)==false)
		{
			$wszystko_ok = false;
			$_SESSION['e_nick'] = "Login może się składać tylko z liter i cyfr";
		}
		
		$email = $_POST['email'];
		$emailF = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if(filter_var($emailF, FILTER_VALIDATE_EMAIL)==false || ($emailF!=$email))
		{
			$wszystko_ok = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
		}
		
		
		$haslo = $_POST['password'];
		if((strlen($haslo)<8)||(strlen($haslo)>20))
		{
			$wszystko_ok = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków";
		}
		
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
				//czy email już istnieje?
				$rezultat = $connection->query("SELECT id FROM users WHERE email='$email'");
				if(!$rezultat) throw new Exception($connection->error);
				
				$ile_takich_email = $rezultat->num_rows;
				if($ile_takich_email>0)
				{
					$wszystko_ok = false;
					$_SESSION['e_email'] = "Istnieje konto z takim adresem email";
				}
				
				//czy login już istnieje?
				$rezultat = $connection->query("SELECT id FROM users WHERE login='$nick'");
				if(!$rezultat) throw new Exception($connection->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_ok = false;
					$_SESSION['e_nick'] = "Istnieje już konto o takim loginie";
				}
				
				if($wszystko_ok ==true)
				{
					$_SESSION['wszystko_ok'] = true;
					$_SESSION['education'] = $education;
					$_SESSION['city'] = $city;	
					$_SESSION['street'] = $street;
					$_SESSION['number'] = $number;
					$_SESSION['postcode'] = $postcode;
					$_SESSION['imie'] = $imie;
					$_SESSION['surname'] = $surname;
					$_SESSION['login'] = $nick;
					$_SESSION['email'] = $email;
					$_SESSION['password'] = $haslo;
					$_SESSION['hobby'] = $hobby;
					header('Location:podsumowanie.php');
					$connection->close();
					exit();
				}
				
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo 'Błąd serwera! Prosimy o rejestrację w innym terminie.';
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
			<h1 class="title">Dodaj użytkownika</h1>
			<?php
				if(isset($_POST['imie']))
				{
					echo 'Imię: <input type="text" name="imie" value="'.$_POST['imie'].'" class="field" />';
				} else
				{
					echo 'Imię: <input type="text" name="imie" class="field" />';
				}
				if(isset($_SESSION['e_imie']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_imie'].'</div>';
					unset($_SESSION['e_imie']);
				}
				else
					echo '<br /><br />';
				if(isset($_POST['surname']))
				{
					echo 'Nazwisko: <input type="text" name="surname" value="'.$_POST['surname'].'" class="field" />';
				} else
				{
					echo 'Nazwisko: <input type="text" name="surname"  class="field" />';
				}
				if(isset($_SESSION['e_surname']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_surname'].'</div>';
					unset($_SESSION['e_surname']);
				}
				else
					echo '<br /><br />';	
				if(isset($_POST['login']))
				{
					echo 'Login: <input type="text" name="login" value="'.$_POST['login'].'" class="field" />';
				} else
				{
					echo 'Login: <input type="text" name="login" class="field" />';
				}			
				if(isset($_SESSION['e_nick']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_nick'].'</div>';
					unset($_SESSION['e_nick']);
				}
				else
					echo '<br /><br />';
			?>
			Hasło: <input type="password" name="password" class="field" />
			<?php
				if(isset($_SESSION['e_haslo']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_haslo'].'</div>';
					unset($_SESSION['e_haslo']);
				}
				else
					echo '<br /><br />';		
				if(isset($_POST['email']))
				{
					echo 'Email: <input type="text" name="email" value="'.$_POST['email'].'" class="field" />';
				} else
				{
					echo 'Email: <input type="text" name="email" class="field" />';
				}
				if(isset($_SESSION['e_email']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
				else
					echo '<br /><br />';
			?>
			Wykształcenie: <select name="education" id="choose" >
				<option>podstawowe</option >
				<option>średnie</option >
				<option>wyższe</option >
			</select ><br /><br />
			Hobby: <select name="hobby[]" id="hobby" multiple="multiple">
				<option value="Film" selected="selected">Film</option >
				<option value="Książka">Książka</option >
				<option value="Sport">Sport</option >
				<option value="Muzyka">Muzyka</option >
				<option value="Podróże">Podróże</option >
			</select >
			<?php
				if(isset($_SESSION['e_hobby']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_hobby'].'</div>';
					unset($_SESSION['e_hobby']);
				}
				else
					echo '<br /><br />';
				if(isset($_POST['street']))
				{
					echo 'Ulica: <input type="text" name="street" value="'.$_POST['street'].'" class="field" />';
				} else
				{
					echo 'Ulica: <input type="text" name="street" class="field" />';
				}			
				if(isset($_SESSION['e_street']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_street'].'</div>';
					unset($_SESSION['e_street']);
				}
				else
					echo '<br /><br />';
				if(isset($_POST['number']))
				{
					echo 'Nr domu: <input type="text" name="number" value="'.$_POST['number'].'" class="field" />';
				} else
				{
					echo 'Nr domu: <input type="text" name="number" class="field" />';
				}
				if(isset($_SESSION['e_number']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_number'].'</div>';
					unset($_SESSION['e_number']);
				}
				else
					echo '<br /><br />';
				if(isset($_POST['postcode']))
				{
					echo 'Kod pocztowy: <input type="text" name="postcode" value="'.$_POST['postcode'].'" class="field" />';
				} else
				{
					echo 'Kod pocztowy: <input type="text" name="postcode" class="field" />';
				}
				if(isset($_SESSION['e_postcode']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_postcode'].'</div>';
					unset($_SESSION['e_postcode']);
				}
				else
					echo '<br /><br />';
				if(isset($_POST['city']))
				{
					echo 'Miasto: <input type="text" name="city" value="'.$_POST['city'].'" class="field" />';
				} else
				{
					echo 'Miasto: <input type="text" name="city" class="field" />';
				}			
				if(isset($_SESSION['e_city']))
				{
					echo '<div class="error_reg">'.$_SESSION['e_city'].'</div>';
					unset($_SESSION['e_city']);
				}
				else
					echo '<br /><br />';
			?>
			<input type="submit" value="Zarejestruj" id="button" /><br /><br/>
		</form>
	</div>
</body>

</html>