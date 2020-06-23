<?php
include('session_start.php');
include('connexion_bdd.php');
include('fonctions_posts_votes.php');

if (isset($_GET['vote']) AND isset($_SESSION['id_acteur']))
{
	switch ($_GET['vote']) 
	{
		case '0':
			vote($_SESSION['id'],$_SESSION['id_acteur'],0,$_SESSION['id_vote']); //update le vote à 0 (dislike)
			break;	
		case '1':
			vote($_SESSION['id'],$_SESSION['id_acteur'],1,$_SESSION['id_vote']); //update le vote à 1 (like) 
			break;
		case '2':
			vote($_SESSION['id'],$_SESSION['id_acteur'],2); //supprime le vote
			break;
		case '3':
			vote($_SESSION['id'],$_SESSION['id_acteur'],3); // insert like
			break;
		case '4':
			vote($_SESSION['id'],$_SESSION['id_acteur'],4); // insert dislike
			break;
	}
	header('Location:details.php?acteur='.$_SESSION['id_acteur']);
}
