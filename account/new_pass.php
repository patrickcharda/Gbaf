<?php
include('./../fonctions/session_start.php');
include('./../fonctions/fonctions_account.php');

/* 
si le formulaire de maj du password est ok on update ds la bdd
*/
	

/* VERIFICATIONS VALIDITE CHAMPS */

//premières vérifications

if (isset($_POST['question']) AND isset($_POST['reponse']) AND isset($_POST['pass']))
{	
	$verif=null;
	if (!($_SESSION['question'] == $_POST['question']) OR !($_SESSION['reponse'] == $_POST['reponse']))
	{
		$verif .="qrhs";
	}
	if (strlen($_POST['pass']) < 6 OR strlen($_POST['pass']) > 10)
	{
		$verif .='motdepasse';
	}
	if (!is_null($verif))
	{
		header('Location:mdp_oubli.php?verif='.$verif); // s'il y a des choses à corriger on réaffiche le formulaire 
	}
	else
	{
		$pass_hache=password_hash($_POST['pass'], PASSWORD_DEFAULT);
		include('./../fonctions/connexion_bdd.php');
		if (isset($bdd))
		{
			$req = $bdd->prepare('UPDATE account SET passwd= :pass WHERE id= :id ') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
					'pass'=>$pass_hache,
					'id'=>$_SESSION['joker']
				));	
			$req->closeCursor();
			header('Location:./../sas.php');
		}
		else
		{
			header('Location:./../sas.php?connex=\'888\'');
		}
	}
}
else
{
	$verif ="incomplet";
	header('Location:mdp_oubli.php?verif='.$verif);

}

?>


