<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./gbafstyle.css">
	<link rel="icon" href="./logos/favicon.ico" />
	<title>GBAF</title>
</head>
<body>
<header class="header">
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
	?>
	<div class="row logo">
		<div class="col-3"></div>
		<div class="col-9">
			
				<?php
				echo '<a href='.$relatif.'index.php ><img src='.$relatif.'logos/logo75x100.png alt=logo GBAF /></a>';
				?>
			
		</div>
	</div>
	<div class="row right_sidebar">
		<div class="col-9"><p>déconnecter</p><p>compte</p></div>
	</div>
</header>


