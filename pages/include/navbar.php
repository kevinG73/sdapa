<?php

$info = $bdd->query('select * from utilisateur where id_utilisateur ="' . $_SESSION['connecte'] . '" ');
$information = $info->fetch();
if ($_SESSION['id_type_utilisateur '] == 1) {

} else {
    if ($_SESSION['id_groupe_utilisateur'] == 14){
        $nom_etablissement = $bdd->query("SELECT nom_etablissement FROM etablissement WHERE id_etablissement = '" . $_SESSION['id_etablissement'] . "'")->fetchColumn();
        $nom_departement = $bdd->query("SELECT nom_departement FROM departement WHERE id_departement = '" . $_SESSION['id_departement_grand'] . "'")->fetchColumn();
    }else{
        $nom_etablissement = $bdd->query("SELECT nom_etablissement FROM etablissement WHERE id_etablissement = '" . $_SESSION['id_etablissement'] . "'")->fetchColumn();
        $nom_departement = $bdd->query("SELECT nom_departement FROM departement WHERE id_departement = '" . $_SESSION['id_departement'] . "'")->fetchColumn();
    }
}


?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <br>
    <div class="col-md-5">
        <p class="mb-3"><h6 class="text-uppercase">NOM ET PRENOMS
            : <?= $information['nom_utilisateur'] . ' ' . $information['prenom_utilisateur'] ?></h6></p>
        <?php

        ?>
        <p class="mb-3"><h6 class="text-uppercase">UFR : <?php echo @$nom_etablissement ?></h6></p>
    </div>

    <div class="col-md-5">
        <p class="mb-5"> <h6 class="text-uppercase">UNITE DE FORMATION : <?php echo @$nom_departement ?></h6></p>

    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item  no-arrow">
            <a class="nav-link" href="logout.php">
                <span class="mr-2 d-none d-lg-inline text-primary font-weight-bold text-uppercase small">Deconnexion</span>
            </a>
        </li>

    </ul>

</nav>
