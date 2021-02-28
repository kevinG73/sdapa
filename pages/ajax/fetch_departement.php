<?php
session_start();
require "../../config/connection.php";
require "../../fonctions/index.php";

if (isset($_GET['id_etablissement']) && !empty($_GET['id_etablissement'])):

    if ($_SESSION['id_type_utilisateur '] == 1) {
        $id_etablissement = (int)$_GET['id_etablissement'];
        $requete = "SELECT * FROM departement WHERE id_etablissement = $id_etablissement AND id_departement NOT IN (39 , 40 , 41 , 52 , 53 , 28 , 29 , 30 , 
    31 ,32 , 33 , 34 , 38 , 25 , 26 , 27, 91 , 36,77,43,88,89,90)";
    } else {
        if ($_SESSION['id_groupe_utilisateur'] == 19 || $_SESSION['id_groupe_utilisateur'] == 20):
            $id_etablissement = (int)$_SESSION['id_etablissement'];
            $id_departement = (int)$_SESSION['id_departement'];
            $requete = "SELECT * FROM departement WHERE id_etablissement = $id_etablissement AND id_departement = $id_departement";
        else:
            $id_etablissement = (int)$_SESSION['id_etablissement'];
            $requete = "SELECT * FROM departement WHERE id_etablissement = $id_etablissement AND id_departement NOT IN (39 , 40 , 41 , 52 , 53 , 28 , 29 , 30 , 
    31 ,32 , 33 , 34 , 38 , 25 , 26 , 27, 91 , 36,77,43,88,89,90)";
        endif;

    }


    global $bdd;
    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();
    var_dump($liste);
    if (count($liste) > 0):
        foreach ($liste as $res):?>

            <?php
            if ($res['id_departement'] == isset($_SESSION['id_departement'])) {
                ?>
                <option selected value="<?= $res['id_departement'] ?>"> <?= $res['nom_departement'] ?></option>
                <?php

            } else {

                ?>
                <option value="<?= $res['id_departement'] ?>"> <?= $res['nom_departement'] ?></option>
                <?php
            }
            ?>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="0">selectionner</option>
    <?php endif; ?>
<?php endif; ?>

