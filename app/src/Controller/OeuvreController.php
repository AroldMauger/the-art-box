<?php
require_once '../src/config/bdd.php';
class OeuvreController {

    private $twig;

    public function __construct($twig){
        $this->twig = $twig;
    }
    public function show($id) {
        $bdd = connexion();
        $requete = $bdd->prepare('SELECT * FROM oeuvres WHERE id = ?');
        $requete->execute([$id]);
        $oeuvre = $requete->fetch();

        if($oeuvre===null) {
            return header('Location: /');
        }
        echo $this->twig->render("oeuvre.html.twig", ['oeuvre' => $oeuvre]);
    }

    public function index() {
        $bdd = connexion();
        $oeuvres = $bdd->query('SELECT * FROM oeuvres');
        echo $this->twig->render("index.html.twig", ['oeuvres' => $oeuvres]);
    }

    public function displayForm() {

        echo $this->twig->render("add.html.twig");
    }
}