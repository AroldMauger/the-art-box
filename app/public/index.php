<?php

global $oeuvres;
require_once '../vendor/autoload.php';
require_once 'oeuvres.php';

$loader = new \Twig\Loader\FilesystemLoader('/');
$twig = new \Twig\Environment($loader);

$template = $twig->load('index.html.twig');
echo $template->render(['oeuvres' => $oeuvres]);

?>