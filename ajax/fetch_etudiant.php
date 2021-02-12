<?php
require "../config/connexion.php";
require "../fonctions/index.php";

if (isset($_GET['id_parcours']) && isset($_GET['id_departement'])):
    $id_departement = (int)$_GET['id_departement'];
    $id_parcours = (int)$_GET['id_parcours'];

    global $bdd;
    $requete = "SELECT * FROM etudiants etd JOIN inscriptions ins ON etd.numero_carte = ins.numero_carte
               WHERE id_parcours = $id_parcours AND id_departement = $id_departement";

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll(PDO::FETCH_ASSOC);
    if (count($liste) > 0):
        echo json_encode(array('data' => $liste));
    else:
        echo json_encode(array('data' => array()));
    endif;
endif;

