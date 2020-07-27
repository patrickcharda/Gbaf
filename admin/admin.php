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

?>

<form action="add_acteur.php" method="post">
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
		<label for="logo"> Nom du fichier logo (png)* : </label><input type="text" name="logo" id="logo" />
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


<?php
/*
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
*/
?>

