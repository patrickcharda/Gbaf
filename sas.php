<?php 
include('session_start.php');
include('header.php');
include('fonctions_account.php');
include('connexion_bdd.php');
supprFichiersCaptcha();


//si l'utilisateur est déjà membre et qu'il est en connexion automatique (cookies), redirection à l'espace membre
if (isset($_COOKIE['pseudooumail']) AND $_COOKIE['pseudooumail']!='' AND isset($_COOKIE['pass']) AND $_COOKIE['pass']!='')
{
	header('Location:connexion.php');
}
?>


<!--
#si le visiteur l'a demandé on affiche le formulaire d'inscription
-->


<?php
if (isset($_GET['nouveaumembre']))
{
	if (isset($_GET['verif']))
	{
		//echo $_GET['verif'];
		$alerte='';
		if (preg_match('#motdepasse#', $_GET['verif']))
		{
			$alerte.='- mot de passe à vérifier<br />';
		}
		if (preg_match('#mail#', $_GET['verif']))
		{
			$alerte.='- mail à vérifier<br />';
		}
		if (preg_match('#pseudo#', $_GET['verif']))
		{
			$alerte.='- username à vérifier<br />';
		}
		if (preg_match('#nom#', $_GET['verif']))
		{
			$alerte.='- nom à vérifier<br />';
		}
		if (preg_match('#prenom#', $_GET['verif']))
		{
			$alerte.='- prénom à vérifier<br />';
		}
		if (preg_match('#question#', $_GET['verif']))
		{
			$alerte.='- question à vérifier<br />';
		}
		if (preg_match('#reponse#', $_GET['verif']))
		{
			$alerte.='- réponse à vérifier<br />';
		}
		if (preg_match('#code#', $_GET['verif']))
		{
			$alerte.='- captcha incorrect <br />';
		}
		if (preg_match('#1#', $_GET['verif']))
		{
			$alerte.='- username déjà pris <br />';
		}
		if (preg_match('#2#', $_GET['verif']))
		{
			$alerte.='- mail déjà pris <br />';
		}
		echo $alerte;
	}
?>
<div class="inscription">
	<div class="frm_inscription">
	<form action="inscription.php" method="post">
		<h5>Formulaire d'inscription </h5>
		<p>
			<label for="pseudooumail"> Nom d'utilisateur* : </label><input type="text" name="pseudooumail" id="pseudooumail" maxlength="20" title="Le nom d'utilisateur correspond au pseudo, ou au username. Maximum 20 caractères alphanumériques." <?php
			if (isset($_SESSION['form_fields']['username']))
			{
				echo 'value='.htmlspecialchars($_SESSION['form_fields']['username']).' ';
			}
			?>/>
		</p>
		<p>
			<label for="nom"> Nom* : </label><input type="text" name="nom" id="nom" maxlength="25" <?php
			if (isset($_SESSION['form_fields']['nom']))
			{
				echo 'value='.htmlspecialchars($_SESSION['form_fields']['nom']).' ';
			}
			?>/>
		</p>
			<p>
			<label for="prenom"> Prénom* : </label><input type="text" name="prenom" id="prenom" maxlength="25" <?php
			if (isset($_SESSION['form_fields']['prenom']))
			{
				echo 'value='.htmlspecialchars($_SESSION['form_fields']['prenom']).' ';
			}
			?>/>
		</p>		
		<p>
			<label for="pass"> Mot de passe* : </label><input type="password" name="pass" id="pass" maxlength="10" minlength="6" />
		</p>
		<p>
			<label for="mail"> Email* : </label><input type="text" name="mail" id="mail" maxlength="30" <?php
			if (isset($_SESSION['form_fields']['mail']))
			{
				echo 'value='.htmlspecialchars($_SESSION['form_fields']['mail']).' ';
			}
			?>/>
		</p>

		<p>
			<label for="question"> Question* : </label><input type="text" name="question" id="question" maxlength="30" <?php
			if (isset($_SESSION['form_fields']['question']))
			{
				echo 'value='.htmlspecialchars($_SESSION['form_fields']['question']).' ';
			}
			?>/>
		</p>
			<p>
			<label for="reponse"> Réponse* : </label><input type="text" name="reponse" id="reponse" maxlength="30" <?php
			if (isset($_SESSION['form_fields']['reponse']))
			{
				echo 'value='.htmlspecialchars($_SESSION['form_fields']['reponse']).' ';
			}
			?>/>
		</p>	

		<?php
		if (!isset($_SESSION['captcha']))
		{
			$nb_caracteres = mt_rand(2,4);
			$captcha = createCaptcha($nb_caracteres);
			$_SESSION['captcha'] = $captcha; 
			$verif=$_GET['verif'];
			$redirection = './sas.php?nouveaumembre=1&verif='.$verif;
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
		<label for="auto">Connexion automatique</label>
		<input type="checkbox" name="auto" id="auto" />
	</form>
	</div>
	<p><a href="sas.php">retour à l'accueil</a></p>
</div><!--div class inscription-->
<?php

}
else
{
	if (isset($_GET['insertuser']) OR isset($_SESSION['insert']))
	{
		echo 'Compte user créé';
	}
	if (isset($GLOBALS['fields']));
	{
		unset($GLOBALS['fields']);
	}


?>
<div class="connexion">
	<div class="frm_connexion">
	<form action="connexion.php" method="post">
	<!--<h5>Connexion </h5>-->
	<label for="pseudooumail"> Username ou email* : </label><input type="text" name="pseudooumail" id="pseudooumail"/><br />
	<label for="pass"> Mot de passe* : </label><input type="password" name="pass" id="pass"/><br />
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
			echo '<div id="captcha"><div id="img_captcha"><img src='.$_SESSION['fic_image'].' /></div>';
			?>
			
			<div id="input_code"><input type="text" name="code" id="code" /><div />
			</div>
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
		<label for="auto">Connexion automatique</label>
		<input type="checkbox" name="auto" id="auto" /><input type="submit" value="Envoyer">	
	</form>
	</div>
</div>	
<div class="liens">
<p><a href="mdp_oubli.php">Mot de passe oublié</a></p>
<p><a href="sas.php?nouveaumembre=1">S'inscrire</a></p>
</div>
<?php
	
}
include('footer.php');
?>

