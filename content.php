<?php
include "fonctions/index.php";
if ($_SESSION['id_type_utilisateur '] == 1){
    $etablissements = ListeEtablissements();
}else{
    $etablissements = ListeEtablissementsSession($_SESSION['id_etablissement']);
}
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
                    <label for="id_etablissement">Etablissements</label>
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

                <div class="col-4 mr-5">
                    <label for="id_critere_selection">critère de selection</label>
                    <select class="form-control" name="id_critere_selection" id="id_critere_selection">
                        <option value="0"> selectionner</option>
                        <?php for ($i = 1; $i <= 24; $i++): ?>
                            <option value="<?= $i ?>">point superieur à <?= $i ?> </option>
                        <?php endfor; ?>
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

<!-- /.container-fluid -->


