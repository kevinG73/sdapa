<?php
session_start();
$_SESSION['connecte'] = "";
$_SESSION['annee'] = "";
$_SESSION['id_etablissement'] = "";
$_SESSION['id_parcours'] = "";
$_SESSION['id_departement'] = "";
$_SESSION['id_type_utilisateur '] = "";

if (session_destroy()) {
    header("Location: login.php");
}
?>