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

<main class="main">
	<div class="top_main">
		<div class="row">
			<div class="col--3"></div>
			<div class="col--18 white">
				<div class="row">
					<div class="col-1"><span class="invisible">&emsp;</span></div>
					<div class="col-10 frm radius">
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
						echo '<h3>'.($ligne['acteur']).'</h3>';
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
						echo '<a href=./posts_votes/details.php?acteur='.$ligne['id'].' class="reda">&emsp;...</a>';
						?>
									</div>
									<div class="liresuite">
						<form method="get" action="./posts_votes/details.php" >
						<?php 
						echo'<input type="hidden" name="acteur" value='.$ligne['id'].' /><button type="submit" id="readmore">Lire la suite</button></form><br />';
								echo '</div>';
							echo '</div>';					
				}
			}
		}
	?>				</div>
					<div class="col-1"><span class="invisible">&emsp;</span></div>
				</div>
			</div>
			<div class="col--3"><span class="invisible">&emsp;</span></div>
		</div>
	</div>
</main>

<p><a href="./fonctions/connexion.php?deconnexion=1" style="text-decoration:none;">&emsp;</a></p>

<?php
include('./templates/footer.php');
?>