<?php
session_start();
unset($_SESSION['annee']);
unset($_SESSION['id_etablissement']);
unset($_SESSION['id_parcours']);
unset($_SESSION['id_departement']);

?>
<script>
    document.location.replace('etudiant.php')
</script>
