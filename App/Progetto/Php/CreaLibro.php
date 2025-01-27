<?php
// Codice PHP se necessario
require_once 'header.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Menù Libreria</title>
</head>
<body>
<!-- Navbar -->

<!-- Contenuto principale -->
<form method="post" class="body">
    <br><br>
    <div class="text2">
        <label for="titoloLibro">Inserisci il titolo del libro: </label>
        <input type="text" id="titoloLibro" name="titoloLibro" required>
        <br><br>
        <label for="autoreLibro">Inserisci l'autore del libro: </label>
        <input type="text" id="autoreLibro" name="autoreLibro" required>
        <br><br>
        <label for="prezzoLibro">Inserisci il prezzo del libro: </label>
        <input type="number" id="prezzoLibro" name="prezzoLibro" required>
        <br><br>
        <label for="genereLibro">Inserisci il genere del libro: </label>
        <input type="text" id="genereLibro" name="genereLibro" required>
        <br><br>
        <label for="annoPubblicazione">Inserisci l'anno di pubblicazione: </label>
        <input type="date" id="annoPubblicazione" name="annoPubblicazione" required>
        <br><br>
        <button id="InviaCreateLibro">Invia</button>
    </div>

    <?php
    // la condizione controlla se il metodo della richiesta è il post, serve per identificare se un modulo HTML è stato inviato
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Recupera i dati dal modulo
        $titolo = $_POST['titoloLibro'];// recupera l'id d'input scritto dall'utente
        $autore = $_POST['autoreLibro'];// recupera l'id d'input scritto dall'utente
        $genere = $_POST['genereLibro'];// recupera l'id d'input scritto dall'utente
        $prezzo = $_POST['prezzoLibro'];// recupera l'id d'input scritto dall'utente
        $dataDiPubblicazione = $_POST['annoPubblicazione'];// recupera l'id d'input scritto dall'utente

        // 2. Connessione al database
        try {
            $db = new PDO('mysql:host=localhost;dbname=Libreria', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);

            // 3. Query di inserimento
            $query = 'INSERT INTO libri (titolo, autore, genere, prezzo, dataDiPubblicazione) 
                          VALUES (:titolo, :autore, :genere, :prezzo, :dataDiPubblicazione)';
            $stmt = $db->prepare($query);

            // 4. Binding dei parametri
            $stmt->bindValue(':titolo', $titolo);
            $stmt->bindValue(':autore', $autore);
            $stmt->bindValue(':prezzo', $prezzo);
            $stmt->bindValue(':genere', $genere);
            $stmt->bindValue(':dataDiPubblicazione', $dataDiPubblicazione);
            // 5. Esecuzione della query
            $stmt->execute();

            // 6. Messaggio di conferma
        } catch (PDOException $e) {
            // Gestione degli errori
            echo "Errore durante l'inserimento: " . $e->getMessage();
        }
    }

    ?>
</form>
<?php

require_once 'footer.php'
?>
</body>
</html>
