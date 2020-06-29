<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
supprFichiersCaptcha(); 
include('./../templates/header.php');

echo 'admin page';
?>

<form action="add_acteur.php" method="post">
		<h5>Nouvel acteur</h5>
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
			echo '<p><img src='.$_SESSION['chemin_vers_fic_image'].$_SESSION['fic_image'].' />';
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
	<p><a href="./../account/connexion.php?deconnexion=1">retour à l'accueil</a></p>
	<?php
	include('./../templates/footer.php');
	?>

<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
