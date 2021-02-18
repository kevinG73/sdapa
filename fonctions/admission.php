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
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

/**
 * @param $annee
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_parcours
 * @param $point
 */
function AppliquerCritere($annee, $id_etablissement, $id_departement, $id_parcours, $point)
{
    global $bdd;
    /* on donne 1 à tous les candidats qui ne respectent par ce poit critère */
    $requete = "UPDATE inscription_sdapa SET demande_accepte = 1 
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND id_parcours = $id_parcours
                AND total_point_critere	> $point";
    $resultat = $bdd->query($requete);

    /* on donne0 à tous les candidats qui ne respectent par ce poit critère */
    $requete = "UPDATE inscription_sdapa SET demande_accepte = 0 
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND id_parcours = $id_parcours
                AND total_point_critere	<= $point";
    $resultat = $bdd->query($requete);
}

/***
 * @param $annee
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_parcours
 * @return array
 */
function verifierSiCalculTerminee($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "SELECT count(*) FROM inscription_sdapa 	
                WHERE total_point_critere <> 0 AND annee = $annee 
                AND id_etablissement = $id_etablissement AND id_departement = $id_departement AND id_parcours = $id_parcours";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}


function totalEtudiantParcours($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "SELECT count(*) FROM inscription_sdapa 	
                WHERE  annee = $annee AND id_etablissement = $id_etablissement 
                AND id_departement = $id_departement AND id_parcours = $id_parcours";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}
