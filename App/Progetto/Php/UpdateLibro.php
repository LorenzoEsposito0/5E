<?php
require_once 'header.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Aggiorna Prezzo Libro</title>
</head>
<body>
<form method="post" class="body2">
    <br><br>
    <div class="text3">
        <label for="titoloLibro">Inserisci il titolo del libro: </label>
        <input type="text" id="titoloLibro" name="titoloLibro" required>
        <br><br>
        <label for="prezzoLibro">Inserisci il nuovo prezzo del libro: </label>
        <input type="number" id="prezzoLibro" step="0.01" name="prezzoLibro" required>
        <br><br>
        <button type="submit">Aggiorna Prezzo</button>
    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titolo = $_POST['titoloLibro'];
    $nuovoPrezzo = $_POST['prezzoLibro'];

    try {
        $db = new PDO('mysql:host=localhost;dbname=libreria', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        // Verifica se il libro esiste
        $checkQuery = 'SELECT COUNT(*) as count FROM libri WHERE titolo = :titolo';
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bindValue(':titolo', $titolo);
        $checkStmt->execute();
        $result = $checkStmt->fetch();

        if ($result->count == 0) {
            echo "<script>alert('Il libro non esiste nel database.');</script>";
        } else {
            $query = 'UPDATE libri SET prezzo = :prezzo WHERE titolo = :titolo';
            $stmt = $db->prepare($query);
            $stmt->bindValue(':titolo', $titolo);
            $stmt->bindValue(':prezzo', $nuovoPrezzo);

            if ($stmt->execute()) {
                echo "<p class='success'>PREZZO AGGIORNATO CON SUCCESSO</p>";
            } else {
                echo "<p class='error'>Errore durante l'aggiornamento del prezzo.</p>";
            }
        }
    } catch (PDOException $e) {
        echo "<p class='error'>Errore: " . $e->getMessage() . "</p>";
    }
}
?>

<?php require_once 'footer.php'; ?>
</body>
</html>
