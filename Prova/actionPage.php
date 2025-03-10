<?php
$config = require 'conf.php';
require_once("DbConfig.php");
$db = DbConfig::getDB($config);

// Conta il numero totale di righe con attributo TRUE
$queryCount = "SELECT COUNT(*) as total FROM Prova.Esercizio WHERE attributo = TRUE";
$stm = $db->prepare($queryCount);
$stm->execute();
$numeroMassimoRighe = $stm->fetch(PDO::FETCH_ASSOC)['total'];

// Se l'utente ha inviato il numero di righe da aggiornare
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_righe'])) {
    $numRighe = $_POST['num_righe'];

    // Validazione: Il numero deve essere tra 1 e il totale delle righe con TRUE
    if ($numRighe > 0 && $numRighe <= $numeroMassimoRighe) {
        $queryUpdate = "UPDATE Prova.Esercizio 
                        SET attributo = FALSE 
                        WHERE attributo = TRUE 
                        LIMIT :numRighe";

        $stm = $db->prepare($queryUpdate);
        $stm->bindValue(':numRighe', $numRighe);
        $stm->execute();

        echo "<script>alert('Aggiornamento completato!')</script>";
    } else {
        $errore = "Il numero deve essere tra 1 e $numeroMassimoRighe!";
    }
}

// Recupera tutti i dati della tabella per la visualizzazione
$queryVisualizza = "SELECT data, attributo FROM Prova.Esercizio";
$stm = $db->prepare($queryVisualizza);
$stm->execute();
$risultati = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aggiorna e Visualizza</title>
</head>
<body>
<h2>Aggiorna Attributo</h2>

<form method="post">
    <label for="num_righe">Inserisci un numero (1 - <?= $numeroMassimoRighe ?>):</label>
    <input type="number" id="num_righe" name="num_righe" min="1" max="<?= $numeroMassimoRighe ?>" required>
    <button type="submit">Conferma</button>
</form>

<h2>Tabella Dati</h2>
<table border="1">
    <thead>
    <tr>
        <th>Data</th>
        <th>Attributo</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($risultati as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['data']) ?></td>
            <td><?= $row['attributo'] ? 'Vero' : 'Falso' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
