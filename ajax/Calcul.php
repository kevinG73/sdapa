<?php
include "../config/connexion.php";
include "../fonctions/index.php";

if (isset($_POST) && !empty($_POST)):
    /* variables */
    $moyl1 = (float)$_POST['moyl1'];
    $moyl2 = (float)$_POST['moyl2'];
    $moyl3 = (float)$_POST['moyl3'];
    $moya = (float)$_POST['moya'];
    $numero_carte = $_POST['numero_carte'];

    $critere_age = 0;
    $critere_temps1 = 0;
    $critere_moyenne_annuelle = 0;
    $critere_nombre_mention = 0;

    if (isset($_POST['temps'])) {
        $critere_temps1 = (int)$_POST['temps'];
    }

    if (isset($_POST['date_naissance'])) {
        $critere_age = (int)calculAge($_POST['date_naissance']);
    }

    if (isset($_POST['moya'])) {
        $critere_moyenne_annuelle = (int)$_POST['moya'];
    }

    if (isset($_POST['nbr_mention'])) {
        $critere_nombre_mention = (int)$_POST['nbr_mention'];
    }




    $p_age = 0;
    $p_temps1 = 0;
    $p_moyenne_annuelle = 0;
    $p_nombre_mention = 0;

    /* critère age */
    if ($critere_age >= 20 && $critere_age < 24) {
        $p_age = 4;
    } elseif ($critere_age >= 24 && $critere_age < 26) {
        $p_age = 2;
    } elseif ($critere_age >= 26) {
        $p_age = 0;
    }

    /* critère temps */
    if ($critere_temps1 == 3) {
        $p_temps1 = 4;
    } elseif ($critere_temps1 == 4) {
        $p_temps1 = 3;
    } elseif ($critere_temps1 == 5) {
        $critere_temps1 = 1;
    } elseif ($critere_temps1 == 6) {
        $p_temps1 = 0;
    }

    /*  critère moyenne annuelle */
    if ($critere_moyenne_annuelle >= 18 && $critere_moyenne_annuelle < 20) {
        $p_moyenne_annuelle = 8;
    } elseif ($critere_moyenne_annuelle >= 16 && $critere_moyenne_annuelle < 18) {
        $p_moyenne_annuelle = 6;
    } elseif ($critere_moyenne_annuelle >= 14 && $critere_moyenne_annuelle < 16) {
        $p_moyenne_annuelle = 5;
    } elseif ($critere_moyenne_annuelle >= 12 && $critere_moyenne_annuelle < 14) {
        $p_moyenne_annuelle = 3;
    } elseif ($critere_moyenne_annuelle >= 11 && $critere_moyenne_annuelle < 12) {
        $p_moyenne_annuelle = 1;
    } elseif ($critere_moyenne_annuelle < 11) {
        $p_moyenne_annuelle = 0;
    }

    /*  critère nbr mention */
    if ($critere_nombre_mention >= 42) {
        $p_nombre_mention = 10;
    } elseif ($critere_nombre_mention >= 32 && $critere_nombre_mention < 42) {
        $p_nombre_mention = 8;
    } elseif ($critere_nombre_mention >= 22 && $critere_nombre_mention < 32) {
        $p_nombre_mention = 5;
    } elseif ($critere_nombre_mention >= 12 && $critere_nombre_mention < 22) {
        $p_nombre_mention = 4;
    } elseif ($critere_nombre_mention >= 10 && $critere_nombre_mention < 12) {
        $p_nombre_mention = 2;
    } elseif ($critere_moyenne_annuelle < 10) {
        $p_nombre_mention = 1;
    }

    /* Total */
    $total = $p_nombre_mention + $p_moyenne_annuelle + $p_temps1 + $p_age;

    /* update */
    $update = $bdd->query("UPDATE inscriptions 
        SET moy_ann_l1 = $moyl1 , moy_ann_l2 = $moyl2 , moy_ann_l3 = $moyl3 , 
        nombre_de_mentions = $p_nombre_mention
     ,total_point_critere = $total , temps_mis_en_Licence = $p_temps1 WHERE numero_carte = '$numero_carte'");

    exit;
else:
    echo false;
endif;