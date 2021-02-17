<?php
require "../fonctions/index.php";
require "../fonctions/admission.php";

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

    if (isset($_POST['imprimer'])) {
        $_SESSION['impression'] = $_POST;
        header('Location: pdf/index.php');
    }

    if (isset($_POST['valider'])) {
        $_SESSION['select'] = $_POST['id_parcours'];
        /* nombre total d'étudiant ayant quelque chose different de 0 comme point critère */
        $pt = (int)verifierSiCalculTerminee($id_annee, $id_etablissement, $id_departement, $id_parcours);
        /* nombre total d'étudiant dans ce parcours */
        $total = (int)totalEtudiantParcours($id_annee, $id_etablissement, $id_departement, $id_parcours);

        if ($total === 0) {
            $message = "Le parcours selectionné ne contient pas d'étudiant pour effectuer une operation .";
        } else {
            /* oui */
            if ($total === $pt) {
                AppliquerCritere($id_annee, $id_etablissement, $id_departement, $id_parcours, $point);
                header('Location: admis.php');
            } else {
                $message = "Veuillez terminer le calcul des points critères de tous les étudiants de ce parcours avant d'obtenir des résultats . ";
            }
        }


    }
}
?>

<!-- Begin Page Content -->
<form method="post">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">Filtre de recherche</h6>
        </div>
        <div class="card-body">
            <?php if (isset($message) && !empty($message)): ?>
                <div class="bg-danger text-white">
                    <p class="p-2">
                        <?= $message; ?>

                    </p>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-end">
                <div class="float-right pr-2">
                    <label for="id_annee">Année académique</label>
                    <select class="form-control" name="id_annee" id="id_annee">
                        <?php foreach ($annee as $an): ?>
                            <option value="<?= $an['id_annee_academique'] ?>">
                                <?= $an['libelle_annee_academique'] ?>
                            </option>
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


    <div class="card shadow mb-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">selection des admis</h6>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="d-flex justify-content-between">
                    <div class="form-inline ">
                        <label for="id_critere_selection" class="mr-5">critère de selection</label>
                        <select class="form-control" name="id_critere_selection" id="id_critere_selection">
                            <option value="0"> selectionner</option>
                            <?php for ($i = 0; $i <= 24; $i++): ?>
                                <option value="<?= $i ?>">point superieur à <?= $i ?> </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mt-2 pr-2">
                        <input class="btn btn-primary" name="valider" type="submit" value="valider le critère">
                    </div>
                </div>
            </form>

        </div>
    </div>
</form>

<!-- /.container-fluid -->
