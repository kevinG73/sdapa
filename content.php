<?php
include "fonctions/index.php";
$etablissements = ListeEtablissements();
$annee = ListeAnnee();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['impression'] = $_POST;
    header('Location: pdf/index.php');
}
?>

<!-- Begin Page Content -->
<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filtre de recherche</h6>
    </div>
    <div class="card-body">
        <form method="post">

            <div class="d-flex justify-content-end">
                <div class="float-right pr-2">
                    <label for="exampleFormControlSelect1">Année académique</label>
                    <select class="form-control" name="annee">
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
                    <label for="exampleFormControlSelect1">Etablissements</label>
                    <select class="form-control" name="id_etablissement" id="id_etablissement">
                        <?php foreach ($etablissements as $p): ?>
                            <option value="<?php echo $p['id_etablissement'] ?>"
                                <?php if (isset($id_etablissement) && $id_etablissement === $p['id_etablissement']) echo 'selected'; ?>
                            ><?php echo $p['nom_etablissement'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-4">
                    <label for="exampleFormControlSelect1">Départements</label>
                    <select class="form-control" name="id_departement" id="id_departement">
                        <option value="0">selectionner</option>
                    </select>
                </div>
            </div>

            <div class="d-flex mt-4">
                <div class="col-2">
                    <label for="exampleFormControlSelect1">Niveau</label>
                    <select class="form-control" name="niveau" id="id_niveau">
                        <option value="3" <?php if (isset($niveau) && $niveau === '3') echo 'selected'; ?>>
                            Licence 3
                        </option>
                    </select>
                </div>

                <div class="col-4 mr-5">
                    <label for="exampleFormControlSelect1">Parcours</label>
                    <select class="form-control" name="id_parcours" id="id_parcours">
                        <option value="0">parcours</option>
                    </select>
                </div>

            </div>

            <div class="float-right mt-2 pr-2">
                <button class="btn btn-primary" id="consulter" name="consulter">consulter</button>
                <button type="submit" class="btn btn-primary" id="imprimer" name="imprimer">imprimer</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-5">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Consultation des points d'admissibilités </h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>numero de carte étudiant</th>
                <th>nom</th>
                <th>prenoms</th>
                <th>date de naissance</th>
                <th>moy l1</th>
                <th>moy l2</th>
                <th>moy l3</th>
                <th>point critère</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!-- /.container-fluid -->


