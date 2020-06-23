<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--<link rel="stylesheet" type="text/css" href="./gbafstyle.css">-->
	<link rel="icon" href="./logos/favicon.ico" />
	<title>GBAF</title>
</head>
<body>
<header>
	<?php
	$relatif=null;
	if (basename(realpath('.')) == 'gbaf')
	{
		$relatif="./";
	}
	else
	{
		$relatif="./../";
	}

	echo '<a href='.$relatif.'index.php ><img src='.$relatif.'logos/logo75x100.png alt=logo GBAF /></a>';
	?>
</header>
<hr />