<?php
require_once 'header.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Css/style.css"> <!-- Collegamento al file CSS -->
    <title>Lista Libri</title>
</head>
<body>

<div class="text">
    <h1>Lista dei Libri</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Titolo</th>
            <th>Autore</th>
            <th>Genere</th>
            <th>Prezzo</th>
            <th>Anno di Pubblicazione</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Connessione al database
        $db = new PDO("mysql:host=localhost;dbname=libreria", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        // Query per ottenere tutti i libri
        $query = 'SELECT * FROM libri';

        try {
            $stm = $db->prepare($query);
            $stm->execute();

            // Genera una riga per ogni libro nella tabella
            while ($libri = $stm->fetch()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($libri->titolo) . '</td>';
                echo '<td>' . htmlspecialchars($libri->autore) . '</td>';
                echo '<td>' . htmlspecialchars($libri->genere) . '</td>';
                echo '<td>' . htmlspecialchars($libri->prezzo) . ' €</td>';
                echo '<td>' . htmlspecialchars($libri->dataDiPubblicazione) . '</td>';
                echo '</tr>';
            }
        } catch (Exception $e) {
            logError($e);
        }

        // Funzione per loggare eventuali errori
        function logError(Exception $e)
        {
            error_log($e->getMessage() . ' ----------- ' . date('Y-m-d H:i:s') . "\n", 3, __DIR__ . '/log/database_log');
            echo '<tr class="error-message"><td colspan="6">Si è verificato un errore. Riprova più tardi.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<?php
require_once 'footer.php';
?>
</body>
</html>
