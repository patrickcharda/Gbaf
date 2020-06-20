<?php
include('session_start.php');
include('connexion_bdd.php');
include('fonctions_account.php');

if (!isset($_SESSION['groupe']) AND isset($_SESSION['login']) AND $_SESSION['login']==2)
{
	header('Location:sas.php');
}
else if (isset($bdd))
{
	$req = $bdd->prepare('INSERT INTO acteurs(acteur,description,logo) VALUES(:acteur, :description, :logo)') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
					'acteur'=>htmlspecialchars($_POST['acteur']),
					'description'=>htmlspecialchars($_POST['description']),
					'logo'=>htmlspecialchars($_POST['logo'])
				));	
	$req->closeCursor();
	header('Location:admin.php');
}
?>