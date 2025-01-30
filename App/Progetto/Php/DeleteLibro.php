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
    <title>Elimina Libro</title>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
<form method="post" class="body3">
    <br><br>
    <div class="text4">
        <label for="titoloLibro">Inserisci il titolo del libro da eliminare: </label>
        <br>
        <br>
        <input type="text" id="titoloLibro" name="titoloLibro" required>
        <br><br>
        <button type="submit">Elimina Libro</button>

    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titolo = $_POST['titoloLibro'];

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
            echo "<script>showAlert('Il libro non esiste nel database.');</script>";
        } else {
            $query = 'DELETE FROM libri WHERE titolo = :titolo';
            $stmt = $db->prepare($query);
            $stmt->bindValue(':titolo', $titolo);

            if ($stmt->execute()) {
                echo "<script>showAlert('Libro eliminato con successo!');</script>";
            } else {
                echo "<script>showAlert('Errore durante l\'eliminazione del libro.');</script>";
            }
        }
    } catch (PDOException $e) {
        echo "<script>showAlert('Errore: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>

<?php require_once 'footer.php'; ?>
</body>
</html>
