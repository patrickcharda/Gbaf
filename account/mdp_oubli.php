<?php 
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
supprFichiersCaptcha();
include('./../templates/header.php');


if (isset($_GET['verif']))
{
	$alerte=null;
	if (preg_match('#pb#', $_GET['verif']))
 	{
 		$alerte .= 'Identifiant et/ou code de sécurité incorrect <br />';
 	}
  	if (preg_match('#login#', $_GET['verif']))
 	{
 		$alerte .= 'Identifiant inconnu <br />';
 	}
   	if (preg_match('#code#', $_GET['verif']))
 	{
 		$alerte .= 'Code de sécurité incorrect <br />';
 	}
 	if (preg_match('#qrhs#', $_GET['verif']))
 	{
 		$alerte .= 'Question et/ou réponse incorrecte(s) <br />';
 	}
 	if (preg_match('#bdd#', $_GET['verif']))
 	{
 		echo 'Accès base de données indisponible. Veuillez réessayer ultérieurement <br />';
 	}
 	if (preg_match('#motdepasse#', $_GET['verif']))
 	{
 		$alerte .= 'Le mot de passe doit contenir entre 6 et 10 caractères <br />';
 	}
 	 if (preg_match('#incomplet#', $_GET['verif']))
 	{
 		$alerte .= 'Formulaire incomplet, vous devez saisir tous les champs... <br />';
 	}
}
?>

<?php
include('./../templates/colonnes_deco_gauche.php');
?>
			<div class="col-contenu" >
				<div class="frm radius">

<form action="qr.php" method="post">

		<h5>Veuillez saisir votre identifiant ou votre adresse mail</h5>
		<?php
		if (!is_null($alerte))
		{
			echo $alerte;
		}
		?>
		<p>
			<input type="text" name="pseudooumail" id="pseudooumail" maxlength="30" />
		</p>	
		<?php
		if (!isset($_SESSION['captcha']))
					{
						$nb_caracteres = mt_rand(2,4);
						$captcha = createCaptcha($nb_caracteres);
						$_SESSION['captcha'] = $captcha; 
						$verif=$_GET['verif'];
						$redirection = './mdp_oubli.php?verif='.$verif;
						createImageCaptcha($captcha,$redirection);
					}
					else
					{
						echo '<p><img src='.$_SESSION['chemin_vers_fic_image'].$_SESSION['fic_image'].' /><br />';
					?>
					<label for="code">Recopier les caractères</label><br />
					<input type="text" name="code" id="code">
					</p>
					<?php
					$_SESSION['code']=$_SESSION['captcha'];
					$req = $bdd->prepare('INSERT INTO imagefiles(image_file) VALUES(:image_file)') or die(print_r($bdd->errorInfo()));
					$req->execute(array(
					'image_file'=>$_SESSION['fic_image']
					));	
					$req->closeCursor();
					unset($_SESSION['captcha']);
					unset($_SESSION['fic_image']);
					}
		?>
		<input type="submit" value="Envoyer">
	</form>

				</div><!--div frm-->
			</div><!--div contenu-->
<?php
include('./../templates/colonnes_deco_droite.php');
include('./../templates/footer.php');
?>




