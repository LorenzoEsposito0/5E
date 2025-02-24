<?php
$alimentari = require_once 'alimentari.php';

$duplicatoDiAlimentari = [];

foreach($alimentari as $alimento=>$item)
    $duplicatoDiAlimentari[$alimento] = $item;

// var_dump($duplicatoDiAlimentari);


$secondoDuplicatoDiCopiaAlimentari = [];

foreach($alimentari as $alimento=>$item)
    $secondoDuplicatoDiCopiaAlimentari+=[$alimento=>$item];

// var_dump($secondoDuplicatoDiCopiaAlimentari);

$tipoAlimentari = array_keys($alimentari);
// var_dump($tipoAlimentari);


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
<?php foreach ($duplicatoDiAlimentari as $tipoAlimento=>$alimenti) {?>
    <h2><?=$tipoAlimento?></h2>
    <?php foreach ($alimenti as $sceltaAlimento) {?>
        <p><?=$sceltaAlimento?></p>
        <?php } ?>
<?php } ?>

<hr>
<p><?=$alimentari['frutta'][0]?></p>
<hr>
<?php foreach ($alimentari['frutta'] as $frutta)  {?>
<p><?=$frutta?></p>
    <?php } ?>
<hr>


<form action="ActionPage.php" method="post">
    <?php for($i=0; $i<count($alimentari); $i++){?>
        <p><?=$tipoAlimentari[$i]?></p>
        <label for="">Valutazione del servizio: </label><br>
        <input type="number" name="<?=$i?>" min="1" max="5">
        <label for="">Carta di credito:</label><br>
        <input type="checkbox" name="<?=$i?>" min="1" max="5">
        <label for="">Consegna a domicilio:</label><br>
        <input type="checkbox" name="<?=$i?>" min="1" max="5">
 <?php } ?>
</form>
</body>
</html>
