<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');

if (isset($_POST['comment']))
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


