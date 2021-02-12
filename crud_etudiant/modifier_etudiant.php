<?php
if (isset($_POST['modifier'])) {
    extract($_POST);
    $numero_carte = $_GET['id'];
    $nom = $nom;
    $prenom = $prenoms;
    $date_naissance = $date_naissance;
    $lieu_naissance = $lieu_naissance;
    $sexe = $id_sexe;
    $nationalite = $origine;
    $email = $mail;
    $telephone = $contat;

    $insertEt = new etudiant($numero_carte, "", $nom, $prenom, $date_naissance, $lieu_naissance, $sexe, $nationalite, $email, $telephone, $bdd);
    $verificaion = $insertEt->verification();
    if ($verificaion === 1) {
        $modification = $insertEt->modification();
        if ($modification == 1) {
            ?>
            <div><span class="form-text text-success font-weight-bold"><i
                        class="fas fa-ban fa-md fa-fw mr-2"></i>Informations modifiées avec succès .</span>
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
                    class="fas fa-check-square fa-md fa-fw mr-2"></i><?= $verificaion ?></span>
        </div>
        <?php

    }

}
?>