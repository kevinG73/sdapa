<?php
require "../config/connexion.php";
require "../fonctions/index.php";

if (isset($_GET['id_parcours']) && isset($_GET['id_departement']) && isset($_GET['id_annee'])):
    $id_departement = (int)$_GET['id_departement'];
    $id_parcours = (int)$_GET['id_parcours'];
    $id_annee = (int)$_GET['id_annee'];

    global $bdd;
    $requete = "SELECT * FROM etudiant_sdapa etd JOIN inscription_sdapa ins ON etd.id = ins.id_etudiant
               WHERE id_parcours = $id_parcours AND id_departement = $id_departement AND annee = $id_annee";


    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll(PDO::FETCH_ASSOC);
    if (count($liste) > 0):
        echo json_encode(array('data' => $liste));
    else:
        echo json_encode(array('data' => array()));
    endif;
else:
    echo json_encode(array('data' => array()));
endif;

