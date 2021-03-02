<?php
session_start();
require "../../config/connection.php";
require "../../fonctions/index.php";

if (isset($_GET['id_departement']) && !empty($_GET['id_departement'])):
    $id_departement = $_GET['id_departement'];
    global $bdd;
    $requete = "SELECT specialite_sdapa.id_specialite ,specialite_sdapa.libelle_specialite 
                FROM specialite,composer_maquette,mention,semestre
                where
                specialite_sdapa.id_specialite = composer_maquette.id_specialite
                and specialite_sdapa.id_mention = mention.id_mention
                and composer_maquette.id_semestre = semestre.id_semestre
                and semestre.id_niveau = 4 and mention.id_departement = '" . $id_departement . "' 
                group by specialite_sdapa.id_specialite";

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();


    if (count($liste) > 0):
        foreach ($liste as $res):
            ?>
            <option value="<?= $res['id_specialite'] ?>"> <?php echo $res['libelle_specialite'] ?></option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="0">selectionner</option>
    <?php endif; ?>
<?php else: ?>
    <option value="0">selectionner</option>
<?php endif; ?>


