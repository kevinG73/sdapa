<?php
if (isset($_POST['modifier'])) {
    extract($_POST);
    $code_et = $_GET['id'];
    $nom = $nom;
    $prenom = $prenoms;
    $date_naissance = $date_naissance;
    $lieu_naissance = $lieu_naissance;
    $sexe = $id_sexe;
    $nationalite = $origine;
    $email = $mail;
    $telephone = $contat;
    $numero_carte = $numero_carte;
    $mesrs = $numero_mers;

    $insertEt = new etudiant($code_et,$numero_carte,$mesrs,$nom,$prenoms,$date_naissance
        ,$lieu_naissance,$sexe,$nationalite,$email,$telephone,'',$bdd);
    $verificaion = $insertEt->verification();
    if ($verificaion === 1) {
        $modification = $insertEt->modification();
        $cursus = $insertEt->modifiercursus($code_et,$annee_anterieur,$eta_anterieur,$diplome1,$diplome2,$pays_anterieur);
        if ($modification == 1) {
            $inscription = new inscription($annee, $code_et,'',
                '', '', '', '',
                '', $id_parcours, $id_departement, $id_etablissement, $bdd);
            $enregistrement2 = $inscription->modification();
            ?>
            <div><span class="form-text text-success font-weight-bold"><i
                        class="fas fa-check-square fa-md fa-fw mr-2"></i>Informations modifiées avec succès .</span>
            </div>
            <?php

        } else {

            ?>
            <div><span class="form-text text-warning font-weight-bold"><i
                        class="fas fa-ban fa-md fa-fw mr-2"></i><?= $modification ?></span></div>
            <?php

        }

    } else {

        ?>
        <div><span id="" class="form-text text-warning font-weight-bold"><i
                    class="fas fa-ban fa-md fa-fw mr-2"></i><?= $verificaion ?></span>
        </div>
        <?php

    }

}
?>