<?php
session_start();

if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] === "") {
    header("Location:login.php");
}

require "../config/connection.php";
include "../fonctions/index.php";
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

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include "../pages/include/navbar.php"; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

<?php

if (isset($_POST['enregistrer']))
{
        
    extract($_POST);
    $utilisateur= new utilisateur(11111, $tel_utilisateur,$login_utilisateur,$mot_passe_utilisateur,$id_groupe_utilisateur,$email_utilisateur,$id_departement, $id_etablissement, $nom_utilisateur, $prenom_utilisateur,$bdd);
    $utilisateur=$utilisateur->enregistrement();
    ?>
 <div><span id="" class="form-text text-success font-weight-bold"><i class="fas fa-fa-check-square fa-md fa-fw mr-2"></i>Enregistrement effectué</span></div>
    <?php
}


if (isset($_POST['modifier']))
{ 
        
    extract($_POST);
    $utilisateur= new utilisateur($_GET['id'], $tel_utilisateur,$login_utilisateur,$mot_passe_utilisateur,$id_groupe_utilisateur,$email_utilisateur,$id_departement, $id_etablissement, $nom_utilisateur, $prenom_utilisateur,$bdd);
    $utilisateur=$utilisateur->modification();

    ?>
     <div><span id="" class="form-text text-success font-weight-bold"><i class="fas fa-fa-check-square fa-md fa-fw mr-2"></i>Modification effectuée</span></div>
    <?php
    
}

//Suppression
if (isset($_POST['supprimer'])) {
  extract($_POST);
  if (!empty($_POST["cocher"])) {
    foreach ($_POST["cocher"] as $c) {

     
 
  $utilisateur = new utilisateur($c, '','','','','','', '', '', '',$bdd);
  $utilisateur=$utilisateur->suppression();
    }
   
   ?>
    <div><span id="" class="form-text text-success font-weight-bold"><i class="fas fa-fa-check-square fa-md fa-fw mr-2"></i>Suppression effectuée</span></div>
   <?php
   
  }
}


$req=$bdd->query("SELECT * FROM utilisateur_sdapa WHERE id_utilisateur='".@$_GET['id']."' ");
$res=$req->fetch();
?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary text-uppercase">Utilisateurs (Enseignants et personnel)</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-row">



                                <div class="form-group col-md-6">
                                    <label for="Libellé">groupe utilisateur</label>
                                    <select class=" form-control" name="id_groupe_utilisateur" >
                                        <?php
                                        $req=$bdd->query('SELECT * FROM groupe_utilisateur WHERE id_groupe_utilisateur IN (19,14,20)');
                                        while ($rep=$req->fetch())
                                        {
                                            if ($res['id_groupe_utilisateur']==$rep['id_groupe_utilisateur'])
                                            {
                                                ?>
                                                <option selected value="<?=$rep['id_groupe_utilisateur']?>"> <?=$rep['libelle_groupe_utilisateur']?></option>
                                                <?php

                                            }
                                            else
                                            {

                                                ?>
                                                <option value="<?=$rep['id_groupe_utilisateur']?>"> <?=$rep['libelle_groupe_utilisateur']?></option>
                                                <?php
                                            }
                                        }
                                        ?>


                                    </select>
                                </div>



                            </div>
                            <div class="form-row">



                                <div class="form-group col-md-6">
                                    <label for="Libellé">Etablissement</label>
                                    <select class=" form-control" name="id_etablissement" onchange="select_departement(this.value)" id="id_etablissement">
                                        <option value="0">selectionner</option>
                                        <?php
                                        $req=$bdd->query('SELECT * FROM etablissement');
                                        while ($rep=$req->fetch())
                                        {
                                            if ($res['id_etablissement']==$rep['id_etablissement'])
                                            {
                                                ?>
                                                <option selected value="<?=$rep['id_etablissement']?>"> <?=$rep['nom_etablissement']?></option>
                                                <?php

                                            }
                                            else
                                            {

                                                ?>
                                                <option value="<?=$rep['id_etablissement']?>"> <?=$rep['nom_etablissement']?></option>
                                                <?php
                                            }
                                        }
                                        ?>


                                    </select>
                                </div>


                                <div class="form-group col-md-6" id="affiche">
                                    <label for="Libellé">Département</label>
                                       <?php 
                                       if (isset($_GET['id'])) 
                                       {
                                        ?>
                                        <select class=" form-control" name="id_departement" >
                                        <?php
                                        $req=$bdd->query('SELECT * FROM departement WHERE id_etablissement="'.$res['id_etablissement'].'" AND  id_departement NOT IN (39 , 40 , 41 , 52 , 53 , 28 , 29 , 30 , 
    31 ,32 , 33 , 34 , 38 , 25 , 26 , 27, 91 , 36,77,43,88,89,90) ');
                                        while ($rep=$req->fetch())
                                        {
                                            if ($res['id_departement']==$rep['id_departement'])
                                            {
                                                ?>
                                                <option selected value="<?=$rep['id_departement']?>"> <?=$rep['nom_departement']?></option>
                                                <?php

                                            }
                                            else
                                            {

                                                ?>
                                                <option value="<?=$rep['id_departement']?>"> <?=$rep['nom_departement']?></option>
                                                <?php
                                            }
                                        }
                                        ?>


                                    </select>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <select class="form-control" name="id_departement" id="id_departement">
                                            <option value="0">selectionner</option>
                                        </select>
                                            <?php
                                        } ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Libellé">Nom</label>
                                    <input type="text" class="form-control "   name="nom_utilisateur" required="" value="<?php echo @$res['nom_utilisateur']?>"  >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Libellé">Prénoms</label>
                                    <input type="" class="form-control "   name="prenom_utilisateur" required="" value="<?php echo @$res['prenom_utilisateur']?>"  >
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Libellé">Login</label>
                                    <input type="text" class="form-control "   name="login_utilisateur" required="" value="<?php echo @$res['login_utilisateur']?>"  >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Libellé">Mot de passe</label>
                                    <input type="password" class="form-control "   name="mot_passe_utilisateur" required="" value="<?php echo @$res['mot_passe_utilisateur']?>"  >
                                </div>

                            </div>






                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="Libellé">Email</label>
                                    <input type="email" class="form-control "   name="email_utilisateur" required="" value="<?php echo @$res['email_utilisateur']?>"  >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Libellé">Numero de telephone</label>

                                        <input type="text" class="form-control "    value="<?php echo @$res['tel_utilisateur']?>"  name="tel_utilisateur" >

                                </div>


                            </div>
                            <div class="form-row" id="informations">





                            </div>





                            <div class="modal fade" id="saveClasseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment enregistrer ces informations ?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Cliquez sur le bouton "Enregistrer" ci-dessous si vous voulez valider ces informations.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                            <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                                            <button type="submit" class="btn btn-primary" name="enregistrer" data-toggle="modal" data-target="#saveClasseModal" ><i class="fas fa-plus-square fa-sm fa-fw mr-2 text-gray-400"></i> Enregister </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="updateClasseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment modifier ces informations ?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Cliquez sur le bouton "Modifier" ci-dessous si vous voulez valider ces informations.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                            <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                                            <button type="submit" class="btn btn-primary" name="modifier" data-toggle="modal" data-target="#saveClasseModal" ><i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i> Modifier </button>
                                        </div>
                                    </div>
                                </div>
                            </div>




                    </form>

                        <?php
                        if (!isset($_GET['id']))
                        {
                            ?>
                            <button  class="btn btn-primary" data-toggle="modal" data-target="#saveClasseModal">Valider</button>
                            <a  class="btn btn-danger"  href="index.php">Retour</a>
                            <?php
                        }
                        else if(isset($_GET['id']))
                        {
                            ?>
                            <button  class="btn btn-primary" data-toggle="modal" data-target="#updateClasseModal">Modifier</button>
                            <a  class="btn btn-danger"  href="index.php">Retour</a>
                            <?php
                        } ?>
                    </div>
                </div>




<?php            $gu = $bdd->query("select * from utilisateur_sdapa,groupe_utilisateur,departement,etablissement where utilisateur_sdapa.id_groupe_utilisateur = groupe_utilisateur.id_groupe_utilisateur AND departement.id_departement=utilisateur_sdapa.id_departement AND utilisateur_sdapa.id_etablissement=etablissement.id_etablissement ORDER BY utilisateur_sdapa.id_utilisateur DESC") or die(print_r($bdd->errorInfo()));


                ?>

                <br>

                <form action="" method="POST">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des utilisateurs</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable-etd" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th></th>

                                        <th>Nom et prenoms </th>

                                        <th>Login</th>
                                        <th>Groupe utilisateur</th>
                                        <th>Etablissement</th>
                                        <th>Departement</th>


                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php while ($res = $gu->fetch()): ?>
                                        <tr>
                                            <td align="center">
                                                <input type="checkbox" id="cocher[]" name="cocher[]"
                                                       value="<?php echo $res['id_utilisateur']; ?>"></td>
                                            <td class="text-uppercase">
                                                <a href="?id=<?= $res['id_utilisateur']; ?>"><?= $res['nom_utilisateur']; ?> <?= $res['prenom_utilisateur']; ?></a>
                                            </td>

                                            <td >
                                                <?= $res['login_utilisateur']; ?>
                                            </td>
                                            <td >
                                                <?= $res['libelle_groupe_utilisateur']; ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?= $res['nom_etablissement']; ?>
                                            </td>
                                            <td>
                                                <?= $res['nom_departement']; ?>
                                            </td>

                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#DeleteEvaluationModal" style="margin: 20px;"><i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer la sélection</a></div>

                        <div class="modal fade" id="DeleteEvaluationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Voulez-vous vraiment supprimer la sélection ?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Cliquez sur le bouton "Supprimer" ci-dessous si vous voulez supprimer les éléments sélectionnés.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                        <!--<a class="btn btn-primary" href="index.php?page=aj_etab&amp;act=save">Enregistrer</a>-->
                                        <button type="submit" class="btn btn-danger" name="supprimer"><i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i> Supprimer </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                        <?php //include "include/crud_etudiant/modal_supp.php"; ?>
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

<script src="../vendor/validation/dist/bootstrap-validate.js"></script>
<script src="../vendor/select/dist/js/select2.min.js"></script>



<script >
     function select_departement(value){
       
        $('#affiche').load('ajax/fetch_departement.php',{
            id_etablissement:value
        });
    }
</script>
</body>

</html>
