<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
include('./../fonctions/fonctions_posts_votes.php');
include('./../templates/header.php');
/*
afficher le détail d'un acteur
*/


if (!ok_login())
{
	header('Location:../account/connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}

if (isset($_POST['ajout_commentaire']))
{
	unset($_POST['ajout_commentaire']);
	?>

	<form action="valide_commentaire.php" method="post">
	<textarea name="comment" id="comment" rows="4" cols="50" maxlength="750">
	</textarea>
	<input type="submit" value="Envoyer">
	</form>

	<?php
}
else if (isset($_POST['modif_commentaire']))
{
	unset($_POST['modif_commentaire']);
	//print_r($_SESSION['infos_user_comment']);
	//echo $_SESSION['infos_user_comment']['post_content'];
	?>
	<form action="update_commentaire.php" method="post">
	<textarea name="comment" id="comment" rows="4" cols="50" maxlength="750">
		<?php
		echo $_SESSION['infos_user_comment']['post_content'];
		?>
	</textarea>
	<input type="submit" value="mise à jour" name="mise_a_jour"> ou <input type="submit" value="suppression" name="suppression">
	</form>
<?php
}

?>









