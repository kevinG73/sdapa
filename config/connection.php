<?php
try
{
    $bdd = new PDO('mysql:host=localhost; dbname=sdapa; charset=utf8', 'root', '123456');
} catch (Exception $e) {
    //die('Erreur : ' . $e->getMessage());
    echo $e->getMessage();
}
?>
