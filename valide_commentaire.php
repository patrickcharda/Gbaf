<?php

include('session_start.php');
include('connexion_bdd.php');

if (isset($_POST['comment']))
{
	$comment = htmlspecialchars($_POST['comment']);
	if (isset($bdd))
		{
			$req = $bdd->prepare('INSERT INTO posts(id_account, id_acteur, post) VALUES(:id_account, :id_acteur, :post)') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				'id_account'=>$_SESSION['id'],
				'id_acteur'=>$_SESSION['id_acteur'],
				'post'=>$comment
			));
			$req->closeCursor();
			header('Location:details.php?acteur='.$_SESSION['id_acteur']);
		}
}


