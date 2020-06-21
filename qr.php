<?php
include('session_start.php');
include('fonctions_account.php');

/* 
si le user existe on lui affiche un formulaire avec les champs question, reponse, mot de passe
*/
	
if (isset($_GET['verif']))
{
	if (preg_match('#qr#', $_GET['verif']))
	{
		echo 'question-réponse à vérifier <br />';
	}
}
/* VERIFICATIONS VALIDITE CHAMPS */

//premières vérifications

if (isset($_POST['pseudooumail']) AND !is_null($_POST['pseudooumail']) AND isset($_POST['code']) AND !is_null($_POST['code']) OR isset($_SESSION['pseudooumail']))
{

	if (isset($_POST['pseudooumail']))
	{
		$_SESSION['pseudooumail']=htmlspecialchars($_POST['pseudooumail']);
	}
	$verif=null;
	if ($_POST['code'] != $_SESSION['code'])
	{
		$verif .='code';
		//unset($_SESSION['code']);
	}
	if (!is_null($verif))
	{
		header('Location:mdp_oubli.php?verif='.$verif); // captcha à corriger on réaffiche le formulaire
	}
	else
	{
		include('connexion_bdd.php');
		if (isset($bdd))
		{
			$req = $bdd->prepare('SELECT id, username, question, reponse FROM account WHERE username= ? or mail = ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array($_SESSION['pseudooumail'],$_SESSION['pseudooumail']));	
			$donnees = $req->fetch();

			if (!empty($donnees)) // on affiche le formulaire de modification du mot de passe
			{
				$_SESSION['joker']=$donnees['id'];
				$_SESSION['question']=$donnees['question'];
				$_SESSION['reponse']=$donnees['reponse'];
				$req->closeCursor();

				?>
				<form action="new_pass.php" method="post">
				<h5>Réinitialisation du mot de passe</h5>
				<p>
				<label for="question"> * Question </label><input type="text" name="question" id="question" />
				</p>	
				<p>
				<label for="reponse"> * Réponse </label><input type="text" name="reponse" id="reponse" />
				</p>
				<p>
				<label for="pass"> * Nouveau mot de passe </label><input type="password" name="pass" id="pass" />
				</p>
				<input type="submit" value="Envoyer">
				</form>
				<p><a href="sas.php">retour à l'accueil</a></p>

			<?php
			} 
			else
			{
				$verif .='login';
				header('Location:mdp_oubli.php?verif='.$verif); // user inconnu on réaffiche le formulaire
			}
		}
		else
		{
			$verif .='bdd';
			header('Location:mdp_oubli.php?verif='.$verif);
		}
	
	}
}
else
{
	$verif='pb';
	header('Location:mdp_oubli.php?verif='.$verif);
}

?>


