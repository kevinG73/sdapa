<?php

require "../fonctions/index.php";
require "../fonctions/admission.php";
require "../fonctions/orientation.php";

if ($_SESSION['id_type_utilisateur '] == 1) {
    $etablissements = ListeEtablissements();
} else {
    $etablissements = ListeEtablissementsSession($_SESSION['id_etablissement']);
}
$annee = ListeAnnee();
$type_deliberation = 2;
$id_parcours_a = 0;

if (isset($_SESSION['orientation'])) {
    $id_etablissement = $_SESSION['orientation']['id_etablissement'];
    $id_departement = $_SESSION['orientation']['id_departement'];
    $id_annee = $_SESSION['orientation']['id_annee'];

    $verifier = verifierDeliberation($type_deliberation, $id_etablissement, $id_departement, $id_parcours_a, $id_annee);
    if ((int)$verifier === 0) {
        unset($_SESSION['orientation']);
        $message = "Pour utiliser cette page , vous devez selectionner tout parcours confondu comme mode de calcul sur la page de calcul du critère  .";
    } else {
        $parcours = ListeParcoursDepartement($id_departement);
        $liste = ListeEtudiantOrientation($id_etablissement, $id_departement, $id_annee);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_annee = $_POST['id_annee'];
    $_SESSION['id_annee'] = $_POST['id_annee'];
    $id_etablissement = $_POST['id_etablissement'];
    $id_departement = $_POST['id_departement'];

    $_SESSION['orientation'] = array(
        'id_etablissement' => $_POST['id_etablissement'],
        'id_departement' => $_POST['id_departement'],
        'id_annee' => $id_annee
    );
    /* pour afficher les données du tableau */
    if (isset($_POST['consulter'])) {
        $verifier = verifierDeliberationC($type_deliberation, $id_etablissement, $id_departement, $id_parcours_a, $id_annee);

        if ((int)$verifier === 0) {
            unset($_SESSION['orientation']);
            $message = "Pour utiliser cette page , vous devez selectionner tout parcours confondu comme mode de calcul sur la page de calcul des points critères .";
        } else {
            $parcours = ListeParcoursDepartement($id_departement);
            $liste = ListeEtudiantOrientation($id_etablissement, $id_departement, $id_annee);
        }
    }
    /* après avoir coché une case pour affecter des étudiants */
    if (isset($_POST['affecter'])) {
        if (isset($_POST['chb_id'])) {
            $nbre_chb = count($_POST['chb_id']);
            if (!empty($_POST['chb_id'])) {
                foreach ($_POST['chb_id'] as $chb) {
                    $id_etudiant = $chb;
                    $parcours_selectionnee = $_POST['id_parcours'];
                    affecterAparcours($id_etudiant, $parcours_selectionnee);
                }
            }
        } else {
            $erreur_msg = "veuillez selectionner au moins une ligne avant d'effectuer une action .";
        }
    }
    /* si on clique sur valider pour fermer l'attributation */
    if (isset($_POST['valider'])) {
        termineDeliberation($id_etablissement, $id_departement, $id_annee);
        header('Location: admis.php');
    }
}
?>

<h1 class="h4 mb-1 text-primary text-uppercase mb-2">Attribution manuelle</h1>

<p class="mb-4">Cette page permet d'affecter les étudiants un par un dans différents parcours .</p>

<?php if (isset($message) && !empty($message)): ?>
    <div class="card text-white bg-danger">
        <div class="card-body">
            <p class="p-2 card-text text-center">
                <?= $message; ?>
            </p>
        </div>
    </div>

<?php else: ?>
    <form method="post">
        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Filtre de recherche</h6>
            </div>
            <div class="card-body">
                <?php if (isset($erreur_msg) && !empty($erreur_msg)): ?>
                    <div class="bg-danger text-white">
                        <p class="p-2">
                            <?= $erreur_msg; ?>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-end">
                    <div class="float-right pr-2">
                        <label for="id_annee">Année académique</label>
                        <select class="form-control" name="id_annee" id="id_annee">
                            <?php foreach ($annee as $an): ?>
                                <?php if (isset($_SESSION['id_annee']) && !empty($_SESSION['id_annee']) && ($_SESSION['id_annee'] == $an['id_annee_academique'])): ?>
                                    <option selected value="<?= $an['id_annee_academique'] ?>">
                                        <?= $an['libelle_annee_academique'] ?>
                                    </option>
                                <?php else: ?>
                                    <option value="<?= $an['id_annee_academique'] ?>">
                                        <?= $an['libelle_annee_academique'] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <div class="d-flex">
                    <div class="col-6 mr-5">
                        <label for="id_etablissement">Etablissement</label>
                        <select class="form-control" name="id_etablissement" id="id_etablissement">
                            <?php foreach ($etablissements as $p): ?>
                                <option value="<?php echo $p['id_etablissement'] ?>"
                                    <?php if (isset($id_etablissement) && $id_etablissement === $p['id_etablissement']) echo 'selected'; ?>
                                ><?php echo $p['nom_etablissement'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="id_departement">Départements</label>
                        <select class="form-control" name="id_departement" id="id_departement">
                            <option value="0">selectionner</option>
                        </select>
                    </div>
                </div>


                <div class="float-right mt-2 pr-2">
                    <input type="submit" class="btn btn-primary" id="consulter" name="consulter" value="consulter">
                </div>
            </div>
        </div>

        <?php if (isset($liste) && !empty($liste)): ?>
            <div class="card shadow mb-5">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary text-uppercase">Affectation manuelle des étudiants dans
                        les
                        parcours
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" id="dataTable-attribution">
                            <thead>
                            <tr>
                                <th></th>
                                <th>nom</th>
                                <th>prénom</th>
                                <th>moyenne licence</th>
                                <th>nbre total mentions</th>
                                <th>point critère</th>
                                <th>parcours</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($liste as $etd): ?>
                                <tr>
                                    <td><input type="checkbox" name="chb_id[]" value="<?= $etd['id'] ?>"></td>
                                    <td><?= $etd['nom'] ?></td>
                                    <td><?= $etd['prenoms'] ?></td>
                                    <td><?= $etd['moy_pondere'] ?></td>
                                    <td><?= $etd['total_mention'] ?></td>
                                    <td><?= $etd['total_point_critere'] ?></td>
                                    <td><?= parcoursAffecte($etd['id']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <select name="id_parcours" class="form-control">
                            <?php foreach ($parcours as $p): ?>
                                <option value="<?= $p['id_specialite'] ?>"> <?= $p['libelle_specialite']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="">
                            <input class="btn btn-primary" name="affecter" type="submit" value="enregistrer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->

            <div class="card shadow mb-5">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-uppercase">statut de l'affectation manuelle</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="form-inline">
                            <label for="status">Souhaitez vous marquer comme terminée le statut ? </label>
                        </div>

                        <div class="mt-2">
                            <input class="btn btn-primary" name="valider" type="submit" value="confirmer">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </form>
<?php endif; ?>



