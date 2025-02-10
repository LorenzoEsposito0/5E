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
    <title>Document</title>
</head>
<body>
<h3>INSERIMENTO PILOTA</h3>
    <form method="post" class="body">
        <label for="NumeroPilota">Inserisci numero</label>
        <input id="NumeroPilota" type="number">
        <br>
        <br>
        <label for="NomePilota">Inserisci nome</label>
        <input id="NomePilota" type="text">
        <br>
        <br>
        <label for="CognomePilota">Inserisci cognome</label>
        <input id="CognomePilota" type="text">
        <br>
        <br>
        <label for="NazionalitàPilota">Inserisci nazionalità</label>
        <input id="NazionalitàPilota" type="text">
        <br>
        <br>
        <button id="InviaCreazionePilota">Invia</button>
    </form>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $numero = $_POST['NumeroPilota'];
    $nome = $_POST['NomePilota'];
    $cognome = $_POST['CognomePilota'];
    $nazionalità = $_POST['NazionalitàPilota'];

    try {
        //connessione database
        $db = new PDO('mysql:host=localhost;dbname=Campionato','root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);

        //faccio la query
        $query = 'INSERT INTO Pilota (numero, nome, cognome, nazionalità)
                    VALUES (:numero, $nome, $cognome, $nazionalità)';

        //faccio la variabile statement
        $stmt = $db ->prepare($query);

        //binding
        $stmt->bindValue(':numero', $numero);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':cognome', $cognome);
        $stmt->bindValue(':nazionalità', $nazionalità);
        $stmt->execute();

    }catch (Exception $ex)
    {
        echo "Errore durante l'inserimento: ". $ex->getMessage();
    }

}
?>
</body>
</html>
