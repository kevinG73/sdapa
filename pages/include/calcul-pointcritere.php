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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_annee = $_POST['id_annee'];
    $id_etablissement = $_POST['id_etablissement'];
    $id_departement = $_POST['id_departement'];
    $id_parcours = $_POST['id_parcours'];
    $point = $_POST['id_critere_selection'];

    if (isset($_POST['valider'])) {
        /* le nombre total d'étudiants avec les points critères calculés */
        $total_etudiant_evalue = (int)TotalEtudiantEvalue($id_annee, $id_etablissement, $id_departement, $id_parcours);
        /* le nombre total d'étudiant dans ce parcours */
        $total_etudiants = (int)TotalEtudiantParcours($id_annee, $id_etablissement, $id_departement, $id_parcours);

        /* si il n'y a aucune donnée dans un parcours */
        if ($total_etudiants > 0) {
            if ($total_etudiant_evalue != $total_etudiants) {
                $message = "Veuillez calculer le point critère de tous les étudiants de ce parcours avant de faire la selection des admis .";
            } else {
                /* oui */
                $choix_mode_calcul = (int)$_POST['mode-calcul'];
                /* si il selectionne tout parcours confondu */
                if ($choix_mode_calcul === 0) {
                    if ($point > 0) {
                        /* réinitialiser ce qui a été fait par le mode parcours par parcours */
                        resetCritere($id_annee, $id_etablissement, $id_departement);
                        /* verifier si il y a eu une deliberation */
                        $deliberation = (int)verifierDeliberation($id_etablissement, $id_departement, $id_annee);

                        /* tout parcours confonu */
                        if ($deliberation > 0) {
                            /* mise à jour */
                            majDeliberation($point, $id_etablissement, $id_departement, $id_annee);
                            echo '<script language="JavaScript" type="text/javascript">window.location.replace("attribution-manuel.php");</script>';
                        } else {
                            /* création */
                            creerDeliberation($point, $id_etablissement, $id_departement, $id_annee);
                            echo '<script language="JavaScript" type="text/javascript">window.location.replace("attribution-manuel.php");</script>';
                        }
                    } else {
                        $message = "veuillez selectionner une valeur dans le champ critère de selection .";
                    }
                } else {
                    if ($point > 0) {
                        /* si il selectionne par parcours */
                        supprimerDeliberation($id_etablissement, $id_departement, $id_annee);
                        AppliquerCritere($id_annee, $id_etablissement, $id_departement, $id_parcours, $point);
                        echo '<script language="JavaScript" type="text/javascript">window.location.replace("admis.php");</script>';
                    } else {
                        $message = "veuillez selectionner une valeur dans le champ critère de selection .";
                    }
                }
            }


        } else {
            $message = "veuillez selectionner un parcours avec des étudiants inscrits dans la base de donnée .";
        }

    }
}
?>

<h1 class="h4 mb-1 text-primary text-uppercase mb-4">calcul des points critères</h1>

<!-- Begin Page Content -->
<form method="post">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">Filtre de recherche</h6>
        </div>
        <div class="card-body">
            <?php if (isset($message) && !empty($message)): ?>
                <div class="bg-danger text-white">
                    <p class="p-2"><?= $message; ?></p>
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

            <div class="d-flex mt-4">
                <div class="col-4 mr-5">
                    <label for="id_parcours">Parcours</label>
                    <select class="form-control" name="id_parcours" id="id_parcours">
                        <option value="0">parcours</option>
                    </select>
                </div>
            </div>

            <div class="float-right mt-2 pr-2">
                <button class="btn btn-primary" id="consulter" name="consulter">consulter</button>
                <!--
                 <button type="submit" class="btn btn-primary" id="imprimer" name="imprimer">imprimer</button>
                 -->
            </div>
        </div>
    </div>
    <div class="card shadow mb-5">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">Consultation des points d'admissibilité </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="dataTable">
                    <thead>
                    <tr>
                        <th>nom</th>
                        <th>prenoms</th>
                        <th>moy l1</th>
                        <th>moy l2</th>
                        <th>moy l3</th>
                        <th>nbre total mentions</th>
                        <th>point critère</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <?php
    if ($_SESSION["id_type_utilisateur "] == 1 || $_SESSION['id_groupe_utilisateur'] == 20):
        ?>
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">selection des admis</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="form-inline ">
                        <label for="mode-calcul" class="mr-5">mode de calcul</label>
                        <select class="form-control" name="mode-calcul" id="mode-calcul">
                            <option value="0"> tout parcours confondu</option>
                            <option value="1" selected> par parcours</option>
                        </select>
                    </div>

                    <div class="form-inline ">
                        <label for="id_critere_selection" class="mr-5">critère de selection</label>
                        <select class="form-control" name="id_critere_selection" id="id_critere_selection">
                            <option value=""> selectionner</option>
                            <?php for ($i = 0; $i <= 24; $i++): ?>
                                <option value="<?= $i ?>">point superieur à <?= $i ?> </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mt-2 pr-2">
                        <input class="btn btn-primary" name="valider" type="submit" value="valider">
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
</form>

<!-- /.container-fluid -->
