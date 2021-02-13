<?
session_start();
extract($_POST);
require "../config/connexion.php";
include "../fonctions/index.php";
$anneanterieur = ListeAnneeAnter();
var_dump($anneanterieur);
?>
<label class="col-form-label-sm">Année académique obtention diplome</label>
<select class="form-control" name="annee_anterieur" id="annee-anterieur">
    <?php foreach ($anneanterieur as $repanneante): ?>
        <?php
        if ($repanneante['id_annee_academique']==$_SESSION['anneeante'])
        {
            ?>
            <option selected value="<?=$repanneante['id_annee_academique']?>"> <?=$repanneante['libelle_annee_academique']?></option>
            <?php

        }
        else
        {

            ?>
            <option  value="<?=$repanneante['id_annee_academique']?>"> <?=$repanneante['libelle_annee_academique']?></option>

            <?php
        }
        ?>


    <?php endforeach; ?>
</select>