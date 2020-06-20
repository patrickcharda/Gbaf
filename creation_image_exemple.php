<?php
include('random.php');
header ("Content-type: image/png");
$image = imagecreate(150,150);

$orange = imagecolorallocate($image, 255, 128, 0);
$blanc = imagecolorallocate($image, 255, 255, 255);
$bleu = imagecolorallocate($image, 0, 0, 255);
$bleuclair = imagecolorallocate($image, 156, 227, 254);
$noir = imagecolorallocate($image, 0, 0, 0);

/*
$points= array(10,5,15,10,5,10);
ImagePolygon($image, $points, 3, $blanc);

for ($i=0;$i<50;$i++)
	{
		ImageSetPixel($image, 100, $i, $noir);
	}
*/


//$alphabet='0123456789aAbBcCdDeEfFgGhHjJkKmMnNpPqQrRsStTuUvVwWxXyYzZ';
$nb_caracteres = mt_rand(2,4);
$captcha = createCaptcha($nb_caracteres);

//$captch_all = $captcha;

imagestring($image, 9, 35, 15, $captcha, $blanc);
/*
$nb_caracteres = mt_rand(2,2);
$captcha = genereChaineAleatoire($nb_caracteres, $alphabet);

$captch_all .= $captcha;

imagestring($image, mt_rand(8,9), 75, 75, $captcha, $blanc);
*/


//imagecolortransparent($image,$bleuclair);

if (is_writable('.'))
{
	imagepng($image,"./mon.png");
	header('Location:espacemembres.php');
}
else
{
	if (chmod(".", 0700))
		{
			imagepng($image,"./mon.png");
			header('Location:espacemembres.php');
		}
}
?>

