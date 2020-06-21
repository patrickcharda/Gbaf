<?php
include('session_start.php');
include('connexion_bdd.php');

if (isset($_POST['comment']))
{
	$comment = htmlspecialchars($_POST['comment']);
	$today = date("Y-m-d H:i:s");
	if (isset($bdd))
		{
			$req = $bdd->prepare('INSERT INTO posts(id_account, id_acteur, post, date_add) VALUES(:id_account, :id_acteur, :post, :date_add)') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				'id_account'=>$_SESSION['id'],
				'id_acteur'=>$_SESSION['id_acteur'],
				'post'=>$comment,
				'date_add'=>$today
			));
			$req->closeCursor();
			header('Location:details.php?acteur='.$_SESSION['id_acteur']);
		}
}


