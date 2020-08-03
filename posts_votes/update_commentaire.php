<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');

if (!ok_login())
{
	header('Location:./account/connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}
if (isset($_POST['mise_a_jour']))
{
	$today = date("Y-m-d H:i:s"); 
	$comment = htmlspecialchars($_POST['comment']);
	if (isset($bdd))
		{
			$req = $bdd->prepare('UPDATE posts SET post= ?, date_add=? WHERE id= ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				$comment,
				$today,
				$_SESSION['post_id']
			));
			$req->closeCursor();
			header('Location:details.php?acteur='.$_SESSION['id_acteur']);
		}
}
else if (isset($_POST['suppression']))
{
	if (isset($bdd))
		{
			$req = $bdd->prepare('DELETE FROM posts WHERE id= ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				$_SESSION['post_id']
			));
			$req->closeCursor();
			header('Location:details.php?acteur='.$_SESSION['id_acteur']);
		}
}


