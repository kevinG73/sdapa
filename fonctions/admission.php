<?php

/***
 * Liste des admis
 * @return array
 */
function ListeAdmis($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "select * from etudiant_sdapa  etd 
                JOIN  inscription_sdapa ins ON etd.id = ins.id_etudiant
                WHERE annee = $annee  AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND id_parcours = $id_parcours	 AND statut_inscription = 1
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
    $requete = "UPDATE inscription_sdapa SET statut_inscription = 1 
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND id_parcours = $id_parcours
                AND total_point_critere	> $point";
    $bdd->query($requete);

    /* on donne 2 à tous les candidats qui ne respectent par ce poit critère */
    $requete = "UPDATE inscription_sdapa SET statut_inscription = 2 
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND id_parcours = $id_parcours
                AND total_point_critere	<= $point";
    $bdd->query($requete);
}

/**
 * @param $annee
 * @param $id_etablissement
 * @param $id_departement
 */
function resetCritere($annee, $id_etablissement, $id_departement)
{
    global $bdd;
    /* on donne 1 à tous les candidats qui ne respectent par ce poit critère */
    $requete = "UPDATE inscription_sdapa SET statut_inscription = 0 
                WHERE annee = '$annee' AND id_etablissement = '$id_etablissement' AND id_departement = '$id_departement'";
    $bdd->query($requete);
}

/***
 * @param $annee
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_parcours
 * @return string
 */
function TotalEtudiantEvalue($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "SELECT count(*) FROM inscription_sdapa 	ins
                JOIN  parcours_sdapa p ON p.id_etudiant = ins.id_etudiant
                WHERE total_point_critere <> 0 AND annee = '$annee' 
                AND id_etablissement = '$id_etablissement' AND id_departement = '$id_departement' AND p.id_parcours = '$id_parcours'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}


function TotalEtudiantParcours($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "SELECT count(*) FROM inscription_sdapa 	ins
                JOIN  parcours_sdapa p ON p.id_etudiant = ins.id_etudiant
                WHERE  annee = '$annee' AND id_etablissement = '$id_etablissement'
                AND id_departement = '$id_departement' AND p.id_parcours = '$id_parcours'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}
