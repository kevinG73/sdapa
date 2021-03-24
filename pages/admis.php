<?php
session_start();
setlocale(LC_TIME, 'french.UTF-8', 'fr_FR.UTF-8');

require "../config/connection.php";
require "../fonctions/index.php";
require "../fonctions/admission.php";

if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] === "") {
    header("Location:../index.php");
}

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
        $_SESSION['select_departemnt'] = $_POST['id_departement'];
        $admis = ListeAdmis($id_annee, $id_etablissement, $id_departement, $id_parcours);
    }

    if (isset($_POST['action']) && $_POST['action'] === "imprimer") {
        $_SESSION['impression'] = $_POST;
        header('Location:pdf/admis.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>liste des étudiants admissibles en master 1 | UFHB </title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../src/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="../vendor/jquery/jquery.min.js"></script>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include "include/sidebar.php"; ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include "include/navbar.php"; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <h1 class="h4 mb-1 text-primary text-uppercase mb-4">Liste des admis</h1>

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
                                            ><?php echo convert_accent($p['nom_etablissement']); ?></option>
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
                                <?php if ($_SESSION['id_groupe_utilisateur'] == 14): ?>
                                    <input type="submit" class="btn btn-primary" name="action" value="imprimer">
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow mb-5">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Liste des étudiants admissibles en
                            master 1 </h6>
                    </div>
                    <div class="card-body">
                        <?php if (isset($admis) && count($admis) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="dataTable-etd">
                                    <thead>
                                    <tr>
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
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../src/js/sb-admin-2.min.js"></script>


<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../src/js/datatable/datatable_etd.js"></script>
<script src="../src/js/ajax.js"></script>
</body>

</html>