<?php
require "../config/connexion.php";
require "../fonctions/index.php";

if (isset($_GET['id_etablissement']) && !empty($_GET['id_etablissement'])):
    $id_etablissement = (int)$_GET['id_etablissement'];
    global $bdd;
    $requete = "SELECT * FROM departement WHERE id_etablissement = $id_etablissement AND id_departement NOT IN (39 , 40 , 41 , 52 , 53 , 28 , 29 , 30 , 
    31 ,32 , 33 , 34 , 38 , 25 , 26 , 27, 91 , 36)";

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


