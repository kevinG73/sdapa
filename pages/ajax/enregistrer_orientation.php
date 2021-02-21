<?php
require "../../config/connexion.php";
require "../../fonctions/index.php";
require "../../fonctions/orientation.php";


if (isset($_POST) && !empty($_POST)) {

    $id_etudiant = $_POST['etudiant_id'];
    $id_parcours = $_POST['id_parcours'];

    /* accepter la demande dans le parcours selectionné */
    $bdd->query("UPDATE parcours_sdapa SET demande_accepte = 1  WHERE 
    id_parcours= '$id_parcours' AND id_etudiant = '$id_etudiant'") or die(print_r($bdd->errorInfo()));

    /* réfuser la demande dans les autres parcours */
    $bdd->query("UPDATE parcours_sdapa SET demande_accepte = 2  WHERE 
    id_parcours <> '$id_parcours' AND id_etudiant = '$id_etudiant'") or die(print_r($bdd->errorInfo()));

    echo true;
} else {
    echo false;
}
