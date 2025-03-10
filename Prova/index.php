<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post" action="">
    <label for="data">GENERA DATA</label><br><br>
    <button type="submit" name="inserisci">Inserisci</button>
</form>
<form action="actionPage.php" method="post">
    <br>
    <button type="submit">Aggiorna</button>
</form>
</body>
</html>
<?php
$config = require 'conf.php';
require_once ("DbConfig.php");
$db = DbConfig::getDB($config);

// questa funzione genera date casuali che vanno dal primo gennaio 2001 fino al 31 dicembre del 2030
function generaDataCasuale()
{
    $timestampCasuale = rand(strtotime("2000-01-01"), strtotime("2030-12-31")); // Cambia il range come vuoi
    // ritorna la data nel formato scelto da noi
    return date("Y-m-d", $timestampCasuale);
}


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $data = generaDataCasuale();
    $attributo = true;

    try {
        $queryInsert = 'INSERT INTO Prova.Esercizio (data, attributo) VALUES (:data, :attributo)';
        $stm = $db->prepare($queryInsert);
        $stm->bindValue(':data', $data);
        $stm->bindValue(':attributo', true);

        $stm->execute();
    }catch (Exception $ex) {
        echo "<script>alert('Errore nell inserimento')";

    }

}

?>