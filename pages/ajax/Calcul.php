<?php
require "../../config/connexion.php";
require "../../fonctions/index.php";

if (isset($_POST) && !empty($_POST)):


    /* variables */
    $moyl1 = (float)$_POST['moyl1'];
    $moyl2 = (float)$_POST['moyl2'];
    $moyl3 = (float)$_POST['moyl3'];
    $moyp = (float)$_POST['moyp'];
    $id_etudiant = $_POST['etudiant_id'];

    $critere_age = 0;
    $critere_temps1 = 0;
    $critere_moyenne_annuelle = 0;
    $critere_nombre_mention = 0;


    $p_age = 0;
    $p_temps1 = 0;
    $p_moyenne_annuelle = 0;
    $p_nombre_mention = 0;

    if (isset($_POST['temps'])) {
        $critere_temps1 = (int)$_POST['temps'];
    }

    if (isset($_POST['age'])) {
        $critere_age = (int)$_POST['age'];
    }


    if (isset($moyp)) {
        $critere_moyenne_annuelle = (float)$moyp;
    }

    if (isset($_POST['moypond_l4'])) {
        $critere_nombre_mention = (float)$_POST['moypond_l4'];
        $p_nombre_mention = (int)$critere_nombre_mention;
    }

    /* critère age */
    if ($critere_age >= 20 && $critere_age < 24) {
        $p_age = 5;
    } elseif ($critere_age >= 24 && $critere_age < 26) {
        $p_age = 3;
    } elseif ($critere_age >= 26) {
        $p_age = 1;
    }


    /* critère temps */
    if ($critere_temps1 == 3) {
        $p_temps1 = 4;
    } elseif ($critere_temps1 == 4) {
        $p_temps1 = 3;
    } elseif ($critere_temps1 == 5) {
        $p_temps1 = 1;
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

    /* Total */
    $total = $p_nombre_mention + $p_moyenne_annuelle + $p_temps1 + $p_age;


    /* update */
    $update = $bdd->query("UPDATE inscription_sdapa 
        SET moy_ann_l1 = $moyl1 , moy_ann_l2 = $moyl2 , moy_ann_l3 = $moyl3 , moy_pondere = $moyp , total_mention = $p_nombre_mention
     ,total_point_critere = $total , temps_mis_en_Licence = $critere_temps1 WHERE id_etudiant = '$id_etudiant'") or die(print_r($bdd->errorInfo()));


    for ($i = 1; $i <= 3; $i++) {

        if (isset($_POST['mention_l' . $i . '_c1'])) {
            $ab[$i] = (int)$_POST['mention_l' . $i . '_c1'];
        }
        if (isset($_POST['mention_l' . $i . '_c2'])) {
            $b[$i] = (int)$_POST['mention_l' . $i . '_c2'];
        }
        if (isset($_POST['mention_l' . $i . '_c3'])) {
            $tb[$i] = (int)$_POST['mention_l' . $i . '_c3'];
        }
        if (isset($_POST['total_l' . $i])) {
            $total_l[$i] = (int)$_POST['total_l' . $i];
        }
        if (isset($_POST['moypond_l' . $i])) {
            $moypondl[$i] = (float)$_POST['moypond_l' . $i];
        }

        $requupdate = 'update total_mentions set ab = "' . $ab[$i] . '" , mb= "' . $b[$i] . '" , tb= "' . $tb[$i] . '" , 
                          total_mention = "' . $total_l[$i] . '" , moy_pondere = "' . $moypondl[$i] . '"  where id_etudiant = "' . $id_etudiant . '" and id_niveau = "' . $i . '" ';
        $rep3 = $bdd->prepare($requupdate);
        $rep3->execute();

    }

    exit;
else:
    echo false;
endif;