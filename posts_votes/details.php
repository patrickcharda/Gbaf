<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');
include('./../fonctions/fonctions_posts_votes.php');
include('./../templates/header.php');
/*
afficher le détail d'un acteur
*/


if (ok_login())
{
}
else
{
	header('Location:../account/connexion.php?deconnexion=1'); //on déconnecte cet intrus!
}

if (isset($_GET['acteur']))
{
	$id= (int)($_GET['acteur']); //on verifie que l'argument passé en url est un chiffre...
	if ($id>0 && $id<1000)
	{
		$_SESSION['id_acteur']=$id;
	}
	else
	{
		header('Location:./../espacemembres.php');
	}

}
if (isset($_SESSION['id_acteur']))
{
	if (isset($bdd))
	{
		//on vérifie que l'id existe
		$reponse = $bdd->query('SELECT count(*) FROM acteurs WHERE id='.$id.'') or die(print_r($bdd->errorInfo()));
		$data = $reponse->fetch();
		if ($data['count(*)'] == 0) //l'id n'existe pas, on renvoit sur l'espace membres
		{
			$reponse->closeCursor();
			header('Location:./../espacemembres.php'); 
		}
		$reponse->closeCursor();

		$reponse = $bdd->query('SELECT id, acteur, description, logo FROM acteurs WHERE id='.$id.'') or die(print_r($bdd->errorInfo()));	
		if (!is_null($reponse))
		{
			while ($data = $reponse->fetch())
			{
				echo '<p><img src=./../logos/'.$data['logo'].'.png /></p>';
				echo '<p><h3>'.$data['acteur'].'</h3></p>';
				echo '<p>'.nl2br(htmlspecialchars($data['description'])).'</p>';
			}			
			$reponse->closeCursor();
		}
		$nb_posts=nombre_de('posts','id_acteur',$id);
		$nb_votes=nombre_de('votes','id_acteur',$id);
		$info_likes = infos_likes($id);
		$lienUp=null;
		$lienDown=null;
		$lienReset=null;
		if ($info_likes['deja_vote'])
		{
			echo '<p>a voté :';
			$_SESSION['id_vote']=$info_likes['id_vote'];
			if ($info_likes['vote_content']) //vote égal 1
			{
				$lienUp='<a href=\'change_vote.php?vote=1\'><strong> like </strong></a>';
				$lienDown='<a href=\'change_vote.php?vote=0\'> dislike </a>';
				$lienReset='<a href=\'change_vote.php?vote=2\'> reset </a>';
			}
			else
			{
				$lienUp='<a href=\'change_vote.php?vote=1\'> like </a>';
				$lienDown='<a href=\'change_vote.php?vote=0\'><strong> dislike </strong></a>';
				$lienReset='<a href=\'change_vote.php?vote=2\'> reset </a>';
			}
			echo '</p>';
		}
		else
		{
			$lienUp='<a href=\'change_vote.php?vote=3\'> like </a>';
			$lienDown='<a href=\'change_vote.php?vote=4\'> dislike </a>';
		}
		
		echo '<p><a href=#>actualiser ou ajouter un commentaire</a></p>';
		$infos_user_comment=null;
		if (!is_null($nb_posts)) 
		{

			//echo '<p>'.$nb_posts.' commentaire(s) <br/>'.$nb_votes.' vote(s) <br/>'.$info_likes['positifs'].' '.$lienUp.' - '.$lienReset.' - '.$info_likes['negatifs'].' '.$lienDown.'</p>';
			echo '<p>'.$nb_posts.' commentaire(s) <br/>'.$nb_votes.' vote(s) <br/>'.$lienUp.' - '.$lienReset.' - '.$lienDown.'</p>';

			//afficher tous les commentaires et infos associées pour l'acteur choisi
			if ($nb_posts > 0)
			{
				$reponse = $bdd->query('SELECT p.id p_id, p.post p_post, a.id a_id,a.prenom a_prenom, a.nom a_nom, DATE_FORMAT(p.date_add,\'%d/%m/%Y\') date_ajout FROM posts p INNER JOIN account a ON a.id=p.id_account WHERE p.id_acteur='.$id.'') or die(print_r($bdd->errorInfo()));
				while ($data = $reponse->fetch())
				{
					if ($data['a_id'] == $_SESSION['id'])
					{
						$_SESSION['post_id']=$data['p_id'];
						$infos_user_comment['post_id']=$data['p_id'];
						$infos_user_comment['post_content']=$data['p_post'];
					}

					echo '<p>'.$data['a_prenom'].' '.$data['a_nom'].' '.$data['date_ajout'].'</p>';
					echo '<p>'.$data['p_post'].'</p>';
				}
				$reponse->closeCursor();
			}
		}
		if (!is_null($infos_user_comment))
		{
			echo '<form action="update_commentaire.php" method="post">';
			echo '<p><label for="comment">Actualiser</label><br />';
		}
		else
		{
			echo '<form action="valide_commentaire.php" method="post">';
			echo '<p><label for="comment">Ajouter</label><br />';
		}

		//ajout ou modif d'un champ de commentaire si possible (par encore fait par ce user pour cet acteur)
		?>

			<textarea name="comment" id="comment" rows="4" cols="50" maxlength="500">
				<?php
				if (!is_null($infos_user_comment))
				{
					echo $infos_user_comment['post_content'];
				}
				?>

			</textarea></p>
			<input type="submit" value="Envoyer">
		</form>
		<?php
	}
	else
	{
		header('Location:../espacemembres.php');
	}
}
include('./../templates/footer.php');
?>



