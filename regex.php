<?php


$splattern = '#abc#';
$subject = 'ciao';
$subject = 'ciabco';
$splattern = '#^abc#';
$subject = 'abcofhgd';
$subject = 'ciao abc';
$splattern = '#abc$#';
$subject = 'ciao abc rovigo';
$splattern = '#a[123]b#';
$subject = 'a221321321b';
$splattern = '#a[123]+b#';
$subject = 'ab';
$splattern = '#a[123]*b#';
$splattern = '#a[0-9]b#';
$subject = '45';
$splattern = '#4[a-zA-Z]*5#';
$subject = 'home/index/product';
$splattern = '#home/index/[a-z]+#'; // SENZA IL + ESTRAE SOLO LA PRIMA LETTERA, QUINDI IN QUESTO CASO P, CON IL + PRENDE PRODUCT
$subject = 'home/index/temp/itis/venerdì';
$subject = '/animale/cane/gatto/itis/venerdì/computer';
'ora/minuto';

$splattern = '#(/[a-z]+){1,5}#';//da uno a cinque parole
//matches è un'array che contiene i risultati della corrispondenza
if(preg_match($splattern, $subject,$matches ))
{
    echo 'match'.'<br>';
    $result = explode("/",$matches[0]);
    echo count($result);
    var_dump($result);
    var_dump($matches);
}
    else
    echo 'no match';


?>

