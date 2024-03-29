<?php
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

$_SESSION['id_etablissement'] = $id_etablissement;
$_SESSION['id_departement'] = $id_departement;

$code_et = uniqid('SADP', false);


if ($etudiant_ufhb == 'OUI') {
    $ufhb = 1;
}
if ($etudiant_ufhb == 'NON') {
    $ufhb = 2;
}
$insertEt = new etudiant($code_et, $numero_carte, $mesrs, $nom, $prenoms, $date_naissance
    , $lieu_naissance, $sexe, $nationalite, $email, $telephone, $ufhb, $bdd);
$verificaion = $insertEt->verification();
if ($verificaion == 1) {
    $enregistrement = $insertEt->enregistrement();
    $cursus = $insertEt->insertcursus($code_et, $annee_anterieur, $eta_anterieur, $diplome1, $diplome2, $pays_anterieur);
    if ($enregistrement == 1) {

        for ($i = 1; $i <= 3; $i++) {
            $mention = $bdd->query('insert into total_mentions(id_niveau, id_etudiant, ab, mb, tb, total_mention, moy_pondere) VALUES ("' . $i . '","' . $code_et . '",0,0,0,0,0)') or die(print_r($bdd->errorInfo()));
        }

        $inscription = new inscription($annee, $code_et, 3,
            0, 0, 0, 0,
            3, $id_departement, $id_etablissement, $bdd);

        $enregistrement2 = $inscription->enregistrement();
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



        ?>
        <div>
                                <span class="form-text text-success font-weight-bold"><i
                                            class="fas fa-check-square fa-md fa-fw mr-2"></i>Information enregistrée avec succès</span>
        </div>
        <?php

    } else {
        $etu=$bdd->query('SELECT * FROM etudiant_sdapa WHERE numero_carte="'.@$numero_carte .'"');
        $rep_etu=$etu->fetch();

        ?>
        <div><span id="" class="form-text text-warning font-weight-bold"><i
                        class="fas fa-ban fa-md fa-fw mr-2"></i><?= $enregistrement ?>.<br>
                        Veuillez cliquer <a href="etudiant.php?id=<?=@$rep_etu[0]?>" title="Ajouter un parcours">ici</a> pour inscrire cet étudiant dans un parcours de votre choix <br>sans toutefois modifier ou supprimer les parcours dans lesquels l'étudiant est déja inscrit.</span>
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
?>
