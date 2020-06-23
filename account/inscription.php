<?php
include('./../fonctions/session_start.php');
include('./../fonctions/fonctions_account.php');


/* reçoit le formulaire d'inscription et enregistre ds la bdd
si le formulaire est ok et que le username n'est pas déjà pris (ni l'adresse mail) 
alors on enregistre l'utilisateur ds la bdd et on le ramène sur la page de login
*/


/* sauvegarde des champs du formulaire pour éviter ressaisie si erreurs*/

	if (isset($_POST['pseudooumail']))
	{
		save_form_field('username',$_POST['pseudooumail']);
	}
	if (isset($_POST['mail']))
	{
		save_form_field('mail',$_POST['mail']);
	}
	if (isset($_POST['nom']))
	{
		save_form_field('nom',$_POST['nom']);
	}
	if (isset($_POST['prenom']))
	{
		save_form_field('prenom',$_POST['prenom']);
	}
	if (isset($_POST['question']))
	{
		save_form_field('question',$_POST['question']);
	}
	if (isset($_POST['reponse']))
	{
		save_form_field('reponse',$_POST['reponse']);
	}	

/* VERIFICATIONS VALIDITE CHAMPS */

//premières vérifications

if (isset($_POST['pseudooumail']) AND isset($_POST['question']) AND isset($_POST['reponse'])AND isset($_POST['nom']) AND isset($_POST['prenom']) AND isset($_POST['mail']) AND isset($_POST['pass']) AND isset($_POST['code']))
{	
	$verif=null;
	//verif mot de passe 
	if (strlen($_POST['pass']) < 6 OR strlen($_POST['pass']) > 10)
	{
		$verif .='motdepasse';
	}
	//verif captcha
	if ($_POST['code'] != $_SESSION['code'])
	{
		$verif .='code';
		unset($_SESSION['code']);
	}
	//verif username
	if (strlen($_POST['pseudooumail']) > 20 OR !preg_match('#^[a-zA-Z0-9_\.-]{1,20}$#',$_POST['pseudooumail'])) //pas d@ ds username
	{
		$verif .='pseudo';
	}
	//verif nom
	if (strlen($_POST['nom']) > 25 OR !preg_match('#^[a-zA-Z-]{1,25}$#',$_POST['nom']))
	{
		$verif .='nom';
	}
	//verif prénom
	if (strlen($_POST['prenom']) > 25 OR !preg_match('#^[a-zA-Z-]{1,25}$#',$_POST['prenom'])) 
	{
		$verif .='prenom';
	}
	//verif question
	if (strlen($_POST['question']) > 30 OR !preg_match('#^[a-zA-Z -]{1,30}$#',$_POST['question']))
	{
		$verif .='question';
	}
	//verif reponse
	if (strlen($_POST['reponse']) > 30 OR !preg_match('#^[a-zA-Z -]{1,30}$#',$_POST['reponse'])) 
	{
		$verif .='reponse';
	}
	//verif mail

	if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['mail']) OR preg_match('#\.\.|__|--|\.-|-\.|\._|_\.|-_|_-|\.@|@\.|-@|@-|_@|@_#', $_POST['mail']))
	{
		$verif .='mail';

	}
	if (!is_null($verif))
	{
		header('Location:./../sas.php?nouveaumembre=1&verif='.$verif); // s'il y a des choses à corriger on réaffiche le formulaire
	}

// pas d erreur ds formumaire donc vérifier user non déjà existant avant insertion bdd :

	else
	{
		include('./../fonctions/connexion_bdd.php');
		if (isset($bdd))
		{
			$req = $bdd->prepare('SELECT username,mail FROM account WHERE username= ? or mail = ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array($_POST['pseudooumail'],$_POST['mail']));	
			$donnees = $req->fetch();

			if (!empty($donnees)) //s'il y a un resultat le username ou le mail existe deja
			{
				//verifier si doublon username ou mail ou les 2
				if ($donnees['username'] == $_POST['pseudooumail'])
				{
					$verif .= "1";
				}
				if ($donnees['mail'] == $_POST['mail'])
				{
					$verif .= "2";
				} 
				$req->closeCursor();
				/*$_POST['mail'] = preg_replace('#@#', '(at)', $_POST['mail']); // remplacer l'@ par ()at pour passage url
				$verif .='&p='.$_POST['pseudooumail'].'&m='.$_POST['mail'];*/
				header("Location:./../sas.php?nouveaumembre=0&verif=$verif");
			}

				// on peut insérer le nouvel util dans la bdd :
			else
			{
				
				$pass_hache=password_hash($_POST['pass'], PASSWORD_DEFAULT);
				$req = $bdd->prepare('INSERT INTO account(username,nom,prenom,mail,passwd,date_inscription,question,reponse) VALUES(:username, :nom, :prenom, :mail, :pass, CURDATE(), :question, :reponse)') or die(print_r($bdd->errorInfo()));
				$req->execute(array(
					'username'=>$_POST['pseudooumail'],
					'nom'=>$_POST['nom'],
					'prenom'=>$_POST['prenom'],
					'mail'=>$_POST['mail'],
					'pass'=>$pass_hache,
					'question'=>$_POST['question'],
					'reponse'=>$_POST['reponse']
				));	
				$req->closeCursor();
				//$_SESSION['insert']='ok';
				// gérer cookie :
				if (isset($_POST['auto']))
				{
					setcookie('pseudooumail',$_POST['pseudooumail'],time()+365*24*3600,null,null,false,true);
					setcookie('pass',$_POST['pass'],time()+365*24*3600,null,null,false,true);
				}
				session_destroy();
				unset($_SESSION);
				header('Location:./../sas.php?insertuser=1');
			}
		}
		else
		{
			echo 'pb de connexion à la base de données';
		}

	}
}
else
{
	header('Location:./../sas.php');

}

?>


