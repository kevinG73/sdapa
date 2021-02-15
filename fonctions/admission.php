<?php

/***
 * Liste des admis
 * @return array
 */
function ListeAdmis($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "select * from etudiant_sdapa  etd JOIN  inscription_sdapa ins 
                ON etd.id = ins.id_etudiant
                WHERE annee = $annee AND demande_accepte = 1 AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND id_parcours = $id_parcours	
                ORDER BY total_point_critere DESC";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}


function AppliquerCritere($annee, $id_etablissement, $id_departement, $id_parcours, $point)
{
    global $bdd;
    $requete = "UPDATE inscription_sdapa SET demande_accepte = 1 , id_parcours = $id_parcours	
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement AND total_point_critere	> $point";
    $resultat = $bdd->query($requete);

    $requete = "UPDATE inscription_sdapa SET demande_accepte = 0 , id_parcours = $id_parcours	
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement AND total_point_critere	<= $point";
    $resultat = $bdd->query($requete);
}


function verifierPointCritere($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "SELECT * FROM inscription_sdapa 	
                WHERE total_point_critere = 0 AND annee = $annee 
                AND id_etablissement = $id_etablissement AND id_departement = $id_departement AND id_parcours = $id_parcours";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}
