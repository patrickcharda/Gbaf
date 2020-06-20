<?php 
include('session_start.php');
include('connexion_bdd.php');
include('fonctions_account.php');
supprFichiersCaptcha();

?>

<form action="qr.php" method="post">
		<h5>Veuillez saisir votre identifiant ou votre adresse mail</h5>
		<p>
			<input type="text" name="pseudooumail" id="pseudooumail" />
		</p>	
		<?php
		if (!isset($_SESSION['captcha']))
		{
			$nb_caracteres = mt_rand(2,4);
			$captcha = createCaptcha($nb_caracteres);
			$_SESSION['captcha'] = $captcha; 
			$verif=$_GET['verif'];
			$redirection = './mdp_oubli.php';
			createImageCaptcha($captcha,$redirection);
		}
		else
		{
			echo '<p><img src='.$_SESSION['fic_image'].' />';
			?>
			<label for="code">Recopier les caractères de l'image</label>
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
	<p><a href="sas.php">retour à l'accueil</a></p>




