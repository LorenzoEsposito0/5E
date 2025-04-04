<?php
$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
//echo $url;
//echo '<br>';

$url=trim(str_replace('mvc5E','',$url),'/');
//echo $url;

/*/MVC5E/index.php
index.php*/

//echo 'ciao sono index';
/*ho configurato il server in modo da visualizzare nonostante cambio url */

//prima versione del router
$routes = [
    'GET' =>[
        'home/index' => ["controller"=>"HomeController", "action"=>"presentation1"],
        'home/products' => ["controller"=>"ProductController", "action"=>"show1"],
        'home/services' => ["controller"=>"ServiceController", "action"=>"presentation3"]
    ],
    'POST'=>[
        'home/index' => ["controller"=>"HomeController", "action"=>"presentation11"],
        'home/products' => ["controller"=>"ProductController", "action"=>"show11"],
        'home/services' => ["controller"=>"ServiceController", "action"=>"presentation33"]
    ]
    ];

//RITORNA GET
//var_dump($routes[$method]);
//var_dump($routes[$method][$url]);

$routerClass = new Router('GET', 'home/index', 'HomeController', 'presentation1');
$routerClass = new Router('GET', 'home/index', 'HomeController', 'presentation1');
$routerClass = new Router('GET', 'home/index', 'HomeController', 'presentation1');
$routerClass = new Router('GET', 'home/index', 'HomeController', 'presentation1');
        
$controller = $routes[$method][$url]['controller'];
//echo $controller;

$action = $routes[$method][$url]['action'];
// echo $action;


require $controller.'.php';
//creo un istanza della classe
$controllerObj = new $controller();
$controllerObj->$action();

