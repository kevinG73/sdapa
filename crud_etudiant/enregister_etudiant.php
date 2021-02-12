<?php
if (isset($_POST['enregistrer'])) {
    extract($_POST);
    $numero_carte = $numero_carte;
    $mesrs = $numero_mers;
    $nom = $nom;
    $prenom = $prenoms;
    $date_naissance = $date_naissance;
    $lieu_naissance = $lieu_naissance;
    $sexe = $id_sexe;
    $nationalite = $origine;
    $email = $mail;
    $telephone = $contat;


    $_SESSION['annee'] = $annee;
    $_SESSION['id_etablissement'] = $id_etablissement;
    $_SESSION['niveau'] = $niveau;
    $_SESSION['id_parcours'] = $id_parcours;
    $_SESSION['id_departement'] = $id_departement;

    $insertEt = new etudiant($numero_carte, $mesrs, $nom, $prenom, $date_naissance, $lieu_naissance, $sexe, $nationalite, $email, $telephone, $bdd);
    $verificaion = $insertEt->verification();
    if ($verificaion === 1) {
        $enregistrement = $insertEt->enregistrement();
        if ($enregistrement == 1) {
            $inscription = new inscription(null, $annee, $numero_carte, 0, 0, 0, 0, 0, $niveau, $id_parcours, $id_departement, $id_etablissement, $bdd);
            $enregistrement2 = $inscription->enregistrement();
            ?>
            <div>
                                <span class="form-text text-success font-weight-bold"><i
                                        class="fas fa-ban fa-md fa-fw mr-2"></i>Information enregistrée avec succès</span>
            </div>
            <?php

        } else {

            ?>
            <div><span id="" class="form-text text-success font-weight-bold"><i
                        class="fas fa-check-square fa-md fa-fw mr-2"></i><?= $enregistrement ?></span>
            </div>
            <?php
        }

    } else {

        ?>
        <div><span id="" class="form-text text-warning font-weight-bold"><i
                    class="fas fa-check-square fa-md fa-fw mr-2"></i><?= $verificaion ?></span>
        </div>
        <?php
    }
}
?>