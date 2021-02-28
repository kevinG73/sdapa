<?php
session_start();
require "../../config/connection.php";
require "../../fonctions/index.php";


$array_parcours = [];
if (isset($_SESSION['id_'])):
    $parcours = $bdd->query('select * from parcours_sdapa where id_etudiant ="' . $_SESSION['id_'] . '"') or die(print_r($bdd->errorInfo()));

    while ($res_parcours = $parcours->fetch()):
        array_push($array_parcours, $res_parcours['id_parcours']);
    endwhile;
endif;
if (isset($_GET['id_departement']) && !empty($_GET['id_departement'])):
    $id_departement = $_GET['id_departement'];
    global $bdd;
    $requete = "SELECT specialite.id_specialite ,specialite.libelle_specialite 
                FROM specialite,composer_maquette,mention,semestre
                where
                specialite.id_specialite = composer_maquette.id_specialite
                and specialite.id_mention = mention.id_mention
                and composer_maquette.id_semestre = semestre.id_semestre
                and semestre.id_niveau = 4 and mention.id_departement = '" . $id_departement . "'
                and specialite.id_specialite not in (63,64,65,66,67,318,319)
                group by specialite.id_specialite";

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();

    
    if (count($liste) > 0):
        foreach ($liste as $res):
            ?>
            <?php if ((isset($_SESSION['select']) && !empty($_SESSION['select']) && ($res['id_specialite'] === $_SESSION['select'])) || in_array($res['id_specialite'], $array_parcours)): ?>
            <option selected
                    value="<?= $res['id_specialite'] ?>"> <?= convert_accent($res['libelle_specialite']) ?></option>
        <?php else: ?>
            <option value="<?= $res['id_specialite'] ?>"> <?= convert_accent($res['libelle_specialite']) ?></option>
        <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="0">selectionner</option>
    <?php endif; ?>
<?php else: ?>
    <option value="0">selectionner</option>
<?php endif; ?>


