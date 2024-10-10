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

    public function displayUpdateForm($id) {
        $bdd = connexion();
        $requete = $bdd->prepare('SELECT * FROM oeuvres WHERE id = ?');
        $requete->execute([$id]);
        $oeuvre = $requete->fetch();

        if ($oeuvre === null) {
            header('Location: /');
            exit;
        }

        echo $this->twig->render("update.html.twig", ['oeuvre' => $oeuvre]);
    }


    public function validateForm() {
        if (empty($_POST['titre']) || empty($_POST['description']) || empty($_POST['artiste']) || empty($_POST['image'])
            || strlen($_POST['description']) < 3
            || !filter_var($_POST['image'], FILTER_VALIDATE_URL)) {

            header('Location: /add');
        } else {
            $titre = htmlspecialchars($_POST['titre']);
            $description = htmlspecialchars($_POST['description']);
            $artiste = htmlspecialchars($_POST['artiste']);
            $image = htmlspecialchars($_POST['image']);

            $bdd = connexion();

            $requete = $bdd->prepare('INSERT INTO oeuvres (titre, description, artiste, image) VALUES (?, ?, ?, ?)');
            $requete->execute([$titre, $description, $artiste, $image]);

            header('Location: /oeuvre/' . $bdd->lastInsertId());
        }
    }

    public function delete($id) {
        $bdd = connexion();
        $requete = $bdd->prepare('DELETE FROM oeuvres WHERE id = ?');
        $requete->execute([$id]);
        header('Location: /');
    }

    public function update($id)
    {
            $bdd = connexion();
            $requete = $bdd->prepare('UPDATE oeuvres SET titre = ?, description = ?, artiste = ?, image = ? WHERE id = ?');
            $requete->execute([
                htmlspecialchars($_POST['titre']),
                htmlspecialchars($_POST['description']),
                htmlspecialchars($_POST['artiste']),
                htmlspecialchars($_POST['image']),
                $id
            ]);
         header('Location: /oeuvre/' . $id);

    }

}