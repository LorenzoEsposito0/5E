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
<nav class="navbar">
    <h1 class="navbar-title">Menù Libreria</h1>
    <div class="nav-links">
        <a href="CreaLibro.php">Crea libro</a>
        <a href="FirstPage.php">HomePage</a>
        <a href="DeleteLibro.php">Cancella Libro</a>
        <a href="UpdateLibro.php">Aggiungi Modifiche</a>
    </div>
</nav>
<div class="text">
    <br>
    <?php
    $db = new PDO("mysql:host=localhost;dbname=libreria", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ]);

    $query = 'SELECT * FROM libri';
    try {
        $stm = $db -> prepare($query);
        $stm->execute();

        while($libro = $stm->fetch()){
            echo 'Titolo: '.$libro->nome.'<br>';
            echo 'Autore: '.$libro->autore.'<br>';
            echo 'Genere: '.$libro->genere.'<br>';
            echo 'Prezzo: '.$libro->prezzo.'<br>';
            echo 'Anno di Pubblicazione' .$libro->annoDiPubblicazione.'<br>';
            echo '<hr>';
        }
    }catch(Exception $e){
        logError($e);
    }
    function logError(Exception $e)
    {
        error_log($e->getMessage() . ' ----------- ' . date('Y-m-d H:i:s') . "\n", 3, __DIR__ . '/log/database_log');
        echo 'A DB error occured. Please try again';
    }
    ?>

</div>
</body>
</html>

