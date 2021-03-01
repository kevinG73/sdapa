<?php
/***
 * @param $id_etablissement
 * @param $id_specialite
 * @param $id_annee
 */
function creerDeliberation($type_critere, $min_pt_critere, $id_etablissement, $id_departement, $id_parcours, $statut, $id_annee)
{
    global $bdd;
    $requete = "INSERT INTO deliberation_sdapa SET type_deliberation = $type_critere , min_point_critere = $min_pt_critere,
    id_etablissement = '$id_etablissement', id_departement = $id_departement , id_parcours = $id_parcours, statut = $statut,  id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * @param $min_pt_critere
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_annee
 */
function majDeliberation($min_pt_critere, $id_etablissement, $id_departement, $id_parcours, $statut, $id_annee)
{
    global $bdd;
    $requete = "UPDATE deliberation_sdapa SET  min_point_critere= $min_pt_critere , statut = $statut  WHERE 
    id_etablissement = '$id_etablissement' AND id_departement = $id_departement AND id_parcours = $id_parcours AND id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * terminer deliberation tout parcours confondu
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_annee
 */
function termineDeliberation($id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "UPDATE deliberation_sdapa SET  statut = 1  WHERE 
    id_etablissement = '$id_etablissement' AND id_departement = $id_departement AND id_parcours = '0' AND id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * @param $id_etablissement
 * @param $id_specialite
 * @param $id_annee
 */
function supprimerDeliberation($type_deliberation, $id_etablissement, $id_departement, $id_annee)
{
    global $bdd;
    $requete = "DELETE FROM deliberation_sdapa WHERE type_deliberation = $type_deliberation	 AND id_etablissement = '$id_etablissement' AND id_departement = '$id_departement' AND id_annee = '$id_annee'";
    $bdd->query($requete);
}

/***
 * @param $id_etablissement
 * @param $id_specialite
 * @param $id_annee
 */
function resetDeliberation($id_etablissement, $id_departement, $id_parcours, $id_annee)
{
    global $bdd;
    $requete = "UPDATE deliberation_sdapa SET  statut = 0 WHERE 
    id_etablissement = '$id_etablissement' AND id_departement = '$id_departement' AND id_parcours <> '$id_parcours' AND id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * verifier si il y la deliberation est terminé
 * status : 0 - en cours
 * status : 1 - terminée
 * @return int
 */
function verifierDeliberation($type_deliberation, $id_etablissement, $id_departement, $id_parcours, $id_annee)
{
    global $bdd;
    $requete = "SELECT count(*) FROM deliberation_sdapa WHERE  id_etablissement = '$id_etablissement' AND id_departement = $id_departement 
    AND type_deliberation = '$type_deliberation' AND id_parcours = $id_parcours AND id_annee = '$id_annee'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}

/***
 * verifier si il y a une deliberation en cours
 * status : 0 - en cours
 * status : 1 - terminée
 * @return int
 */
function verifierDeliberationC($type_deliberation, $id_etablissement, $id_departement, $id_parcours, $id_annee)
{
    global $bdd;
    $requete = "SELECT count(*) FROM deliberation_sdapa WHERE  id_etablissement = '$id_etablissement' AND id_departement = $id_departement 
    AND type_deliberation = '$type_deliberation' AND id_parcours = $id_parcours AND statut = 0 AND id_annee = '$id_annee'";
    $resultat = $bdd->query($requete);
    return $resultat->fetchColumn();
}

/***
 * verifier si il y la deliberation est terminé
 * status : 0 - en cours
 * status : 1 - terminée
 * @return int
 */
function verifierDeliberationT($type_deliberation, $id_etablissement, $id_departement, $id_parcours, $id_annee)
{
    global $bdd;
    $requete = "SELECT count(*) FROM deliberation_sdapa WHERE  id_etablissement = '$id_etablissement' AND id_departement = $id_departement 
    AND type_deliberation = '$type_deliberation' AND id_parcours = $id_parcours AND statut = 1 AND id_annee = '$id_annee'";
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
                WHERE type_deliberation = '2' AND ins.id_etablissement = '$id_etablissement' AND ins.id_departement = '$id_departement' 
                AND annee = '$id_annee' AND total_point_critere	> min_point_critere";

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
        return 0;
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