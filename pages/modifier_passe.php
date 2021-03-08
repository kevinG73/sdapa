<?php
session_start();
if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] === "") {
    header("Location:login.php");
}
require "../config/connection.php";
include '../class/utilisateur.class.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Etudiants</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../src/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../vendor/select/dist/css/select2.min.css" rel="stylesheet" />

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
                <?php
                if (isset($_POST['modifier'])) {
                    extract($_POST);
                    $utilisateur= new utilisateur($_SESSION['connecte'],'',$login_utilisateur,$mot_passe_utilisateur,'','','', '', '', '',$bdd);
                    $utilisateur=$utilisateur->modif_pass();
                    ?>
                    <div><span id="" class="form-text text-success font-weight-bold"><i class="fas fa-fa-check-square fa-md fa-fw mr-2"></i>Modification effectuée</span></div>
                    <?php
                }

                $req = $bdd->query('SELECT login_utilisateur,mot_passe_utilisateur FROM utilisateur_sdapa where id_utilisateur = "' . $_SESSION['connecte'] . '"');
                $rep = $req->fetch();
                ?>
                <form method="post">
                    <div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary text-uppercase">MODIFICATION MOT DE PASSE</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label-sm"
                                               for="exampleFormControlSelect1">Login utilisateur</label>
                                        <input type="text" class="form-control" required id="nom" name="login_utilisateur" autocomplete="off" value="<?=$rep['login_utilisateur']?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label-sm"
                                               for="exampleFormControlSelect1">Mot de passe</label>
                                        <input type="text" class="form-control" required id="nom" name="mot_passe_utilisateur" autocomplete="off" value="<?=$rep['mot_passe_utilisateur']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    include "include/crud_etudiant/modal_modifier.php";
                    ?>
                </form>
                <div align="right">
                    <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#updateClasseModal">Soumettre
                    </button>
                    <button class="btn btn-lg btn-danger">Annuler</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../src/js/sb-admin-2.min.js"></script>


<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../src/js/datatable/datatable_etd.js"></script>
<script src="../src/js/ajax.js"></script>
<script src="../src/js/etudiant_js.js"></script>
<script src="../vendor/validation/dist/bootstrap-validate.js"></script>
<script src="../vendor/select/dist/js/select2.min.js"></script>
</body>
</html>
