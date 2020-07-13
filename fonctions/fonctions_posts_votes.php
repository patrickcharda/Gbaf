<?php
include('session_start.php');

function nombre_de($table,$nomChampId,$id)
{
	
	include('connexion_bdd.php');
	$reponse = $bdd->query('SELECT count(*) FROM '.$table.' WHERE '.$nomChampId.' = '.$id) or die(print_r($bdd->errorInfo()));

	if (!is_null($reponse))
	{
		$nb_de_qqch= $reponse->fetch();
		$reponse->closeCursor();
		return $nb_de_qqch['count(*)'];
	}
	
	return null;
}

function infos_likes($id_acteur)
{
	include('connexion_bdd.php');

	$reponse = $bdd->query('SELECT count(*) FROM votes WHERE  vote=1 AND id_acteur= '.$id_acteur) or die(print_r($bdd->errorInfo()));
	$data=$reponse->fetch();
	$likes['positifs']=$data[0]; // nombre de likes positifs pour cet acteur
	$reponse->closeCursor();

	$reponse = $bdd->query('SELECT count(*) FROM votes WHERE  vote=0 AND id_acteur= '.$id_acteur) or die(print_r($bdd->errorInfo()));
	$data=$reponse->fetch();
	$likes['negatifs']=$data[0]; // nombre de likes négatifs pour cet acteur
	$reponse->closeCursor();

	$req = $bdd->prepare('SELECT count(*) FROM votes WHERE id_acteur= ? AND id_account= ?') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
		$id_acteur,
		$_SESSION['id']
	));
	$reponse=$req->fetch();
	$likes['deja_vote']=$reponse[0]; // le user loggé a t il déjà voté pour cet acteur?
	$req->closeCursor();

	$req = $bdd->prepare('SELECT id, vote FROM votes WHERE id_acteur= ? AND id_account= ?') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
		$id_acteur,
		$_SESSION['id']
	));
	$reponse=$req->fetch();

	if ($reponse)
	{
		$likes['vote_content']=$reponse['vote'];// contenu du vote (0-like ou 1-dislike)
		$likes['id_vote']=$reponse['id'];
	}
	else
	{
		$likes['vote_content']='';
		$likes['id_vote']=0;
	}
	
	return $likes;
}

function vote($id_account,$id_acteur,$change,$id_vote = 0)
{
	(int)$id_account;
	(int)$id_acteur;
	(int)$change;
	(int)$id_vote;


	include('connexion_bdd.php');

	if ($change == 2) //suppression du vote
	{
	$req = $bdd->prepare('DELETE FROM votes WHERE  id_account= ? AND id_acteur= ?') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
		$id_account,
		$id_acteur
	));
	$req->closeCursor();
	}

	if ($change == 3) // insert vote positif
	{
	$req = $bdd->prepare('INSERT INTO votes (id_account,id_acteur,vote) VALUES(:id_account, :id_acteur, :vote)') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
		'id_account'=>$id_account,
		'id_acteur'=>$id_acteur,
		'vote'=>1
	));
	$req->closeCursor();
	}

	if ($change == 4) // insert vote negatif
	{
	$req = $bdd->prepare('INSERT INTO votes (id_account,id_acteur,vote) VALUES(:id_account, :id_acteur, :vote)') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
		'id_account'=>$id_account,
		'id_acteur'=>$id_acteur,
		'vote'=>0
	));
	$req->closeCursor();
	}

	if (isset($id_vote) AND $change == 0) // change en vote negatif
	{
	$req = $bdd->prepare('UPDATE votes SET vote=? WHERE id=?') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
	$change,$id_vote
	));
	$req->closeCursor();
	}

	if (isset($id_vote) AND $change == 1) // change en vote positif
	{
	$req = $bdd->prepare('UPDATE votes SET vote=? WHERE id=?') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
	$change,$id_vote
	));
	$req->closeCursor();
	}
}







