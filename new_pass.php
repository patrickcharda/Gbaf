<?php
include('session_start.php');
include('fonctions_account.php');

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
		$verif .="pb";
	}
	if (!is_null($verif))
	{
		header('Location:qr.php?&verif='.$verif); // s'il y a des choses à corriger on réaffiche le formulaire
	}
	else
	{
		$pass_hache=password_hash($_POST['pass'], PASSWORD_DEFAULT);
		include('connexion_bdd.php');
		if (isset($bdd))
		{
			$req = $bdd->prepare('UPDATE account SET passwd= :pass WHERE id= :id ') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
					'pass'=>$pass_hache,
					'id'=>$_SESSION['id']
				));	
			$req->closeCursor();
			header('Location:sas.php');
		}
		else
		{
			echo 'pb de connexion bdd; veuillez contacter l\'administrateur du site';
		}
	}
}
else
{
	header('Location:mdp_oubli.php');

}

?>


