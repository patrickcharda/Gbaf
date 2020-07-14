<?php
include('./../fonctions/session_start.php');
include('./../fonctions/fonctions_account.php');
include('./../fonctions/connexion_bdd.php');
include('./../templates/header.php');


if (!ok_login())
{
	header('Location:./connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}


if (!isset($_POST['question']) OR !isset($_POST['reponse']) OR $_POST['question']=='' || $_POST['reponse']=='')
{
	header('Location:./mon_compte.php?verif=00');
}
else
{
	if (isset($bdd))
	{
		$req = $bdd->prepare('UPDATE account SET question= :question, reponse= :reponse WHERE id= :id') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
				'question'=>htmlspecialchars($_POST['question']),
				'reponse'=>htmlspecialchars($_POST['reponse']),
				'id'=>$_SESSION['id']
			));
		$req->closeCursor();
		header('Location:./mon_compte.php?verif=11');
	}
	else
	{
		header('Location:./mon_compte.php?verif=22');
	}
}

include('./../templates/footer.php');
?>


