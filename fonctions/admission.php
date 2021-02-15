<?php

/***
 * Liste des admis
 * @return array
 */
function ListeAdmis($annee, $id_etablissement, $id_departement)
{
    global $bdd;
    $requete = "select * from etudiant_sdapa  etd JOIN  inscription_sdapa ins 
                ON etd.id = ins.id_etudiant
                WHERE annee = $annee AND demande_accepte = 2 AND id_etablissement = $id_etablissement AND id_departement = $id_departement ORDER BY id_etablissement ASC";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}


