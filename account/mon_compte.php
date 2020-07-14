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
				<p align=left"><strong>
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
				<p align="left">
					<?php
					echo '<em><strong>Login : </strong></em>'.$_SESSION['login'].'<br />';
					echo '<em><strong>Prénom : </strong></em>'.$_SESSION['prenom'].'<br />';
					echo '<em><strong>Nom : </strong></em>'.$_SESSION['nom'].'<br />';
					echo '<em><strong>Mail : </strong></em>'.$_SESSION['mail'].'<br />';
					?>
				</p>
				<p align="left"> Vous pouvez utiliser le formulaire ci-dessous pour changer votre "question-réponse" ( employée pour la vérification en cas de <em><strong><a href="mdp_oubli.php" style="color:white;text-decoration: none;">mot de passe oublié</a></em></strong> )</p>
				<p>
				<label for="question"><em><strong> Question* : </strong></em></label><input type="text" name="question" id="question" maxlength="30" />
				</p>
				<p>
				<label for="reponse"><em><strong> Réponse* : </strong></em></label><input type="text" name="reponse" id="reponse" maxlength="30" />
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