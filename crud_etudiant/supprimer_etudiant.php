<?php
//Suppression
if (isset($_POST['supprimer'])) {
    if (!empty($_POST["cocher"])) {
        foreach ($_POST["cocher"] as $c) {
            $numero_carte = $c;
            $insertEt = new etudiant($numero_carte, "", "", "", "", "", "", "", "", "", $bdd);
            $suppression = $insertEt->suppression();
        }
        ?>
        <div>
                            <span id="" class="form-text text-success font-weight-bold">
                                <i class="fas fa-fa-check-square fa-md fa-fw mr-2"></i>
                                Informations supprimées avec succès .
                            </span>
        </div>
        <?php
    }
}
?>