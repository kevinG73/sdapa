<?php
session_start();
require "../../../config/connection.php";
require "../../../fonctions/index.php";
if (isset($_SESSION['id_'])):
    $parcours = $bdd->query('select * from parcours_sdapa where id_etudiant ="' . $_SESSION['id_'] . '" and choix = 3') or die(print_r($bdd->errorInfo()));
    $valeur = $parcours->fetch();
endif;

if (isset($_GET['id_departement']) && !empty($_GET['id_departement'])):
    $id_departement = $_GET['id_departement'];
    global $bdd;
    $requete = "SELECT specialite_sdapa.id_specialite ,specialite_sdapa.libelle_specialite 
                FROM specialite_sdapa,composer_maquette,mention,semestre
                where
                specialite_sdapa.id_specialite = composer_maquette.id_specialite
                and specialite_sdapa.id_mention = mention.id_mention
                and composer_maquette.id_semestre = semestre.id_semestre
                and semestre.id_niveau = 4 and mention.id_departement = '" . $id_departement . "'
                and specialite_sdapa.id_specialite not in (63,64,65,66,67,318,319)
                group by specialite_sdapa.id_specialite";

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();

    if (count($liste) > 0):
        ?>
        <option value="-1"></option>
        <?php
        foreach ($liste as $res):
            ?>
            <?php if (@$valeur['id_parcours'] == $res['id_specialite']): ?>
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
