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
    /* on donne 1 à tous les candidats qui respectent ce point critère */
    $requete = "UPDATE inscription_sdapa ins 
                JOIN parcours_sdapa p ON ins.id_etudiant = p.id_etudiant
                SET statut_inscription = 1  ,  p.demande_accepte = 1 , ins.id_parcours = $id_parcours         
                WHERE ins.id_parcours = 0 AND annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND p.id_parcours = $id_parcours AND total_point_critere > $point";
    $bdd->query($requete);

    /* on donne 0 à tous les autres id_parcours de la table parcours_sdapa */
    $requete = "SELECT p.id_parcours , p.id_etudiant FROM  inscription_sdapa   ins JOIN parcours_sdapa p ON ins.id_etudiant = p.id_etudiant
                WHERE annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement AND p.id_parcours = $id_parcours
                AND statut_inscription = 1 AND demande_accepte = 1";

    $resultat = $bdd->query($requete);
    $ins = array();
    if (is_bool($resultat)) {
        return $ins;
    } else {
        $ins = $resultat->fetchAll();
    }

    foreach ($ins as $re) {
        $id_etudiant = $re['id_etudiant'];
        $id_parcours = $re['id_parcours'];
        $requete = "UPDATE parcours_sdapa SET demande_accepte = 1 WHERE id_etudiant = '$id_etudiant' AND id_parcours <> '$id_parcours'";
        $bdd->query($requete);
    }

    /* on donne 2 à tous les candidats qui ne respectent par ce poit critère */
    $requete = "UPDATE inscription_sdapa ins
                JOIN parcours_sdapa p ON ins.id_etudiant = p.id_etudiant
                SET statut_inscription = 2 
                WHERE ins.id_parcours <> '0' AND annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement 
                AND p.id_parcours = $id_parcours AND total_point_critere <= $point";
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
    $requete = "UPDATE inscription_sdapa SET statut_inscription = 0 , id_parcours = 0 
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
