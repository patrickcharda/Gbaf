<?php
include('session_start.php');
include('connexion_bdd.php');
include('fonctions_account.php');
/*
gère la connexion à l'espace membres
*/

//déconnexion
if (isset($_GET['deconnexion']))
{
	setcookie('pseudooumail', '', 1);
	setcookie('pass', '', 1);
	session_destroy();
	unset($_GET['deconnexion']);
	header('Location:sas.php');
}
else
{
	//vérifier infos de connexion
	include('connexion_bdd.php');
	if (isset($_POST['pseudooumail']) AND isset($_POST['pass']))
	{
		if (preg_match('#@#', $_POST['pseudooumail']))
		{
			$critere = 'mail';
			$valeur = $_POST['pseudooumail'];
			$pass = $_POST['pass'];
		}
		else
		{
			$critere = 'username';
			$valeur = $_POST['pseudooumail'];
			$pass = $_POST['pass'];
		}
	}
	else if (isset($_COOKIE['pseudooumail']) AND $_COOKIE['pseudooumail']!='' AND isset($_COOKIE['pass']) AND $_COOKIE['pass']!='')
	{
		if (preg_match('#@#', $_COOKIE['pseudooumail']))
		{
			$critere = 'mail';
			$valeur = $_COOKIE['pseudooumail'];
			$pass = $_COOKIE['pass'];
		}
		else
		{
			$critere = 'username';
			$valeur = $_COOKIE['pseudooumail'];
			$pass = $_COOKIE['pass'];
		}
	}
	if (isset($_POST['code']) AND isset($_SESSION['code']) AND $_SESSION['code'] != $_POST['code'])
	{	
		unset($_SESSION['code']);
		header('Location:sas.php');
	}
	if (isset($valeur) AND isset($pass))
	{
		if (isset($bdd))
		{
			//on verifie login et mot de passe dans la bdd
			$req = $bdd->prepare('SELECT id, id_groupe, mail,username,passwd FROM account WHERE '.$critere.'= ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
			$valeur
			));	
			$donnees = $req->fetch();
			if (!empty($donnees))
			{
				$isPasswordCorrect = password_verify($pass, $donnees['passwd']);
				if ($isPasswordCorrect)
				{
					$_SESSION['id']=$donnees['id'];
					$_SESSION['login']=$donnees['username'];
					$_SESSION['mail']=$donnees['mail'];
					$_SESSION['groupe']=$donnees['id_groupe'];
					$req->closeCursor();
					if (isset($_POST['auto']) AND $_POST['auto']=='on')
					{
						setcookie('pseudooumail',$_POST['pseudooumail'],time()+365*24*3600,null,null,false,true);
						setcookie('pass',$_POST['pass'],time()+365*24*3600,null,null,false,true);
					}
					if ($_SESSION['groupe'] == 2)
					{	
					header('Location:admin.php');
					}
					else
					{
						header('Location:espacemembres.php');
					}
				}
				else
				{
					echo 'pb de mot de passe';
					$req->closeCursor();
				}
			}
			else
			{
				$req->closeCursor();
				echo 'identifiant ou mot de passe incorrect';
			}

		}
		else
		{
			echo 'pb acces bdd';
		}
	}
	else 
	{
		header('Location:sas.php');
	}
}

?>