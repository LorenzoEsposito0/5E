<?php
require 'header.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Creazione Libro</title>
</head>
<body>


<h2>Creazione del libro e aggiunta sul database</h2>

<!-- Aggiungi il form con il metodo POST -->
<form method="POST" action="CreazioneLibro.php">
    <label for="nomeLibro">Inserisci nome libro:</label>
    <input type="text" name="nomeLibro" id="nomeLibro" required><br>
    <br>
    <label for="autoreLibro">Inserisci autore del libro:</label>
    <input type="text" name="autoreLibro" id="autoreLibro" required><br>
    <br>
    <label for="genereLibro">Inserisci genere del libro:</label>
    <input type="text" name="genereLibro" id="genereLibro" required><br>
    <br>
    <label for="prezzoLibro">Inserisci prezzo libro:</label>
    <input type="number" name="prezzoLibro" id="prezzoLibro" step="0.01" required><br>
    <br>
    <label for="annoDiPubblicazione">Inserisci anno di pubblicazione libro:</label>
    <input type="date" name="annoDiPubblicazione" id="annoDiPubblicazione" required><br>
    <br>
    <button type="submit">Clicca qua per inviare i dati al db</button>
</form>


<?php
// Connessione al database MySQL
$db = new PDO('mysql:host=localhost;dbname=libreria', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal form
    $titolo = isset($_POST['nomeLibro']) ? $_POST['nomeLibro'] : null;
    $autore = isset($_POST['autoreLibro']) ? $_POST['autoreLibro'] : null;
    $genere = isset($_POST['genereLibro']) ? $_POST['genereLibro'] : null;
    $prezzo = isset($_POST['prezzoLibro']) ? $_POST['prezzoLibro'] : null;
    $annoDiPubblicazione = isset($_POST['annoDiPubblicazione']) ? $_POST['annoDiPubblicazione'] : null;

    // Controlla se i dati sono validi
    if ($titolo && $autore && $genere && $prezzo && $annoDiPubblicazione) {
        // Query per inserire i dati nel database
        $queryCreate = "INSERT INTO libri (titolo, autore, genere, prezzo, annoDiPubblicazione)
                        VALUES (:titolo, :autore, :genere, :prezzo, :annoDiPubblicazione)";

        // Prepara la query e associa i valori
        $statement = $db->prepare($queryCreate);
        $statement->bindValue(':titolo', $titolo);
        $statement->bindValue(':autore', $autore);
        $statement->bindValue(':genere', $genere);
        $statement->bindValue(':prezzo', $prezzo);
        $statement->bindValue(':annoDiPubblicazione', $annoDiPubblicazione);

        // Esegui la query
        $statement->execute();

        echo "Libro inserito con successo!";
    } else {
        echo "Errore: tutti i campi sono obbligatori.";
    }
}
?>



<br><br>
</body>
</html>
