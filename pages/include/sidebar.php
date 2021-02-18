
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mt-5 mb-5" href="../">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-paperclip"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GESTION DES POINTS D'ADMISSIBILITÉ</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <?php
    if($_SESSION["id_type_utilisateur "] == 1 || $_SESSION['id_groupe_utilisateur'] == 19):
    ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="etudiant.php">
            <span>ETUDIANTS</span></a>
    </li>
    <?php
    endif;
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    if($_SESSION["id_type_utilisateur "] == 1 || $_SESSION['id_groupe_utilisateur'] == 19 || $_SESSION['id_groupe_utilisateur'] == 20 ):
    ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <span>CALCUL DU POINT CRITERE</span></a>
    </li>

    <?php
    endif;
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="info.php">
            <span>INFO</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php
    if($_SESSION["id_type_utilisateur "] == 1 || $_SESSION['id_groupe_utilisateur'] == 14 || $_SESSION['id_groupe_utilisateur'] == 20 ):
    ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="admis.php">
            <span>LISTE DES ADMIS</span></a>
    </li>
    <?php
    endif;
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>