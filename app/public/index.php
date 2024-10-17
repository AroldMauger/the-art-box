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

    $router->map('POST', '/validate', function() use ($controller) {
        $controller->validateForm();

    });

    $router->map('POST', '/delete/[i:id]', function($id) use ($controller) {
        $controller->delete($id);
    });

    $router->map('POST', '/update/[i:id]', function($id) use ($controller) {
        $controller->update($id);
    });

    $router->map('GET', '/update/[i:id]', function($id) use ($controller) {
        $controller->displayUpdateForm($id);
    });





$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header('Location: /');
    exit();
}