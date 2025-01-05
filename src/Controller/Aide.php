<?php

/* Affiche la page d'aide si l'utilisateur est connecté */


session_start();

require '../../config/routes.php';


if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {

    echo $twig->render('connexion.twig');
    exit;
} else {


    $active = ["", "", "", "", "active"];
    echo $twig->render('Aide.twig', ['active' => $active]);
    exit;
}
