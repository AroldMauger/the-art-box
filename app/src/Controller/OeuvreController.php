<?php

class OeuvreController {

    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }
    public function show($id) {
        $oeuvres = include('oeuvres.php');
        foreach ($oeuvres as $oeuvre) {
            if ($id == $oeuvre['id']) {
                $o = $oeuvre;
                break;
            }
        }
        echo $this->twig->render("oeuvre.html.twig");
    }

    public function index() {
        $oeuvres = include('oeuvres.php');
        echo $this->twig->render("index.html.twig", ['oeuvres' => $oeuvres]);
    }
}