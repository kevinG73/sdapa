<?php

/***
 * Liste des admis
 * @return array
 */
function ListeProvisoireAdmis($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $id_parcours = implode(',', $id_parcours);

    $requete = "select * from etudiant_sdapa  etd 
                JOIN  inscription_sdapa ins ON etd.id = ins.id_etudiant
                JOIN admis_provisoire_sdap ap ON ap.id_etudiant = etd.id 
                WHERE annee = $annee  AND ap.id_etablissement = $id_etablissement AND ap.id_departement = $id_departement 
                AND ap.id_parcours IN($id_parcours)  AND  ap.id_annee = $annee AND ap.id_parcours = $id_parcours
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
function AppliquerCritereAP($annee, $id_etablissement, $id_departement, $id_parcours, $point)
{
    global $bdd;
    $id_parcours = implode(',', $id_parcours);

    $requete = "SELECT annee as id_annee, ins.id_etablissement ,ins.id_departement, p.id_parcours , ins.id_etudiant 
                FROM inscription_sdapa ins 
                JOIN parcours_sdapa p ON ins.id_etudiant = p.id_etudiant
                WHERE p.id_parcours IN ($id_parcours) AND ins.annee = $annee AND ins.id_etablissement = $id_etablissement 
                AND ins.id_departement = $id_departement  AND total_point_critere > $point";
    $resultat = $bdd->query($requete);
    $liste = array();
    if (!is_bool($resultat)) {
        $liste = $resultat->fetchAll();
    }

    foreach ($liste as $li) {
        $id_annee = $li['id_annee'];
        $id_etablissement = $li['id_etablissement'];
        $id_departement = $li['id_departement'];
        $id_etudiant = $li['id_etudiant'];

        $requete = "INSERT INTO admis_provisoire_sdap SET id_annee = $id_annee , id_etablissement = $id_etablissement ,
        id_parcours = $id_parcours , id_departement = $id_departement , id_etudiant = '$id_etudiant'";
        $bdd->query($requete) or die(print_r($bdd->errorInfo()));
    }
}

/**
 * @param $annee
 * @param $id_etablissement
 * @param $id_departement
 */
function resetCritereAP($annee, $id_etablissement, $id_departement)
{
    global $bdd;
    /* on donne 1 à tous les candidats qui ne respectent par ce poit critère */
    $requete = "DELETE FROM admis_provisoire_sdap WHERE id_annee = $annee AND id_etablissement = $id_etablissement AND id_departement = $id_departement";
    $bdd->query($requete);
}