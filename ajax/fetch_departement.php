<?php
require "../config/connexion.php";
require "../fonctions/index.php";

if (isset($_GET['id_etablissement']) && !empty($_GET['id_etablissement'])):
    $id_etablissement = (int)$_GET['id_etablissement'];
    global $bdd;
    $requete = "SELECT * FROM departement WHERE id_etablissement = $id_etablissement AND id_departement <> 39 AND id_departement <> 40
    AND id_departement <> 41 AND id_departement <> 52 AND id_departement <> 53
    AND id_departement <> 28 AND id_departement <> 29 AND id_departement <> 30 AND id_departement <> 31
    AND id_departement <> 32 AND id_departement <> 33 AND id_departement <> 34 AND id_departement <> 38
    AND id_departement <> 25 AND id_departement <> 26 AND id_departement <> 27 AND id_departement <> 91
    AND id_departement <> 36" ;

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();
    if (count($liste) > 0):
        foreach ($liste as $res):?>
            <option value="<?= $res['id_departement'] ?>"><?= $res['nom_departement'] ?></option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="0">selectionner</option>
    <?php endif; ?>
<?php endif; ?>


