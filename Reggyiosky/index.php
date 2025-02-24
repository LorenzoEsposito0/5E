<?php

$alimentari = require_once 'alimentari.php';

$duplicatoDiAlimentari=[];
foreach($alimentari as $alimento=>$item)
    $duplicatoDiAlimentari[$alimento]=$item;
//var_dump($duplicatoAlimentari);

$secondoDuplicatoDiCopiaAlimentari = [];
foreach ($alimentari as $alimento=>$item)
    $secondoDuplicatoDiCopiaAlimentari+=[$alimento=>$item];
//var_dump($secondoDuplicatoDiCopiaAlimentari);

$tipoAlimentari = array_keys($alimentari);
//var_dump($tipoAlimentari);
?>

<!doctype html>
<html lang="it">
<head><title>Ciao Mondo!</title></head>
<body>
<?php
foreach ($duplicatoDiAlimentari as $tipoAlimento=>$alimenti) {?>
    <h2><?=$tipoAlimento?></h2>
    <?php foreach($alimenti as $sceltaAlimento) {?>
        <p><?=$sceltaAlimento?></p>
    <?php } ?>
<?php } ?>
<hr>
<p><?=$alimentari['frutta'][0]?></p>
<hr>
<?php foreach($alimentari['frutta'] as $frutta) {?>
    <p><?=$frutta?></p>
<?php } ?>
<hr>
<hr>
<form action="ActionPage.php" method="post">
    <?php for($i=0; $i<count($alimentari); $i++) {?>
        <p><?=$tipoAlimentari[$i]?></p>
        <label for="<?=$i?>Val">Valutazione del servizio</label><br>
        <input type="number" name="<?=$i?>Val" id="<?=$i?>Val" min="1" max="5">
        <label for="<?=$i?>Car">Carta di credito</label><br>
        <input type="checkbox" name="<?=$i?>Car" id="<?=$i?>Car">
        <label for="<?=$i?>Cons">Consegna a domicilio</label><br>
        <input type="checkbox" name="<?=$i?>Cons" id="<?=$i?>Cons">
    <?php } ?>
    <input type="hidden", name="count" value="<?=count($alimentari)?>">
    <input type="submit" value="invia">
</body>
</html>