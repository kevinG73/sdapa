<?php
session_start();
require "../../config/connection.php";
require "../../fonctions/index.php";

extract($_POST);


        $requete = "SELECT * FROM departement WHERE id_etablissement = $id_etablissement AND id_departement NOT IN (39 , 40 , 41 , 52 , 53 , 28 , 29 , 30 , 
    31 ,32 , 33 , 34 , 38 , 25 , 26 , 27, 91 , 36,77,43,88,89,90)";
    


    global $bdd;
    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();
    
    ?>
<label for="Libellé">Département</label>
                                       <select class="form-control" name="id_departement" id="id_departement">
                                         
                                       
    <?php
    if (count($liste) > 0):
        foreach ($liste as $res):?>

            <?php
            if ($res['id_departement'] == isset($_POST['id_departement'])) {
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


 </select>