<?php 
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
include('./../templates/header.php');
//supprFichiersCaptcha();
//verifier que session ouverte
if (ok_login())
{
}
else
{
	header('Location:./account/connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}


?>


<!-- afficher ici le bandeau de présentation de GBAF -->

<main class="main">
	<div class="top_main">
		<div class="row">
			<div class="col--3"></div>
			<div class="col--18 white">
				<div class="row">
					<div class="col-1"><span class="invisible">&emsp;</span></div>
					<div class="col-10 frm radius">	
			<form action="modif_qr.php" method="post">
				<p align="left">
					<strong>
					<?php
					if (isset($_GET['verif']))
					{
						switch ($_GET['verif'])
						{
							case 00:
							echo 'formulaire incomplet';
							break;
							case 11:
							echo 'mise à jour effectuée';
							break;
							case 22:
							echo 'problème de connexion à la base de données';
							break;
						}
					}
					?>
					</strong>
				</p>

					<p>
					<label for="pseudooumail"> Nom d'utilisateur * : </label><input type="text" name="pseudooumail" id="pseudooumail" maxlength="20" title="Le nom d'utilisateur correspond au pseudo, ou au username. Maximum 20 caractères alphanumériques." <?php
					if (isset($_SESSION['login']))
					{
						echo 'value="'.htmlspecialchars($_SESSION['login']).'"';
					}
					?>
					>
					</p>
					<p>
					<label for="nom"> Nom * : </label><input type="text" name="nom" id="nom" maxlength="25" <?php
					if (isset($_SESSION['nom']))
					{
						echo 'value="'.htmlspecialchars($_SESSION['nom']).'"';
					}
					?> 
					>
					</p>
					<p>
					<label for="prenom"> Prénom * : </label><input type="text" name="prenom" id="prenom" maxlength="25" <?php
					if (isset($_SESSION['prenom']))
					{
						echo 'value="'.htmlspecialchars($_SESSION['prenom']).'"';
					}
					?> 
					>
					</p>		
					<p>
					<label for="pass"> Mot de passe * : </label><input type="password" name="pass" id="pass" maxlength="10" minlength="6" />
					</p>
					<p>
					<label for="question"> Question * : </label><input type="text" name="question" id="question" maxlength="30" <?php
					if (isset($_SESSION['question']))
					{
						echo 'value="'.$_SESSION['question'].'"';
					}
					?>
					>
					</p>
					<p>
					<label for="reponse"> Réponse * : </label><input type="text" name="reponse" id="reponse" maxlength="30" <?php
					if (isset($_SESSION['reponse']))
					{
						echo 'value="'.htmlspecialchars($_SESSION['reponse']).'"';
					}
					?>
					>
					</p>
				<input type="submit" value="Enregistrer" />
			</form>

					</div>
					<div class="col-1"><span class="invisible">&emsp;</span></div>
				</div>
			</div>
			<div class="col--3"><span class="invisible">&emsp;</span></div>
		</div>
	</div>
</main>

<p><a href="./../fonctions/connexion.php?deconnexion=1" style="text-decoration:none;">&emsp;</a></p>

<?php
include('./../templates/footer.php');
?>