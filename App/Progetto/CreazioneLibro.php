<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creazione Libro</title>
</head>
<body>

<h2>Creazione del libro e aggiunta sul database</h2>
<label for="nomeLibro">inserisci nome libro: </label>
<input type="text" id="nomeLibro">
<br>
<br>
<label for="Autore">inserisci autore del libro: </label>
<input type="text" id="AutoreLibro">
<br>
<br>
<label for="Genere">inserisci genere del libro: </label>
<input type="text" id="GenereLibro">
<br>
<br>
<label for="nomeLibro">inserisci prezzo libro: </label>
<input type="text" id="nomeLibro">
<br>
<br>
<label for="nomeLibro">inserisci anno di pubblicazione libro: </label>
<input type="text" id="nomeLibro">

<button id="FinishCreate">Clicca se hai finito l'inserimento
    <?php
    $db = new PDO('mysql:host=localhost;dbname=Libreria', 'root', '',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ]);

    $queryCreate = 'INSERT INTO Libro (nome, autore, genere, prezzo, annoDiPubblicazione)';
    try {
        $statement = $db->prepare($queryCreate);
        $statement->bindValue(':nome', );
    }
    ?></button>

</body>
</html>
