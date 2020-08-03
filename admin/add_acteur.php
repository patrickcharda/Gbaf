<?php
include('./../fonctions/session_start.php');
include('./../fonctions/connexion_bdd.php');
include('./../fonctions/fonctions_account.php');

$message=null;
if (!isset($_SESSION['groupe']) AND isset($_SESSION['login']) AND $_SESSION['groupe']==2)
{
        $message=0;
        header('Location:admin.php?message='.$message);
}

else if (isset($bdd))
{
	if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
	{
        // Testons si le fichier n'est pas trop gros
                if ($_FILES['monfichier']['size'] <= 1000000)
                {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['monfichier']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('png');
                        $check = getimagesize($_FILES["monfichier"]["tmp_name"]);
                        if ($check !== false)
                        {
                	       if (in_array($extension_upload, $extensions_autorisees))
                	       {
                		      //$_SESSION['myfile']= $_FILES['monfichier']['name'];
                		      $_FILES['monfichier']['name']=strtolower(htmlspecialchars($_POST['acteur']).'.png');
                		      $_FILES['monfichier']['name']=preg_replace("# #", "", $_FILES['monfichier']['name']);
                                        // On peut valider le fichier et le stocker définitivement
                                        move_uploaded_file($_FILES['monfichier']['tmp_name'], './../logos/' . basename($_FILES['monfichier']['name']));
                        
                                        // créer les logos en 200x100 et 100x50

                                        /*200x100*/

                                        $filename = './../logos/'.basename($_FILES['monfichier']['name']);
                                        // Calcul des nouvelles dimensions
					list($width, $height) = getimagesize($filename);
					$new_width = 200;
					$new_height = 100;
					$logo_medium = imagecreatetruecolor($new_width, $new_height);
					$logo_original = imagecreatefrompng($filename);
					imagecopyresampled($logo_medium, $logo_original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$newfilename='./../logos/' .preg_replace("# #", "",strtolower(htmlspecialchars($_POST['acteur']).'200x100.png'));
					imagepng($logo_medium,$newfilename);
                	
                		      /*100x50*/

                		      $filename = './../logos/'.basename($_FILES['monfichier']['name']);
                                        // Calcul des nouvelles dimensions
					list($width, $height) = getimagesize($filename);
					$new_width = 100;
					$new_height = 50;
					$logo_medium = imagecreatetruecolor($new_width, $new_height);
					$logo_original = imagecreatefrompng($filename);
					imagecopyresampled($logo_medium, $logo_original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$newfilename='./../logos/' .preg_replace("# #", "",strtolower(htmlspecialchars($_POST['acteur']).'100x50.png'));
					imagepng($logo_medium,$newfilename);
					$message=1;

                	       }
                	       else
                	       {
                		      $message=2;
                		      header('Location:admin.php?message='.$message);
                	       }
                        }
                        else
                        {
                	       $message=2;
                	       header('Location:admin.php?message='.$message);
                        }
                }
                else
                {
        	       $message=3;
        	       header('Location:admin.php?message='.$message);
                }
	}
	else
	{
		$message=4;
		header('Location:admin.php?message='.$message);
	}
	$req = $bdd->prepare('INSERT INTO acteurs(acteur,description,logo) VALUES(:acteur, :description, :logo)') or die(print_r($bdd->errorInfo()));
	$req->execute(array(
					'acteur'=>htmlspecialchars($_POST['acteur']),
					'description'=>htmlspecialchars($_POST['description']),
					'logo'=>preg_replace("# #", "",strtolower(htmlspecialchars($_POST['acteur'])))
				));	
	$req->closeCursor();
	$message.=5;
	header('Location:admin.php?message='.$message);
}
else
{
	$message=6;
	header('Location:admin.php?message='.$message);
}
?>

