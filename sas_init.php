<?php 
include('./fonctions/session_start.php');
include('./fonctions/fonctions_account.php');
include('./fonctions/connexion_bdd.php');
supprFichiersCaptcha();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
	$relatif=null;
	if (basename(realpath('.')) == 'gbaf')
	{
		$relatif="./";
	}
	else
	{
		$relatif="./../";
	}
	?>
	<link rel='stylesheet' type='text/css' href=<?php echo $relatif.'gbafstyle.css>';?>
	<link rel='stylesheet' type='text/css' href=<?php echo $relatif.'responsive.css>';?>

	<link rel='icon' href=<?php echo $relatif.'/logos/favicon.ico />';?>
	<title>GBAF</title>
</head>
<body>
<header class="header">

	<div class="row logo">
		<div class="col-3"></div>
		<div class="col-9">
			
				<?php
				echo '<div class="logolink"><a href=# >&emsp;&emsp;&emsp;&emsp;</a></div>';
				?>
			
		</div>
	</div>
	<div class="row right_sidebar">
		<div class="col-9" style="position: relative;">
		</div>
	</div>
</header>

<main class="main">
<div class="row top_main">
		<div class="col--3"></div>
		<div class="col--18 main_content white" >
			<div class="row ">
				<div class="col-12">
					<div class="col-3"></div>
					<div class="frm_left col-6 frm radius">
					<form action="./account/connexion.php" method="post">
					<!--<h5>Connexion </h5>-->
					<label for="pseudooumail"> Username ou email *  </label><input type="text" name="pseudooumail" id="pseudooumail"/><br />
					<label for="pass"> Mot de passe *  </label><input type="password" name="pass" id="pass"/><br />

					<?php
					if (!isset($_SESSION['captcha']))
					{
						$nb_caracteres = mt_rand(2,4);
						$captcha = createCaptcha($nb_caracteres);
						$_SESSION['captcha'] = $captcha; 
						$redirection = './sas.php';
						createImageCaptcha($captcha,$redirection);
					}
					else
					{
						echo '<img src='.$_SESSION['chemin_vers_fic_image'].$_SESSION['fic_image'].' /><br />';
					?>
					<label for="code">Recopier les caractères</label><br />
					<input type="text" name="code" id="code" /><br />	<?php
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
					<label for="auto">Connexion automatique</label>
					<input type="checkbox" name="auto" id="auto" /><br /><br />
					<input type="submit" value="Envoyer">	
					</form>
					</div>
					<div class="col-3 radius"></div>
					</div>
				</div>
			</div>	
</main>

<div class="liens">
		<div class="marge_gauche_liens"></div>
		<div class="contenu_liens">
			<p><a href="./account/mdp_oubli.php">Mot de passe oublié</a>&emsp;
			<a href="sas.php?nouveaumembre=1">Inscription</a></p>
		</div>
		<div classe="marge_droite_liens"></div>
</div>
<?php
include('./templates/footer.php');
?>

