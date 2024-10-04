<?php

class OeuvreController {

    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }
    public function show($id) {
        $oeuvres = include('oeuvres.php');
        $oeuvre = null;
        foreach ($oeuvres as $o) {
            if ($id == $o['id']) {
                $oeuvre = $o;
                break;
            }
        }
        if($oeuvre=null) {
            return header('Location: /');
        }
        echo $this->twig->render("oeuvre.html.twig", ['oeuvre' => $oeuvre]);
    }

    public function index() {
        $oeuvres = include('oeuvres.php');
        echo $this->twig->render("index.html.twig", ['oeuvres' => $oeuvres]);
    }
}