<?php 
include('session_start.php');
include('connexion_bdd.php');
include('fonctions_account.php');
include('header.php');
supprFichiersCaptcha();
//verifier que session ouverte
if (isset($_SESSION['login']))
{
	echo 'bonjour '.$_SESSION['login'];
}
else
{
	header('Location:connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" type="text/css" href="./canvas6.css"> -->
	<title>Espace membres</title>
</head>
<body>

<H1>Bienvenue sur l'espace membre !</H1>

<!-- afficher ici le bandeau de présentation de GBAF -->

<?php

if (isset($bdd))
{
	$donnees = $bdd->query('SELECT id, acteur, description, logo FROM acteurs ORDER BY acteur ASC') or die(print_r($bdd->errorInfo()));	
	if (!is_null($donnees))
	{
		while ($ligne = $donnees->fetch())
		{
			echo '<p><img src='.$ligne['logo'].' /></p>';
			echo '<p><h3>'.$ligne['acteur'].'</h3></p><p>';

			$nb_de_mots_description=str_word_count($ligne['description']);
			$tableau_de_mots=str_word_count($ligne['description'],1);
			//print_r($tableau_de_mots);
			$resume=null;

			for ($i=0;$i<$nb_de_mots_description and $i<20;$i++)
			{
				$resume .= nl2br(htmlspecialchars($tableau_de_mots[$i])).' ';
			}
			echo $resume;
			echo '<a href=details.php?acteur='.$ligne['id'].'>...</a>';
			echo '<p><form method="get" action="details.php" ><input type="hidden" name="acteur" value='.$ligne['id'].' /><button type="submit">Lire la suite</button></form></p>';
		}
	}
}


?>

<p><a href="./connexion.php?deconnexion=1"> Se déconnecter </a></p>

<?php
include('footer.php');
?>