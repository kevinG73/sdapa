<?php
try
{
    $bdd = new PDO('mysql:host=localhost; dbname=sygeufhb_syge; charset=utf8', 'root', '1234');
} catch (Exception $e) {
    //die('Erreur : ' . $e->getMessage());
    echo $e->getMessage();
}
?>
