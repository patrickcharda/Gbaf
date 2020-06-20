<?php

//print_r($_SESSION);
/*
echo realpath('try.php');
echo date("Y-m-d H:i:s");
echo '<p>';
$varchaine="du texte";
echo $varchaine.'<br />';
echo '$varchaine guillemets simples<br />';
echo "$varchaine guillements doubles";
*/
function servir_cafe($types = array("cappuccino"), $coffeeMaker = NULL)
{
    $device = is_null($coffeeMaker) ? "les mains" : $coffeeMaker;
    return "Préparation d'une tasse de ".join(", ", $types)." avec $device.\n";
}
echo servir_cafe();
echo servir_cafe(array("cappuccino", "lavazza"), "une cafetière");
?>


?>



