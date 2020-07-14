<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
supprFichiersCaptcha();
/*
gère la connexion à l'espace membres
*/

//déconnexion
if (isset($_GET['deconnexion']))
{
	if (isset($_COOKIE['pseudooumail']))
	{
		unset($_COOKIE['pseudooumail']);
		unset($_COOKIE['pass']);
	} 
	session_destroy();
	unset($_GET['deconnexion']);
	header('Location:./../sas.php');
}
else
{
	//vérifier infos de connexion
	include('./../fonctions/connexion_bdd.php');
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
	//verif captcha :
	if (isset($_POST['code']) AND isset($_SESSION['code']) AND $_SESSION['code'] != $_POST['code'])
	{	
		unset($_SESSION['code']);

		unset($_POST['code']);

		header('Location:./../sas.php');
		
	}

	if (isset($valeur) AND isset($pass))
	{
		if (isset($bdd))
		{
			//on verifie login et mot de passe dans la bdd
			$req = $bdd->prepare('SELECT id, id_groupe, mail,username,passwd,prenom,nom FROM account WHERE '.$critere.'= ?') or die(print_r($bdd->errorInfo()));
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
					$_SESSION['prenom']=$donnees['prenom'];
					$_SESSION['nom']=$donnees['nom'];
					$req->closeCursor();
					if (isset($_POST['auto']) AND $_POST['auto']=='on')
					{
						setcookie('pseudooumail',$_POST['pseudooumail'],time()+365*24*3600,null,null,false,true);
						setcookie('pass',$_POST['pass'],time()+365*24*3600,null,null,false,true);
					}
					if ($_SESSION['groupe'] == 2)
					{	
					header('Location:./../admin/admin.php'); //page pour saisie nouvel acteur
					}
					else
					{
						header('Location:./../espacemembres.php');
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
		header('Location:./../sas.php');
		//echo 'toto';
	}
}

?>