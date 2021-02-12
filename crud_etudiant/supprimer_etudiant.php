<?php
//Suppression
if (isset($_POST['supprimer'])) {
    if (!empty($_POST["cocher"])) {
        foreach ($_POST["cocher"] as $c) {
            $code_et = $c;
            $insertEt =new etudiant($code_et,'','','','',''
                ,'','','','','','',$bdd);
            $suppression = $insertEt->suppression();
        }
        ?>
        <div><span class="form-text text-success font-weight-bold"><i
                        class="fas fa-check-square fa-md fa-fw mr-2"></i>Informations supprimé avec succès .</span>
        </div>
        <?php
    }
}
?>