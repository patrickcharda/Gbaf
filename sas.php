<?php 
include('./fonctions/session_start.php');
include('./templates/header.php');
include('./fonctions/fonctions_account.php');
include('./fonctions/connexion_bdd.php');
supprFichiersCaptcha();

//si l'utilisateur est loggé on le transfère vers l'espace membres
if (ok_login())
{
	header('Location:./espacemembres.php');
}

//si l'utilisateur est déjà membre et qu'il est en connexion automatique (cookies), redirection à l'espace membres via la page connexion.php 
if (isset($_COOKIE['pseudooumail']) AND $_COOKIE['pseudooumail']!='' AND isset($_COOKIE['pass']) AND $_COOKIE['pass']!='')
{
	header('Location:./account/connexion.php');
}
?>


<!--
#si le visiteur l'a demandé on affiche le formulaire d'inscription
-->
<div class="alerte">

<?php
if (isset($_GET['nouveaumembre']) && strlen($_GET['nouveaumembre'])<60)
{
	if (isset($_GET['verif']) && strlen($_GET['verif'])<60)
	{
		//echo $_GET['verif'];
		$alerte='';
		global $alerte;
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
	}
?>
</div>

<main class="main">
	<div class="row top_main">
		<div class="col--3"></div>
		<div class="col--18 main_content" >
			<div class="row">
				<div class="col-3"></div>
				<div class="frm_left col-6 frm radius">
					<form action="./account/inscription.php" method="post">
					<?php echo '<div style="text-align:left; font-weight:bold; padding:5px;">'.$alerte.'</div>';
					unset($alerte); ?>
					<h5>Formulaire d'inscription </h5>
					<p>
					<label for="pseudooumail"> Nom d'utilisateur * : </label><input type="text" name="pseudooumail" id="pseudooumail" maxlength="20" title="Le nom d'utilisateur correspond au pseudo, ou au username. Maximum 20 caractères alphanumériques." <?php
					if (isset($_SESSION['form_fields']['username']))
					{
						echo 'value='.htmlspecialchars($_SESSION['form_fields']['username']).' ';
					}
					?>/>
					</p>
					<p>
					<label for="nom"> Nom * : </label><input type="text" name="nom" id="nom" maxlength="25" <?php
					if (isset($_SESSION['form_fields']['nom']))
					{
						echo 'value='.htmlspecialchars($_SESSION['form_fields']['nom']).' ';
					}
					?>/>
					</p>
					<p>
					<label for="prenom"> Prénom * : </label><input type="text" name="prenom" id="prenom" maxlength="25" <?php
					if (isset($_SESSION['form_fields']['prenom']))
					{
						echo 'value='.htmlspecialchars($_SESSION['form_fields']['prenom']).' ';
					}
					?>/>
					</p>		
					<p>
					<label for="pass"> Mot de passe * : </label><input type="password" name="pass" id="pass" maxlength="10" minlength="6" />
					</p>
					<p>
					<label for="mail"> Email * : </label><input type="text" name="mail" id="mail" maxlength="30" <?php
					if (isset($_SESSION['form_fields']['mail']))
					{
						echo 'value='.htmlspecialchars($_SESSION['form_fields']['mail']).' ';
					}
					?>/>
					</p>

					<p>
					<label for="question"> Question * : </label><input type="text" name="question" id="question" maxlength="30" <?php
					if (isset($_SESSION['form_fields']['question']))
					{
						echo 'value='.htmlspecialchars($_SESSION['form_fields']['question']).' ';
					}
					?>/>
					</p>
					<p>
					<label for="reponse"> Réponse * : </label><input type="text" name="reponse" id="reponse" maxlength="30" <?php
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

					<!--<label for="auto">Connexion automatique</label>
					<input type="checkbox" name="auto" id="auto" /><br />--><br />
					<input type="submit" value="Envoyer">
					</form>				
				</div>
				<div class="col-3"></div>
			</div>
		</div>
		<div class="col--3"></div>
	</div>	
</main>
<div class="liens">
		<div class="marge_gauche_liens"></div>
		<div class="contenu_liens">
			
		</div>
		<div classe="marge_droite_liens"></div>
</div>
<?php

}                		
					//FORMULAIRE DE CONNEXION
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
					<input type="submit" value="Connexion">	
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
	
}
include('./templates/footer.php');
?>

