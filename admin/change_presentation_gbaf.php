<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
supprFichiersCaptcha(); 

if (isset($_POST['presentation_gbaf']))
{
	$texte= htmlspecialchars($_POST['presentation_gbaf']);
	$req = $bdd->prepare('UPDATE identite SET presentation = :prez WHERE id = 1 ') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
		'prez' => $texte
	));
	header('Location:./admin.php');
}




