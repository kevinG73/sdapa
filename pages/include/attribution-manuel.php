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
        <div class="table-responsive">
            <table class="table table-bordered w-100" id="dataTable-attribution">
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


