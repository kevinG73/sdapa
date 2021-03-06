<?php

function EtudiantFiltre($annee, $id_parcours, $id_departement)
{
    global $bdd;
    $requete = "select * from inscriptions where annee = $annee AND id_parcours = $id_parcours AND id_departement = $id_departement";
    $resultat = $bdd->query($requete);

    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

/***
 * Etablissements
 * @return array
 */
function ListeEtablissements()
{
    global $bdd;
    $requete = "select * from etablissement where afficher = 'OUI' and id_type_etablissement = 1 and id_etablissement <> 48  and id_etablissement <> 47 and id_etablissement <> 46 and id_etablissement <> 14 and id_etablissement <> 15 and id_etablissement <> 49  and id_etablissement <> 16 order by id_etablissement asc";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

/***
 * @return array
 */
function ListeParcoursDepartement($id_departement)
{
    global $bdd;
    $requete = "SELECT specialite_sdapa.id_specialite ,specialite_sdapa.libelle_specialite 
                FROM specialite_sdapa,composer_maquette,mention,semestre
                where
                specialite_sdapa.id_specialite = composer_maquette.id_specialite
                and specialite_sdapa.id_mention = mention.id_mention
                and composer_maquette.id_semestre = semestre.id_semestre
                and semestre.id_niveau = 4 and mention.id_departement = '" . $id_departement . "'
                and specialite_sdapa.id_specialite not in (63,64,65,66,67,319)
                group by specialite_sdapa.id_specialite";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

function ListeEtablissementsSession($id)
{
    global $bdd;
    $requete = "select * from etablissement where id_etablissement = '" . $id . "'";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}

/***
 * Info sur un etablissement
 * @param $id_etablissement
 * @return mixed
 */
function InfoEtablissement($id_etablissement)
{
    global $bdd;
    $id_etablissement = (int)$id_etablissement;
    $requete = "SELECT * FROM etablissement  WHERE id_etablissement = $id_etablissement";
    $resultat = $bdd->query($requete);
    return $resultat->fetch();
}

/***
 * Info sur les parcours
 * @param null $id
 * @return array
 */
function InfoParcours($id = null)
{
    global $bdd;
    $id = (int)$id;
    $requete = "SELECT * FROM specialite_sdapa";
    if (!empty($id) && !is_null($id)) {
        $requete .= " WHERE id_specialite = $id";
    }
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}


/**
 * Info sur une mention
 * @param $id_mention
 * @return array|mixed
 */
function InfoMention($id_mention)
{
    global $bdd;
    $id_mention = (int)$id_mention;
    $requete = "SELECT * FROM mention WHERE id_mention = $id_mention";
    $resultat = $bdd->query($requete);

    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetch();
    }

}


/**
 * info sur un departement
 * @return array
 */
function InfoDepartement($id_etablissement = null)
{
    global $bdd;
    $id_etablissement = (int)$id_etablissement;
    $requete = "SELECT * FROM departement";
    if (!is_null($id_etablissement) && !empty($id_etablissement)) {
        $requete .= " WHERE id_departement = $id_etablissement";
    }

    $resultat = $bdd->query($requete);

    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetch();
    }
}