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

        if (!$oeuvre) {
            return header('Location: /');
            exit();
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

        if (!$oeuvre) {
            header('Location: /');
            return;
        }

        echo $this->twig->render("update.html.twig", ['oeuvre' => $oeuvre]);
    }


    public function validateForm() {

        $titre = trim($_POST['titre']);
        $description = trim($_POST['description']);
        $artiste = trim($_POST['artiste']);
        $image = trim($_POST['image']);

        if (empty($titre) || empty($description) || empty($artiste) || empty($image)
            || strlen($titre) < 3
            || strlen($description) < 3
            || strlen($artiste) < 3
            || !filter_var($image, FILTER_VALIDATE_URL)) {

            header('Location: /add');
        } else {
            $titre = htmlspecialchars($titre);
            $description = htmlspecialchars($description);
            $artiste = htmlspecialchars($artiste);
            $image = htmlspecialchars($image);

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
        $select = $bdd->prepare('SELECT * FROM oeuvres WHERE id = ?');
        $select->execute([$id]);
        $select->fetch();

        if ($select->rowCount() === 1) {

            $titre = trim($_POST['titre']);
            $description = trim($_POST['description']);
            $artiste = trim($_POST['artiste']);
            $image = trim($_POST['image']);

            if (empty($titre) || empty($description) || empty($artiste) || empty($image)
                || strlen($titre) < 3
                || strlen($description) < 3
                || strlen($artiste) < 3
                || !filter_var($image, FILTER_VALIDATE_URL)) {

                header('Location: /');
                exit;
            }

            $requete = $bdd->prepare('UPDATE oeuvres SET titre = ?, description = ?, artiste = ?, image = ? WHERE id = ?');
            $requete->execute([
                htmlspecialchars($titre),
                htmlspecialchars($description),
                htmlspecialchars($artiste),
                htmlspecialchars($image),
                $id
            ]);

            header('Location: /oeuvre/' . $id);
            exit;
        } else {
            header('Location: /');
            exit;
        }
    }


}