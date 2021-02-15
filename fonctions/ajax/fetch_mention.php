<?php
require "../config/connexion.php";
require "../fonction.php";

if (isset($_GET['id_parcours']) && !empty($_GET['id_parcours'])):
    $id_parcours = (int)$_GET['id_parcours'];

    global $bdd;
    $requete = "SELECT * FROM mention m JOIN departement d ON m.id_departement = d.id_departement JOIN specialite s ON s.id_mention = m.id_mention WHERE id_specialite  = $id_parcours";

    $resultat = $bdd->query($requete);
    $liste = $resultat->fetchAll();

    if (count($liste) > 0):
        foreach ($liste as $res):?>
            <option value="<?= $res['id_mention'] ?>"><?= $res['libelle_mention'] ?></option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="0">selectionner</option>
    <?php endif; ?>
<?php endif; ?>


