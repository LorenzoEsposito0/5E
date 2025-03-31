<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $_SESSION['voti'] = $_POST;
}
$voti = $_SESSION['voti'];
arsort($voti);

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
<h2>Risultati dei voti</h2>
<table border="1">
    <thead>
    <tr>
        <th>Città</th>
        <th>Voto</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Mostra i risultati in tabella
    foreach ($voti as $citta => $voto) {
        echo "<tr><td>$citta</td><td>$voto</td></tr>";
    }
    ?>
    </tbody>
</table>
<br>
</body>
</html>