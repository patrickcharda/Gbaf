<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
supprFichiersCaptcha(); 
include('./../templates/header.php');

if (!ok_login() && !is_admin())
{
	header('Location:./../sas.php');
}

?>
<main>
	<div class="col-deco-gauche"></div>
	<div class="col-gouttiere-gauche"></div>
	<div class="col-contenu" >
		<div class="frm radius">
		<?php
		echo 'PAGE ADMINISTRATEUR';
		echo '<br /><hr />';
		if (isset($_GET['message']))
		{
			switch ($_GET['message']) 
			{
				case '0':
				echo '- accès non autorisé';
				break;
				case '15':
				echo '- insertion effectuée';
				break;
				case '2':
				echo '- problème de format de fichier : soit l\'extension est incorrecte (doit être .png), soit il ne s\'agit pas d\'un fichier image' ;
				break;
				case '3':
				echo '- vérifier la taille du fichier';
				break;
				case '4':
				echo '- problème de chargement du fichier';
				break;
				case '6':
				echo '- problème d\'accès à la base de données';
				break;
			}
		}
		?>
			<form action="add_acteur.php" method="post" enctype="multipart/form-data">
				<h5>INSERER UN NOUVEL ACTEUR</h5>
				<p>
					<label for="acteur"> Nom de l'acteur* : </label><input type="text" name="acteur" id="acteur" maxlength="75" />
				</p>
				<p>
					<label for="description"> Présentation* : </label>
					<textarea name="description" id="description" maxlength="2500" >
					Présentation de l'acteur
					</textarea>
				</p>
				<p>
					<span> Sélectionner le fichier logo (.png) : </span>
					<input type="file" name="monfichier" /><br />
				</p>
				<input type="submit" value="Insérer">
			</form>
			<hr />
			<form action="change_presentation_gbaf.php" method="post">
				<h5>MODIFIER LE TEXTE DE PRESENTATION DU GBAF</h5>
				<?php
				$reponse = $bdd->query('SELECT presentation FROM identite WHERE id=1') or die(print_r($bdd->errorInfo()));
				echo '<textarea name="presentation_gbaf">';
				$texte_presentation= $reponse->fetch();
				echo $texte_presentation['presentation'];
				echo '</textarea>';
				?>
				<input type="submit" value="Mettre à jour" />
			</form>
			<hr />
		</div><!--div frm-->
	</div><!--div contenu-->
<?php
include('./../templates/colonnes_deco_droite.php');
?>

<p><a href="./fonctions/connexion.php?deconnexion=1" style="text-decoration:none;">&emsp;</a></p>

<?php
include('./../templates/footer.php');
?>


