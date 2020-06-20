<?php
include('session_start.php');
include('connexion_bdd.php');
include('fonctions_account.php');
supprFichiersCaptcha(); 

echo 'admin page';
?>

<form action="add_acteur.php" method="post">
		<h5>Nouvel acteur</h5>
		<p>
			<label for="acteur"> Nom de l'acteur* : </label><input type="text" name="acteur" id="acteur" />
		</p>
		<p>
			<label for="description"> Présentation* : </label>
			<textarea name="description" id="description" maxlength="2500" >
			Présentation de l'acteur
			</textarea>
		</p>
		<p>
			<label for="logo"> Nom du fichier logo (png)* : </label><input type="text" name="logo" id="logo" />
		</p>		
		<?php
		if (!isset($_SESSION['captcha']))
		{
			$nb_caracteres = mt_rand(2,4);
			$captcha = createCaptcha($nb_caracteres);
			$_SESSION['captcha'] = $captcha; 
			$verif=$_GET['verif'];
			$redirection = './admin.php';
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
	<p><a href="connexion.php?deconnexion=1">retour à l'accueil</a></p>

