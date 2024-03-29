<?php
require "../fonctions/index.php";
require "../fonctions/admission.php";
require "../fonctions/orientation.php";

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


    if (!empty($id_annee)) {
        $_SESSION['id_annee'] = $id_annee;
    }

    if (!empty($id_parcours)) {
        $_SESSION['select'] = $id_parcours;
    }

    if (!empty($point)) {
        $_SESSION['point'] = $point;
    }

    if (isset($_POST['valider'])) {
        /* le nombre total d'étudiants avec les points critères calculés */
        $total_etudiant_evalue = (int)TotalEtudiantEvalue($id_annee, $id_etablissement, $id_departement, $id_parcours);
        /* le nombre total d'étudiant dans ce parcours */
        $total_etudiants = (int)TotalEtudiantParcours($id_annee, $id_etablissement, $id_departement, $id_parcours);

        /* si il n'y a aucune donnée dans un parcours */
        if ($total_etudiants > 0) {
            if ($total_etudiant_evalue != $total_etudiants) {
                $message = "Veuillez calculer le point critère de tous les étudiants de ce parcours avant de faire la selection des admis .";
            } else {
                /* oui */
                $choix_mode_calcul = (int)$_POST['mode-calcul'];
                /* si il selectionne tout parcours confondu */
                if ($choix_mode_calcul === 0) {
                    if ($point > 0) {
                        $type_critere = 2;
                        $id_parcours_a = 0;

                        /* réinitialiser ce qui a été fait par le mode par parcours */
                        resetCritere($id_annee, $id_etablissement, $id_departement);
                        /* verifier si il y a eu une deliberation */
                        $deliberation = (int)verifierDeliberation($type_critere, $id_etablissement, $id_departement, $id_parcours_a, $id_annee);
                        /* tout parcours confonu */
                        if ($deliberation > 0) {
                            /* mise à jour */
                            majDeliberation($point, $id_etablissement, $id_departement, $id_parcours_a, 0, $id_annee);
                            echo '<script language="JavaScript" type="text/javascript">window.location.replace("attribution-manuel.php");</script>';
                        } else {
                            /* création */
                            creerDeliberation($type_critere, $point, $id_etablissement, $id_departement, $id_parcours_a, 0, $id_annee);
                            echo '<script language="JavaScript" type="text/javascript">window.location.replace("attribution-manuel.php");</script>';
                        }
                    } else {
                        $message = "veuillez selectionner une valeur dans le champ critère de selection .";
                    }
                } else {
                    $type_critere = 1;
                    if ($point > 0) {

                        /* verifier si il y a eu déliberation tout parcours confondu (en cours ou terminée )*/
                        $deliberation_toutparcours = (int)verifierDeliberation(2, $id_etablissement, $id_departement, 0, $id_annee);
                        if ($deliberation_toutparcours) {
                            /* réinitialiser ce qui a été fait par le mode tout parcours confondu */
                            resetCritere($id_annee, $id_etablissement, $id_departement);
                            /* supprime la deliberation tout parcours confondu de la table */
                            supprimerDeliberation(2, $id_etablissement, $id_departement, $id_annee);
                        }

                        /* verifier si il y a eu deliberation par parcours */
                        $deliberation = (int)verifierDeliberationT($type_critere, $id_etablissement, $id_departement, $id_parcours, $id_annee);
                        if ($deliberation) {
                            /* on affiche une fenetre modale */
                            echo "<script>$(window).on('load',function(){ $('#critereModal').modal('show'); });</script>";
                        } else {
                            /* si il selectionne par parcours */
                            creerDeliberation($type_critere, $point, $id_etablissement, $id_departement, $id_parcours, 1, $id_annee);
                            AppliquerCritere($id_annee, $id_etablissement, $id_departement, $id_parcours, $point);
                            $_SESSION['success'] = "selection effectuée avec succès .";
                        }

                    } else {
                        $message = "veuillez selectionner une valeur dans le champ critère de selection .";
                    }
                }
            }


        } else {
            $message = "veuillez selectionner un parcours avec des étudiants inscrits dans la base de donnée .";
        }

    }

    /* si il confirme sur le modal */
    if (isset($_POST['confirmer'])) {
        $id_annee = $_SESSION['id_annee'];
        $point = $_SESSION['point'];
        $id_parcours = $_SESSION['select'];

        /* reset */
        resetCritere($id_annee, $id_etablissement, $id_departement);
        resetDeliberation($id_etablissement, $id_departement, $id_parcours, $id_annee);

        /* mise à jour des déliberations */
        majDeliberation($point, $id_etablissement, $id_departement, $id_parcours, 1, $id_annee);

        /* application des nouveaux critères */
        AppliquerCritere($id_annee, $id_etablissement, $id_departement, $id_parcours, $point);

        $_SESSION['success'] = "selection effectuée avec succès .";
    }
}
?>

<h1 class="h4 mb-1 text-primary text-uppercase mb-4">calcul des points critères</h1>

<!-- Begin Page Content -->
<form method="post">
    <?php include_once "modal/question.php"; ?>
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">Filtre de recherche</h6>
        </div>
        <div class="card-body">
            <?php if (isset($message) && !empty($message)): ?>
                <div class="bg-danger text-white">
                    <p class="p-2"><?= $message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
                <div class="bg-success text-white">
                    <p class="p-2"><?= $_SESSION['success']; ?></p>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

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
                </table>
            </div>
        </div>
    </div>

    <?php
    if ($_SESSION["id_type_utilisateur "] == 1 || $_SESSION['id_groupe_utilisateur'] == 20):
        ?>
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">selection des admis</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="col-3">
                        <label for="mode-calcul" class="mr-5">mode de selection</label>
                        <select class="form-control" name="mode-calcul" id="mode-calcul" onchange="ChangerPara(this.value)">
                            <option value="0"> tout parcours confondu</option>
                            <option value="1" selected> par parcours</option>
                        </select>
                    </div>

                    <div class="col-4" id="parTest">
                        <label for="id_parcours">Parcours</label>
                        <select class="form-control" name="id_parcours" id="id_parcours">
                            <option value="0">parcours</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="id_critere_selection" class="mr-5">critère de selection</label>
                        <select class="form-control" name="id_critere_selection" id="id_critere_selection">
                            <option value=""> selectionner</option>
                            <?php for ($i = 0; $i <= 24; $i++): ?>
                                <option value="<?= $i ?>">point superieur à <?= $i ?> </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <br>
                <div align="right">
                    <input class="btn btn-primary" name="valider" type="submit" value="valider">
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
</form>

<!-- /.container-fluid -->

<script type="text/javascript">
    function ChangerPara(value) {
        if (value == 0){
            $('#parTest').toggle()
        }else {
            $('#parTest').toggle()
        }
    }
</script>
