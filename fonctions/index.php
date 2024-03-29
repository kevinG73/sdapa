<?php
include_once "search.php";

/***
 * Déterminer le status sur le pv en fonction du paramètre suivant
 * @param $numerocarte
 * @return array
 */
function ListeEtudiants()
{
    global $bdd;
    $requete = "SELECT * FROM inscriptions";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}


/***
 * moyenne d'un étudiant
 * @param $etud
 * @param $sem
 * @return mixed|string[]
 */
function infoEtudiant($numero)
{
    global $bdd;
    $SQL = "SELECT 	*  FROM etudiant_sdapa etd 
    JOIN inscription_sdapa ins ON etd.id = ins.id_etudiant 
    JOIN nationalite nat ON nat.id_nationalite = etd.nationalite
    WHERE ins.id = $numero";
    $resultat = $bdd->query($SQL);
    if (is_bool($resultat)) {
        return array();
    }
    return $resultat->fetch();
}

function calculAge($date)
{
    $decoupage = explode('-', $date);
    $annee = $decoupage[0];
    $age = (int)date('Y') - $annee;
    return $age;
}

function ListeAnnee()
{
    global $bdd;
    $requete = "SELECT * FROM annee_academique order by id_annee_academique desc";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

function ListeAnneeAnter()
{
    global $bdd;
    $requete = "SELECT * FROM annee_academique order by id_annee_academique asc";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

function ListePays()
{
    global $bdd;
    $requete = "SELECT * FROM pays";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

function ListeDiplome()
{
    global $bdd;
    $requete = "SELECT * FROM diplomes";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}


function DeterminerAnnee($id)
{
    global $bdd;
    $requete = "SELECT libelle_annee_academique FROM annee_academique WHERE id_annee_academique = $id";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchColumn();
    }
}


function DeterminerEtablissement($id)
{
    global $bdd;
    $requete = "SELECT nom_etablissement FROM etablissement WHERE id_etablissement = $id";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchColumn();
    }
}


function DeterminerDepartement($id)
{
    global $bdd;
    $requete = "SELECT nom_departement FROM departement WHERE id_departement = $id";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchColumn();
    }
}


function DeterminerParcours($id)
{
    global $bdd;
    $requete = "SELECT 	libelle_specialite FROM specialite_sdapa WHERE id_specialite = $id";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchColumn();
    }
}

function DeterminerMention($id)
{
    global $bdd;
    $requete = "SELECT libelle_mention FROM mention WHERE id_departement = $id";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchColumn();
    }
}

/***
 * permet d'afficher les caractères special normalement
 * @param $string
 * @return string
 */
function convert_accent($string)
{
    return $string;
}