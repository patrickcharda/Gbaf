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

	<div class="row logo">
		<div class="col-3">
							<?php
				echo '<div class="logolink"><a href='.$relatif.'index.php >&emsp;&emsp;&emsp;&emsp;</a></div>';
				?>
		</div>
		<div class="col-9">
			
				<?php /*
				echo '<div class="logolink"><a href='.$relatif.'index.php >&emsp;&emsp;&emsp;&emsp;</a></div>'; */
				?>
			
		</div>
	</div>
	<div class="row right_sidebar">
		<div class="col-9" style="position: relative;">
			<?php /*
				if (isset($_SESSION['login']) && !is_null($_SESSION['login']))
				{
					echo '<div class="logoutlink"><a href='.$relatif.'account/connexion.php?deconnexion=1>&emsp;&emsp;&emsp;&emsp;</a></div>';
					echo '<div class="accountlink"><a href='.$relatif.'account/mon_compte.php >&emsp;&emsp;&emsp;&emsp;</a></div>';

				}
					*/
				?>
		</div>

		<div class="col-3">

						<?php
				if (isset($_SESSION['login']) && !is_null($_SESSION['login']))
				{
					echo '<div class="logoutlink"><a href='.$relatif.'account/connexion.php?deconnexion=1>&emsp;&emsp;&emsp;&emsp;</a></div>';
					echo '<div class="accountlink"><a href='.$relatif.'account/mon_compte.php >&emsp;&emsp;&emsp;&emsp;</a></div>';

				}

				?>

		</div>

	</div>
</header>


