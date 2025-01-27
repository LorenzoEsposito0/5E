<?php
require_once 'header.php'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Css/style.css">
    <title>ciao</title>
</head>
<body>

<div class="text">
    <br>
    <?php
    $db = new PDO("mysql:host=localhost;dbname=Libreria", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);

    $query = 'SELECT * FROM libri';
    try {
        $stm = $db->prepare($query);
        $stm->execute();

        while ($libri = $stm->fetch()) {
            echo 'Titolo: ' . $libri->titolo . '<br>';
            echo 'Autore: ' . $libri->autore . '<br>';
            echo 'Genere: ' . $libri->genere . '<br>';
            echo 'Prezzo: ' . $libri->prezzo . '<br>';
            echo 'Anno di Pubblicazione' . $libri->dataDiPubblicazione . '<br>';
            echo '<hr>';
            echo '<hr>';
        }
    } catch (Exception $e) {
        logError($e);
    }
    function logError(Exception $e)
    {
        error_log($e->getMessage() . ' ----------- ' . date('Y-m-d H:i:s') . "\n", 3, __DIR__ . '/log/database_log');
        echo 'A DB error occured. Please try again';
    }
    ?>

</div>
<?php

require_once 'footer.php'
?>
</body>
</html>

