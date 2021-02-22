<?php
/***
 * @param $id_etablissement
 * @param $id_specialite
 * @param $id_annee
 */
function creerDeliberation($min_pt_critere, $id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "INSERT INTO deliberation_sdapa SET type_deliberation = 1 , min_point_critere = $min_pt_critere,
    id_etablissement = '$id_etablissement', id_departement = $id_departement , id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * @param $min_pt_critere
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_annee
 */
function majDeliberation($min_pt_critere, $id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "UPDATE deliberation_sdapa SET  min_point_critere= $min_pt_critere WHERE 
    id_etablissement = '$id_etablissement' AND id_departement = $id_departement AND id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * @param $id_etablissement
 * @param $id_specialite
 * @param $id_annee
 */
function supprimerDeliberation($id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "DELETE FROM deliberation_sdapa WHERE id_etablissement = '$id_etablissement' AND id_departement = '$id_departement' AND id_annee = '$id_annee'";
    $bdd->query($requete);

    $requete = "UPDATE inscription_sdapa SET statut_inscription	= 2 WHERE statut_inscription = 0  AND id_etablissement = '$id_etablissement' AND id_departement = '$id_departement' AND annee = '$id_annee'";
    $bdd->query($requete);
}

/***
 * Liste des parcours selectionnés par un étudiant
 * @return array
 */
function verifierDeliberation($id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "SELECT count(*) FROM deliberation_sdapa WHERE  id_etablissement = '$id_etablissement' AND id_departement = $id_departement AND id_annee = '$id_annee'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}


/***
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_annee
 * @return array
 */
function ListeEtudiantOrientation($id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "SELECT etd.id id , nom, prenoms , moy_pondere , total_mention , total_point_critere  , statut	
                FROM etudiant_sdapa etd 
                JOIN inscription_sdapa ins ON etd.id = ins.id_etudiant
                JOIN deliberation_sdapa dl ON dl.id_etablissement = ins.id_etablissement
                WHERE ins.id_etablissement = $id_etablissement AND ins.id_departement = $id_departement AND annee = $id_annee
                AND total_point_critere	> min_point_critere";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

/****
 *
 */
function parcoursAffecte($id_etudiant)
{
    global $bdd;
    $requete = "SELECT libelle_specialite FROM inscription_sdapa p JOIN specialite s ON s.id_specialite = p.id_parcours 
    WHERE id_etudiant	= '$id_etudiant'";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchColumn();
    }
}


function affecterAparcours($id_etudiant, $id_parcours)
{
    global $bdd;
    $requete = "UPDATE inscription_sdapa SET  statut_inscription = 1 , id_parcours = '$id_parcours'  WHERE  id_etudiant	= '$id_etudiant'";
    $bdd->query($requete);
}