<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');

if (!isset($_SESSION['groupe']) AND isset($_SESSION['login']) AND $_SESSION['groupe']==2)
{
	header('Location:./../sas.php');
}
else if (isset($bdd))
{
	$req = $bdd->prepare('INSERT INTO acteurs(acteur,description,logo) VALUES(:acteur, :description, :logo)') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
					'acteur'=>nl2br(htmlspecialchars($_POST['acteur'])),
					'description'=>nl2br(htmlspecialchars($_POST['description'])),
					'logo'=>nl2br(htmlspecialchars($_POST['logo']))
				));	
	$req->closeCursor();
	header('Location:admin.php');
}
?>