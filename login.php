<?php
	session_start();
	if(isset($_SESSION['user']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title> Hydraulika siłowa </title>
	<meta charset="UTF-8" />
	<meta name="description" content="Najlepsza hydraulika siłowa, najlepsze ceny!!!" />
	<meta name="keywords" content="rozdzielacze, pompy hydrauliczne, akumulatory hydrauliczne, orbitrole, zawory hydrauliczne" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
</head>

<body>
	<div id="login">
		<form action="zaloguj.php" method="post">
			<h1 class="title">Zaloguj się</h1>
			Login: <input type="text" name="login" class="field" /><br /><br />
			Hasło: <input type="password" name="password" class="field" /><br /><br />
			<?php
				if(isset($_SESSION['error']))
				{
					echo "<span id='error'>".$_SESSION['error']."</span ><br />";
					unset($_SESSION['error']);
				}
			?>
			<span id="textRejestracji">Nie masz jeszcze konta? Zarejestruj się <a href="register.php"> tutaj </a></span ><br /><br />
			<input type="submit" value="Zaloguj" id="button" /><br /><br/>
		</form>
	</div>
</body>

</html>