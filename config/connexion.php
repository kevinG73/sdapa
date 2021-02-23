<?php
try
{
    $bdd = new PDO('mysql:host=localhost; dbname=sdapa; charset=utf8', 'root', '');
} catch (Exception $e) {
    //die('Erreur : ' . $e->getMessage());
    echo $e->getMessage();
}
?>
