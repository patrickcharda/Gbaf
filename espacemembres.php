<?php 
include('./fonctions/session_start.php');
include('./fonctions/connexion_bdd.php');
include('./fonctions/fonctions_account.php');
include('./templates/header.php');
supprFichiersCaptcha();
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

<div class="presentation_gbaf">
	<?php
	if (isset($bdd))
	{
		$req = $bdd->prepare('SELECT presentation FROM identite WHERE id= :id') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
				'id'=>1
			));
		$presentation = $req->fetch();
		echo '<p id="idprez">'.$presentation['presentation'].'</p>';
		$req->closeCursor();
	}
	?>
</div>
<div class="bandeau">
</div>

<main>
			<div class="col-deco-gauche"></div>
			<div class="col-gouttiere-gauche"></div>
			<div class="col-contenu" >
				<div class="frm radius">
			<?php
			if (isset($bdd))
			{
				$donnees = $bdd->query('SELECT id, acteur, SUBSTR(description,1,110) as description_courte, logo FROM acteurs ORDER BY acteur ASC') or die(print_r($bdd->errorInfo()));	
				if (!is_null($donnees))
				{
					while ($ligne = $donnees->fetch())
					{
						?>
						<div class="container">
							<div class="logo_acteur200x100">
						<?php
						echo '<img src=logos/'.$ligne['logo'].'200x100.png />';
						?>	
							</div>
							<div class="logo_acteur100x50">
						<?php
						echo '<img src=logos/'.$ligne['logo'].'100x50.png />';
						?>	
							</div>
							<div class="resume_acteur">
						<?php
						echo '<h3>'.($ligne['acteur']).'</h3><p>';
						$description = $ligne['description_courte'];
						/*$description= utf8_decode(html_entity_decode($ligne['description'], ENT_QUOTES, 'utf-8'));
						$nb_de_mots_description=str_word_count($description);
						$tableau_de_mots=str_word_count($description,1);
						//print_r($tableau_de_mots);
						$resume=null;
						for ($i=0;$i<$nb_de_mots_description and $i<20;$i++)
						{
							$resume .= $tableau_de_mots[$i].' ';
						}
						//echo $resume;*/
						echo $description;
						echo '<a href=./posts_votes/details.php?acteur='.$ligne['id'].' class="reda">&emsp;...</a></p>';
						?>
							</div>
							<div class="liresuite">
						<form method="get" action="./posts_votes/details.php" >
						<?php 
						echo'<input type="hidden" name="acteur" value='.$ligne['id'].' /><button type="submit" id="readmore">Lire la suite</button></form><br />';
						?>
							</div>
						</div>
						<?php					
				}
			}
		}
	?>			</div>
			</div>
			<div class="col-gouttiere-droite"></div>
			<div class="col-deco-droite"></div>
</main>

<p><a href="./fonctions/connexion.php?deconnexion=1" style="text-decoration:none;">&emsp;</a></p>

<?php
include('./templates/footer.php');
?>