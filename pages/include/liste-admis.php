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

    if (isset($_POST['action']) && $_POST['action'] === "consulter") {
        $admis = ListeAdmis($id_annee, $id_etablissement, $id_departement,$id_parcours);
    }

    if (isset($_POST['action']) && $_POST['action'] === "imprimer") {
        $_SESSION['impression'] = $_POST;
        header('Location:pdf/admis.php');
    }
}
?>

<!-- Begin Page Content -->
<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Filtre de recherche</h6>
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
                <input type="submit" class="btn btn-primary" name="action" value="consulter">
                <input type="submit" class="btn btn-primary" name="action" value="imprimer">
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-5">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Liste des admis en master 1 </h6>
    </div>
    <div class="card-body">
        <?php if (isset($admis) && count($admis) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="dataTable-etd">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>nom</th>
                        <th>prenoms</th>
                        .
                        <th>moyenne pondérée</th>
                        <th>temps mis en Licence</th>
                        <th>nbre total mentions</th>
                        <th>point critère</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($admis as $etudiant): ?>
                        <tr>
                            <td><?= $etudiant['id'] ?></td>
                            <td><?= $etudiant['nom'] ?></td>
                            <td><?= $etudiant['prenoms'] ?></td>
                            <td><?= $etudiant['moy_pondere'] ?></td>
                            <td><?= $etudiant['temps_mis_en_Licence'] ?></td>
                            <td><?= $etudiant['total_mention'] ?></td>
                            <td><?= $etudiant['total_point_critere'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>


<!-- /.container-fluid -->


