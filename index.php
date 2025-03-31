<?php
$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

echo '<br>';
$url = trim(str_replace('mvc', '', $url), '/');
echo '<br>';
echo $url;
echo '<br>';
echo 'Ciao sono index';

$routes = [
    'GET' =>[
        'home/index' => ["controller"=>"HomeController", "action"=>"presentation1"],
        'home/products' => ["controller"=>"ProductController", "action"=>"show1"],
        'home/services' => ["controller"=>"ServicesController", "action"=>"presentation3"],
        ],
    'POST' => [
        'home/index' => ["controller"=>"HomeController", "action"=>"presentation1"],
        'home/products' => ["controller"=>"ProductController", "action"=>"show1"],
        'home/services' => ["controller"=>"ServicesController", "action"=>"presentation3"],
    ],
];

//mancano le tre classi
?>