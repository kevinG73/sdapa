<?php
session_start();

if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] === "") {
    header("Location:login.php");
}

require "config/connexion.php";
include "fonctions/index.php";
include 'inscription.class.php';

$etudiants = ListeEtudiants();
$etablissements = ListeEtablissements();
$anne = ListeAnnee();
$anneanterieur = ListeAnneeAnter();
$pays = ListePays();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Etudiants</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include "partials/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include "partials/navbar.php"; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <?php
                require "fonction.php";
                require "etudiant.class.php";
                $sexes = fetchSexe();
                $nationalites = fetchNationalite();

                if (isset($_POST['enregistrer'])){
                   include 'crud_etudiant/enregister_etudiant.php';
                }

                if (isset($_POST['modifier'])){
                    include 'crud_etudiant/modifier_etudiant.php';

                }


                if (isset($_GET['id'])) {
                    $etud = $bdd->query('select * from etudiant_sdapa where id ="' . $_GET['id'] . '"') or die(print_r($bdd->errorInfo()));
                    $res = $etud->fetch();
                    $insc = $bdd->query('select * from inscription_sdapa where id_etudiant ="' . $_GET['id'] . '"') or die(print_r($bdd->errorInfo()));
                    $resins = $insc->fetch();
                    $resdd = $bdd->query('select * from cursus where id_etudiant ="' . $_GET['id'] . '"') or die(print_r($bdd->errorInfo()));
                    $resdip = $resdd->fetch();
                    $_SESSION['annee']=$resins['annee'];
                    $_SESSION['id_etablissement']=$resins['id_etablissement'];
                    $_SESSION['id_parcours']=$resins['id_parcours'];
                    $_SESSION['id_departement']=$resins['id_departement'];
                    $_SESSION['anneeante'] = $resdip['id_anne_ante'];

                }

                if (isset($_POST['supprimer'])) {
                    include 'crud_etudiant/supprimer_etudiant.php';
                }

                ?>

                <form method="post">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">STRUCTURE D'ACCEUIL</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <div class="float-right pr-2">
                                    <label class="col-form-label-sm">Année académique</label>
                                    <select class="form-control" name="annee" id="anneaca">
                                        <?php foreach ($anne as $repanne): ?>
                                            <?php
                                            if ($repanne['id_annee_academique']==$_SESSION['annee'])
                                            {
                                                ?>
                                                <option selected value="<?=$repanne['id_annee_academique']?>"> <?=$repanne['libelle_annee_academique']?></option>
                                                <?php

                                            }
                                            else
                                            {

                                                ?>
                                                <option  value="<?=$repanne['id_annee_academique']?>"> <?=$repanne['libelle_annee_academique']?></option>

                                                <?php
                                            }
                                            ?>


                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label-sm" for="exampleFormControlSelect1">Etablissements</label>
                                    <select class="form-control" name="id_etablissement" id="id_etablissement">
                                        <?php foreach ($etablissements as $p): ?>
                                            <option value="<?php echo $p['id_etablissement'] ?>"
                                            <?php if (isset($id_etablissement) && $id_etablissement === $p['id_etablissement']) echo 'selected'; ?>
                                            <?php
                                            if ($p['id_etablissement']==@$_SESSION['id_etablissement'])
                                            {
                                                ?>
                                                <option selected value="<?=$p['id_etablissement']?>"> <?=$p['nom_etablissement']?></option>
                                                <?php

                                            }
                                            else
                                            {

                                                ?>
                                                <option  value="<?=$p['id_etablissement']?>"> <?=$p['nom_etablissement']?></option>

                                                <?php
                                            }
                                            ?>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm" for="id_departement">Départements</label>
                                    <select class="form-control" name="id_departement" id="id_departement">
                                        <option value="0">selectionner</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label-sm" for="id_parcours">Parcours</label>
                                    <select class="form-control" name="id_parcours" id="id_parcours">
                                        <option value="0">parcours</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">IDENTITE ETUDIANT</h6>
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($_GET['id'])) :
                                ?>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label class="col-form-label-sm">Etes vous étudiant de l'UFHB</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="radio" id="radio1"
                                            <?php if ($res['ufhb'] == 1): echo 'checked disabled'; endif;?>>
                                        <label class="form-control-sm">Oui</label>
                                        <input type="radio" id="radio2"
                                            <?php if ($res['ufhb'] == 2): echo 'checked disabled'; endif;?>>
                                        <label class="form-control-sm">Non</label>
                                    </div>
                                </div>
                            <?php
                            else:
                                ?>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label class="col-form-label-sm">Etes vous étudiant de l'UFHB</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="radio" name="etudiant_ufhb" id="radio1" onchange="load_page1()" checked value="OUI">
                                        <label class="form-control-sm">Oui</label>
                                        <input type="radio" name="etudiant_ufhb" id="radio2" onchange="load_page2()" value="NON">
                                        <label class="form-control-sm">Non</label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php
                            if (isset($_GET['id'])) :
                                if ($res['ufhb'] == 1):
                                    ?>
                                    <div class="form-row" id="voir_num_carte">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label-sm">Numero Carte etudiant</label>
                                            <input type="text" class="form-control text-uppercase" name="numero_carte"
                                                   value="<?php echo @ $res['numero_carte'] ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label-sm">Numero Mers</label>
                                            <input type="text" class="form-control text-uppercase" name="numero_mers"
                                                   value="<?php echo @ $res['mesrs'] ?>">
                                        </div>
                                    </div>
                                <?php
                                else:
                                    ?>
                                    <input type="hidden" class="form-control text-uppercase" name="numero_carte" value="<?php echo @ $res['numero_carte'] ?>">
                                    <input type="hidden" class="form-control text-uppercase" name="numero_mers" value="<?php echo @ $res['mesrs'] ?>">
                                <?php
                                endif;
                            else:
                                ?>
                                <div class="form-row" id="voir_num_carte">
                                    <div class="form-group col-md-4">
                                        <label class="col-form-label-sm">Numero Carte etudiant</label>
                                        <input type="text" class="form-control text-uppercase" name="numero_carte">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-form-label-sm">Numero Mers</label>
                                        <input type="text" class="form-control text-uppercase" name="numero_mers">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Nom</label>
                                    <input type="text" class="form-control text-uppercase" id="nom" name="nom"
                                           value="<?php echo @ $res['nom'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Prénoms</label>
                                    <input type="text" class="form-control text-uppercase" id="prenoms" name="prenoms"
                                           value="<?php echo @ $res['prenoms'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="col-form-label-sm">Genre</label>
                                    <select class="form-control text-uppercase" id="id_sexe"  name="id_sexe">
                                        <?php foreach ($sexes as $sexe): ?>
                                            <?php if ($res['sexe'] == $sexe['id_sexe']) : ?>
                                                <option selected
                                                        value="<?= $sexe['id_sexe'] ?>"> <?= $sexe['libelle_sexe'] ?></option>
                                            <?php else: ?>
                                                <option value="<?= $sexe['id_sexe'] ?>"> <?= $sexe['libelle_sexe'] ?></option>
                                            <?php endif; ?>
                                            ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Date de Naissance</label>
                                    <input type="date" class="form-control text-uppercase" onchange="testage(this.value)" id="datenaiss" name="date_naissance"
                                           value="<?php echo @ $res['date_naissance'] ?>" max="<?= date('Y-m-d'); ?>">
                                    <div class="invalid-tooltip" id="Vdatemin" style="display: none">Age minimum 16 ans</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Lieu Naissance</label>
                                    <input type="text" class="form-control text-uppercase" name="lieu_naissance"
                                           value="<?php echo @ $res['lieu_naissance'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm ">Nationalité</label>
                                    <select class="form-control text-uppercase" id="paysnaiss" name="origine">
                                        <?php foreach ($nationalites as $nationalite): ?>
                                            <?php if ($res['nationalite'] == $nationalite['id_nationalite']): ?>
                                                <option selected
                                                        value="<?= $res['nationalite'] ?>"> <?= $nationalite['libelle_nationalite'] ?></option>
                                            <?php else: ?>
                                                <option value="<?= $nationalite['id_nationalite'] ?>"> <?= $nationalite['libelle_nationalite'] ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Email</label>
                                    <input type="email" class="form-control" id="datenaiss" name="mail"
                                           value="<?php echo @ $res['email'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Contact</label>
                                    <input type="text" class="form-control text-uppercase" name="contat"
                                           value="<?php echo @ $res['telephone'] ?>">
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="card show mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">CURSUS UNIVERSITAIRE ANTERIEUR</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm">Année académique obtention diplome</label>
                                    <select class="form-control" name="annee_anterieur" id="annee-anterieur">
                                        <?php foreach ($anneanterieur as $repanneante): ?>
                                            <?php
                                            if ($repanneante['id_annee_academique']==$_SESSION['anneeante'])
                                            {
                                                ?>
                                                <option selected value="<?=$repanneante['id_annee_academique']?>"> <?=$repanneante['libelle_annee_academique']?></option>
                                                <?php

                                            }
                                            else
                                            {

                                                ?>
                                                <option  value="<?=$repanneante['id_annee_academique']?>"> <?=$repanneante['libelle_annee_academique']?></option>

                                                <?php
                                            }
                                            ?>


                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm" for="exampleFormControlSelect1">Etablissement origine</label>
                                    <input type="text" class="form-control text-uppercase" value="<?=@$resdip['etablissement']?>" name="eta_anterieur">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-form-label-sm" for="exampleFormControlSelect1">Pays obtention diplome</label>
                                    <select class="form-control text-uppercase" name="pays_anterieur">
                                        <?php foreach ($pays as $payt): ?>
                                            <?php if ($resdip['id_pays_obtention'] == $payt['id_pays']) : ?>
                                                <option selected
                                                        value="<?= $payt['id_pays'] ?>"> <?= $payt['lib_pays'] ?></option>
                                            <?php else: ?>
                                                <option value="<?= $payt['id_pays'] ?>"> <?= $payt['lib_pays'] ?></option>
                                            <?php endif; ?>
                                            ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4" id="diplome1">
                                    <label class="col-form-label-sm" for="exampleFormControlSelect1">Diplome obtenue</label>
                                    <select class="form-control text-uppercase" id="diplome1"  name="diplome1">
                                        <?php $diplome = ListeDiplome()?>
                                        <?php foreach ($diplome as $dip): ?>
                                            <?php if ($resdip['id_diplomes'] == $dip['id_diplomes']) : ?>
                                                <option selected
                                                        value="<?= $dip['id_diplomes'] ?>"> <?= $dip['libelle_diplomes'] ?></option>
                                            <?php else: ?>
                                                <option value="<?= $dip['id_diplomes'] ?>"> <?= $dip['libelle_diplomes'] ?></option>
                                            <?php endif; ?>
                                            ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="diplome2">
                                    <label class="col-form-label-sm" for="exampleFormControlSelect1">Saisir diplome obtenue</label>
                                    <input type="text" class="form-control text-uppercase" name="diplome2">
                                </div>
                                <button class="btn btn-sm btn-info mr-5" type="button" onclick="autre()" data-dismiss="modal" style="height: 47px;margin-top: 2rem;">
                                    Autres
                                </button>


                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="saveClasseModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment
                                        enregistrer ces informations ?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Cliquez sur le bouton "Enregistrer" ci-dessous si vous
                                    voulez valider ces informations.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                        Annuler
                                    </button>
                                    <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                                    <button type="submit" class="btn btn-primary" name="enregistrer"
                                            data-toggle="modal" data-target="#saveClasseModal"><i
                                                class="fas fa-plus-square fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Enregister
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="updateClasseModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment modifier
                                        ces informations ?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Cliquez sur le bouton "Modifier" ci-dessous si vous
                                    voulez valider ces informations.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                        Annuler
                                    </button>
                                    <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                                    <button type="submit" class="btn btn-primary" name="modifier"
                                            data-toggle="modal" data-target="#saveClasseModal"><i
                                                class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i> Modifier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <br>
                <div align="right">
                    <?php if (!isset($_GET['id'])): ?>
                        <button class="btn btn-lg btn-primary" data-toggle="modal"
                                data-target="#saveClasseModal">Soumettre
                        </button>
                        <button class="btn btn-lg btn-danger" type="reset">Annuler</button>
                    <?php elseif (isset($_GET['id'])) : ?>
                        <button class="btn btn-lg btn-primary" data-toggle="modal"
                                data-target="#updateClasseModal">Soumettre
                        </button>
                        <button type="button" onclick="destroy()" class="btn btn-lg btn-danger">Annuler</button>
                    <?php endif; ?>
                    <div id="destroy">

                    </div>
                </div>

                <?php
                $gu = $bdd->query("SELECT * FROM etudiant_sdapa") or die(print_r($bdd->errorInfo()));
                ?>

                <br>

                <form action="" method="POST">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des etudiants</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable-etd" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Etudiant</th>
                                        <th>date de naissance</th>
                                        <th>lieu de naissance</th>
                                        <th>contact</th>
                                        <th>email</th>
                                        <th>étudiant ufhb</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php while ($res = $gu->fetch()): ?>
                                        <tr>
                                            <td align="center">
                                                <input type="checkbox" id="cocher[]" name="cocher[]"
                                                       value="<?php echo $res['id']; ?>"></td>
                                            <td class="text-uppercase">
                                                <a href="etudiant.php?id=<?= $res['id']; ?>"><?= $res['nom']; ?> <?= $res['prenoms']; ?></a>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= date('m-d-Y',strtotime($res['date_naissance'])); ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= $res['lieu_naissance']; ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= $res['telephone']; ?>
                                            </td>
                                            <td >
                                                <?= $res['email']; ?>
                                            </td>
                                            <td>
                                                <?php if($res['ufhb'] == 1):
                                                    ?>
                                                    Oui
                                                <?php
                                                endif;?>
                                                <?php if($res['ufhb'] == 2):
                                                    ?>
                                                    Non
                                                <?php
                                                endif;?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#DeleteEvaluationModal"
                                style="margin: 20px;"><i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                                Supprimer la sélection</a></div>

                        <div class="modal fade" id="DeleteEvaluationModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer la
                                            sélection ?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Cliquez sur le bouton "Supprimer" ci-dessous si vous voulez
                                        supprimer les éléments sélectionnés.
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler
                                        </button>
                                        <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                                        <button type="submit" class="btn btn-danger" name="supprimer"><i
                                                    class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- /.container-fluid -->

        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>


<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/datatable_etd.js"></script>
<script src="js/ajax.js"></script>
<script>
    $('#diplome2').hide();
    function load_page1()
    {
        $('#voir_num_carte').show();

    }
    function load_page2()
    {
        $('#voir_num_carte').hide();

    }
    function destroy(){
        $('#destroy').load('destroy.php')
    }

    function autre(){
        $('#diplome1').toggle();
        $('#diplome2').toggle();
    }

    function testage(value) {
        dob = new Date(value);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        if (age<16){
            $('#Vdatemin').show();
        }else {
            $('#Vdatemin').hide();
        }
    }


</script>

</body>

</html>
