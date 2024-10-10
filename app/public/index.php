<?php

    global $oeuvres;
    require_once '../vendor/autoload.php';
    require_once '../src/Controller/OeuvreController.php';

    $loader = new \Twig\Loader\FilesystemLoader('../src/Views');
    $twig = new \Twig\Environment($loader);

    $router = new AltoRouter();

    $controller = new OeuvreController($twig);

    $router->map('GET', '/', function() use ($controller){
        $controller->index();
    });

    $router->map('GET', '/add', function() use ($controller){
        $controller->displayForm();
    });

    $router->map('GET', '/oeuvre/[i:id]', function($id) use ($controller) {
        $controller->show($id);
    });



$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // Aucune route trouvée
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404 Not Found';
}