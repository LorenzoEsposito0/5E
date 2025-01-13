<?php
$directoryPrincipale = getcwd();
echo "$directoryPrincipale";

Function ottieniPercorsiCartelle($directoryPrincipale)
{
    $cartella = scandir($directoryPrincipale);

    $dir = array_filter($cartella, function ($var) use ($directoryPrincipale) {
        return is_dir($directoryPrincipale . DIRECTORY_SEPARATOR . $var) && $var != "." && $var != "..";
    });

    // rimuoviamo indici non numerici
    $dir = array_values($dir);
    //array_slice ritorna le prime 3 directory
    return array_slice($dir, 0, 3);
}

$directoryTrovate = ottieniPercorsiCartelle($directoryPrincipale);
$percorso1 = $directoryPrincipale . DIRECTORY_SEPARATOR . $directoryTrovate[0];
$percorso2 = $directoryPrincipale . DIRECTORY_SEPARATOR . $directoryTrovate[1];
$percorso3 = $directoryPrincipale . DIRECTORY_SEPARATOR . $directoryTrovate[2];


echo "<br>";
echo "1:  $percorso1";
echo "<br>";
echo "2: $percorso2 ";
echo "<br>";
echo "3. $percorso3";
?>