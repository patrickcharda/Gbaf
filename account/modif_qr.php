<?php
include('./../fonctions/session_start.php');
include('./../fonctions/fonctions_account.php');
include('./../fonctions/connexion_bdd.php');
include('./../templates/header.php');


if (!ok_login())
{
	header('Location:./connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}


if (!isset($_POST['question']) || !isset($_POST['reponse']) || !isset($_POST['pseudooumail']) || !isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['pass']) OR $_POST['question']=='' OR $_POST['reponse']=='' OR $_POST['pseudooumail']=='' OR $_POST['nom']=='' OR $_POST['prenom']=='' OR $_POST['pass']=='')
{
	header('Location:./mon_compte.php?verif=00');
}
else
{
	if (isset($bdd))
	{
		$pass_hache=password_hash($_POST['pass'], PASSWORD_DEFAULT);
		$req = $bdd->prepare('UPDATE account SET question= :question, reponse= :reponse, username= :username, nom= :name, prenom= :prenom, passwd= :pass WHERE id= :id') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
				'question'=>htmlspecialchars($_POST['question']),
				'reponse'=>htmlspecialchars($_POST['reponse']),
				'username'=>htmlspecialchars($_POST['pseudooumail']),
				'name'=>htmlspecialchars($_POST['nom']),
				'prenom'=>htmlspecialchars($_POST['prenom']),
				'pass'=>htmlspecialchars($pass_hache),
				'id'=>$_SESSION['id']
			));
		$req->closeCursor();
		$_SESSION['login']=htmlspecialchars($_POST['pseudooumail']);
		$_SESSION['nom']=htmlspecialchars($_POST['nom']);
		$_SESSION['prenom']=htmlspecialchars($_POST['prenom']);
		$_SESSION['question']=htmlspecialchars($_POST['question']);
		$_SESSION['reponse']=htmlspecialchars($_POST['reponse']);


		header('Location:./mon_compte.php?verif=11');
	}
	else
	{
		header('Location:./mon_compte.php?verif=22');
	}
}

include('./../templates/footer.php');
?>


