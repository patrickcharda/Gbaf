<?php
include('./session_start.php');
include('./fonctions_account.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" type="text/css" href="./canvas6.css"> -->
	<title>Login</title>
</head>
<body>
<?php

if (!isset($_SESSION['captcha']))
{
//$alphabet='0123456789aAbBcCdDeEfFgGhHjJkKmMnNpPqQrRsStTuUvVwWxXyYzZ';
$nb_caracteres = mt_rand(2,4);
$captcha = createCaptcha($nb_caracteres);
$_SESSION['captcha'] = $captcha; 
$redirection = './try2.php';
createImageCaptcha($captcha,$redirection);
}

else

{
	//echo $_SESSION['nom_fichier_image'];
	echo '<img src='.$_SESSION['fic_image'].' />';
	unset($_SESSION['captcha']);
	unset($_SESSION['fic_image']);
	//print_r($_SESSION);
}

?>
</body>
</html>



