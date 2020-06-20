<?php

include('session_start.php');
include('connexion_bdd.php');

if (isset($_POST['comment']))
{
	$comment = htmlspecialchars($_POST['comment']);
	if (isset($bdd))
		{
			$req = $bdd->prepare('UPDATE posts SET post= ? WHERE id= ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				$comment,
				$_SESSION['post_id']
			));
			$req->closeCursor();
			header('Location:details.php?acteur='.$_SESSION['id_acteur']);
		}
}


