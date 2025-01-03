<?php
session_start();

require '../../config/routes.php';
require '../Model/interaction.php';


if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {

    echo $twig->render('connexion.twig');
    exit;
} else {

    $information = array();
    if (isset($_GET['id']))
        $information = info_entreprise2($_GET['id']);
    

    $active = ["", "active", "", "", ""];

    echo $twig->render('EntrepriseEdit.twig', [ 'active'=> $active, 'info' => $information]);
    exit;
}
