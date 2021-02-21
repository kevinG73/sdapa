<?php
require "../../config/connexion.php";
require "../../fonctions/index.php";
require "../../fonctions/orientation.php";

$etudiantID = $_POST['etudiantid'];

if (isset($etudiantID) && !empty($_POST['etudiantid'])) {
    $info = infoEtudiant($etudiantID);
    $parcours = ListeParcoursSelectionne($info["id_etudiant"]);

    $tableau = "";
    foreach ($parcours as $pc):
        $tableau .=
            <<<EOT
                <option value="{$pc['id_specialite']}">{$pc['libelle_specialite']}</option>        
           EOT;
    endforeach;


        echo json_encode(array(
            'info' => $info,
            'parcours' => $tableau
        ));

    }
exit;