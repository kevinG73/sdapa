<?php

include "../config/connexion.php";
include "../fonctions/index.php";
$etudiantID = $_POST['etudiantid'];

if (isset($etudiantID) && !empty($_POST['etudiantid'])) {
    $info = infoEtudiant($etudiantID);
    $_SESSION['etudiant_id'] = $info['id_etudiant'];
    echo json_encode($info);
}
exit;