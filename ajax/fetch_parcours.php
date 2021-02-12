<?php
require "../config/connexion.php";
require "../fonctions/index.php";

if (isset($_GET['id_departement']) && !empty($_GET['id_niveau'])):
    $id_departement = $_GET['id_departement'];
    $id_niveau = $_GET['id_niveau'];
    global $bdd;
    $requete = "SELECT specialite.id_specialite ,specialite.libelle_specialite 
                FROM specialite,composer_maquette,mention,semestre
                where
                specialite.id_specialite = composer_maquette.id_specialite
                and specialite.id_mention = mention.id_mention
                and composer_maquette.id_semestre = semestre.id_semestre
                and semestre.id_niveau = '" . $id_niveau . "' and mention.id_departement = '" . $id_departement . "' 
                group by specialite.id_specialite";

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();

    if (count($liste) > 0):
        foreach ($liste as $res):
            ?>
            <option value="<?= $res['id_specialite'] ?>"><?= $res['libelle_specialite'] ?></option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="0">selectionner</option>
    <?php endif; ?>
<?php endif; ?>


