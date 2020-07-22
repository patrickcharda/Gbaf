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
	header('Location:./../sas.php');
}
else
{
	//vérifier infos de connexion
	include('./../fonctions/connexion_bdd.php');
	//si connexion depuis formulaire
	if (isset($_POST['pseudooumail']) AND isset($_POST['pass']) && $_POST['pseudooumail']!='' && $_POST['pass']!='')
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
	//si connexion automatique
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
	else 
	{
		header("Location:./../sas.php?connex=777");
	}

	//verif captcha
	if ($_POST['code'] == $_SESSION['code'])
	{
		if (isset($valeur) AND isset($pass))
		{
			if (isset($bdd))
			{
				//on verifie login et mot de passe dans la bdd
				$req = $bdd->prepare('SELECT id, id_groupe, mail, username, passwd, prenom, nom, question, reponse FROM account WHERE '.$critere.'= ?') or die(print_r($bdd->errorInfo()));
				$req->execute(array(
				$valeur
				));	
				$donnees = $req->fetch();
				if (!empty($donnees))
				{
					$isPasswordCorrect = password_verify($pass, $donnees['passwd']);
					if ($isPasswordCorrect)
					{
						$_SESSION['id']=htmlspecialchars($donnees['id']);
						$_SESSION['login']=htmlspecialchars($donnees['username']);
						$_SESSION['mail']=htmlspecialchars($donnees['mail']);
						$_SESSION['groupe']=htmlspecialchars($donnees['id_groupe']);
						$_SESSION['prenom']=htmlspecialchars($donnees['prenom']);
						$_SESSION['nom']=htmlspecialchars($donnees['nom']);
						$_SESSION['question']=htmlspecialchars($donnees['question']);
						$_SESSION['reponse']=htmlspecialchars($donnees['reponse']);
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
							//ok on donne accès à l'extranet
							header('Location:./../espacemembres.php');
						}
					}
					else
					{
						//pb de mot de passe
						header("Location:./../sas.php?connex=777");
						$req->closeCursor();
					}
				}
				else
				{
					//la requete ne retourne aucun résultat
					$req->closeCursor();
					header("Location:./../sas.php?connex=777");
				}
			}
			else
			{
				//problème de connexion à la base de données
				header("Location:./../sas.php?connex=777");
			}
		}
		else 
		{
			//comment est-ce possible?
			header("Location:./../sas.php?connex=777");
		}
	}
	else
	{
		//incohérence captcha
		$verif .='code';
		header('Location:./../sas.php?connex=777&verif='.$verif);
	}
}


?>