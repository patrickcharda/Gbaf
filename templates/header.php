<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<link rel='stylesheet' type='text/css' href=<?php echo $relatif.'gbafstyle.css>';?>
	<link rel='stylesheet' type='text/css' href=<?php echo $relatif.'responsive.css>';?>

	<link rel='icon' href=<?php echo $relatif.'/logos/favicon.ico />';?>
	<title>GBAF</title>
</head>
<body>
<header class="header">

	<div class="logo">
							<?php
				echo '<div class="logolink"><a href='.$relatif.'index.php >&emsp;&emsp;&emsp;&emsp;</a></div>';
				?>
	</div>

	<div class="right_sidebar">
		
				<?php
				if (isset($_SESSION['login']) && !is_null($_SESSION['login']))
				{
				?>
				<div class="wrap_logout" align="right">
					<div class="logoutlink">
						<a href=<?php echo $relatif.'account/connexion.php?deconnexion=1';?>>
						&emsp;&emsp;&emsp;&emsp;</a>
					</div>
				</div>

				<div class="haut_droit">
						<div class="accountname">
							<?php echo $_SESSION['nom'].'&nbsp'.$_SESSION['prenom'];?>
						</div>
						<div class="accountlink">
							<a href=<?php echo $relatif.'account/mon_compte.php';?>>
							&emsp;&emsp;&emsp;&emsp;</a>
						</div>
				</div>
				<?php
				}
				?>
	</div>
</header>


