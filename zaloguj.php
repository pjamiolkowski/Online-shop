<?php
	
	session_start();
	
	if((!isset($_POST['login']))||(!isset($_POST['password'])))
	{
		header('Location: login.php');
		exit();
	}
	
	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	$connection->query('SET NAMES utf8');
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{	
		$login = $_POST['login'];
		$password = $_POST['password'];
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		if($result = @$connection->query(
		sprintf("SELECT * FROM users WHERE login='%s'",
		mysqli_real_escape_string($connection,$login))))
		{
			$ilu_userow = $result->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $result->fetch_assoc();
				
				if(password_verify($password, $wiersz['password']))
				{
				
					$_SESSION['user'] = $wiersz['login'];
					unset($_SESSION['error']);
					if($wiersz['login'] == "admin")
					{
						header('Location:admin.php');
					} 
					else
					if($_SESSION['Przycisk_wyslij'])
					{
						header('Location:koszyk.php');						
					} else
					{
						header('Location:index.php');
					}
					$result->close();
				}
				else
				{
					$_SESSION['error'] = '<span>Nieprawidłowy login lub hasło!</span>';
					header('Location:login.php');
					$result->close();
				}
			}
			else
			{
				$_SESSION['error'] = '<span>Nieprawidłowy login lub hasło!</span>';
				header('Location:login.php');
				$result->close();
			}
			
		}
		$connection->close();
	}
?>