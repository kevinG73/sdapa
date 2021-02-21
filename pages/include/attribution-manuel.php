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
    $_SESSION['id_annee'] = $_POST['id_annee'];
    $id_etablissement = $_POST['id_etablissement'];
    $id_departement = $_POST['id_departement'];
    $id_parcours = $_POST['id_parcours'];


    if (isset($_POST['action']) && $_POST['action'] === "consulter") {
        $_SESSION['select'] = $_POST['id_parcours'];
        $admis = ListeAdmis($id_annee, $id_etablissement, $id_departement, $id_parcours);
    }

    if (isset($_POST['action']) && $_POST['action'] === "imprimer") {
        $_SESSION['impression'] = $_POST;
        header('Location:pdf/admis.php');
    }
}
?>


<div class="card shadow mb-5">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Attribution manuel des étudiants dans les
            parcours
        </h6>
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


