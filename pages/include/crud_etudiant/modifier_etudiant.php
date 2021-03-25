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
            $inscription = new inscription($annee,'','',
                '', '', '', '',
                '',$id_departement, $id_etablissement, $bdd);

            $enregistrement2 = $inscription->modification($code_et);

            $choix1 = (int)$id_parcours1;
            $choix2 = (int)$id_parcours2;
            $choix3 = (int)$id_parcours3;

            if ($choix1 == -1) {

            }else{
                $parcours_sdapa = $bdd->query('insert into parcours_sdapa (id_etudiant,id_parcours,choix) values ("' . $code_et . '","' . $choix1 . '",1)');
            }

            if ($choix2 == -1) {

            }else{
                $parcours_sdapa = $bdd->query('insert into parcours_sdapa (id_etudiant,id_parcours,choix) values ("' . $code_et . '","' . $choix2 . '",2)');
            }

            if ($choix3 == -1) {

            }else{
                $parcours_sdapa = $bdd->query('insert into parcours_sdapa (id_etudiant,id_parcours,choix) values ("' . $code_et . '","' . $choix3 . '",3)');
            }

            unset($_SESSION['id_']);
            ?>
            <script>document.location.replace("etudiant.php")</script>
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
