<?php
include('session_start.php');
include('connexion_bdd.php');
define('ALPHABET', '0123456789aAbBcCdDeEfFgGhHjJkKmMnNpPqQrRsStTuUvVwWxXyYzZ');

function createCaptcha($nb_caracteres)
{
	$chaine = '';
  	for ($i = 0; $i < $nb_caracteres; $i++)
    {
    	$chaine .= ALPHABET[mt_rand(0, strlen(ALPHABET)-1)];
    }
    $_SESSION['captcha'] = $chaine; 
  	return $chaine;
}

function createComplexeString($nb_caracteres)
{
	$chaine = '';
  	for ($i = 0; $i < $nb_caracteres; $i++)
    {
    	$chaine .= ALPHABET[mt_rand(0, strlen(ALPHABET)-1)];
    } 
  	return $chaine;
}


function createImageCaptcha($captcha,$redirection)
{
	header ("Content-type: image/png");
	$image = imagecreate(90,90) or die("Impossible d'initialiser la bibliothèque GD");
	$noir = imagecolorallocate($image, 20, 20, 20);
	$blanc = imagecolorallocate($image, 255, 255, 255);
	$nb_caracteres = mt_rand(2,4);
	$_SESSION['fic_image'] = './images/'.createComplexeString(15).'.png';
	imagestring($image, 9, 30, 30, $captcha, $blanc);
	if (is_writable('./images'))
	{
		imagepng($image,$_SESSION['fic_image']);
		header('Location:'.$redirection);
	}
	else
	{
		if (chmod("./images", 0700))
			{
				imagepng($image,$_SESSION['fic_image']);
				header('Location:'.$redirection);
			}
	}
}


function supprFichiersCaptcha()
{
	//unlink($_SESSION['fic_image']);
	include('connexion_bdd.php');
	$reponse = $bdd->query('SELECT count(*) FROM imagefiles') or die(print_r($bdd->errorInfo()));
	$donnees = $reponse->fetch();
	//echo $donnees['count(*)'];
	$nombre_de_fichiers= $donnees['count(*)'];
	$reponse->closeCursor();
	$nb_de_fic_supprimes=0;
	$nb_entrees_supprimes=0;
	if ($nombre_de_fichiers > 3) //on laisse 3 fichiers imagecaptcha seulement sur le serveur, pas plus
	{
		$reponse = $bdd->query('SELECT id,image_file FROM imagefiles ORDER BY id') or die(print_r($bdd->errorInfo()));
		$ids_a_supprimer=array(); //pr les entrees table à suppr
		$imagefiles_to_delete=array(); //pr les fichiers physiques à suppr
		while ($data = $reponse->fetch()) 
		{
			if ($nombre_de_fichiers >3)
			{
				$ids_a_supprimer[]=$data['id'];
				$imagefiles_a_supprimer[]=$data['image_file'];
				$nombre_de_fichiers--;
			}
		}
		$reponse->closeCursor();
	}
		if (isset($imagefiles_a_supprimer))
		{
			foreach ($imagefiles_a_supprimer as $element) //supprimer les fichiers physiques
			{
			unlink($element);	
			}
			unset($imagefiles_a_supprimer);
		}
		if (isset($ids_a_supprimer))
		{
			foreach ($ids_a_supprimer as $element) //supprimer les entrees ds la table
			{
				$reponse = $bdd->query("DELETE FROM imagefiles WHERE id=$element") or die(print_r($bdd->errorInfo()));
				$reponse->closeCursor();
			}
			unset($ids_a_supprimer);
		}
}

function save_form_field($field_name,$field_content)
{
	$GLOBALS['fields'][$field_name]=$field_content;
	$_SESSION['form_fields']=$GLOBALS['fields'];
}




