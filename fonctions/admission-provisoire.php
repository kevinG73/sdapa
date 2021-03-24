<?php
/***
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_parcours
 * @param $min_pt_critere
 * @param $id_annee
 */
function creerAdmissionProvisoire($id_etablissement, $id_departement, $id_parcours, $min_pt_critere, $id_annee)
{
    global $bdd;
    $code = $id_annee . $id_etablissement . $id_departement . $id_parcours;
    $requete = "INSERT INTO admis_provisoire SET id = $code , min_point_critere = $min_pt_critere,
    id_etablissement = '$id_etablissement', id_departement = $id_departement , id_parcours = $id_parcours, id_annee = '$id_annee'";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_parcours
 * @param $min_pt_critere
 * @param $id_annee
 */
function verifierAdmissionProvisoire($id_etablissement, $id_departement, $id_parcours, $id_annee)
{
    global $bdd;
    $code = $id_annee . $id_etablissement . $id_departement . $id_parcours;
    $requete = "SELECT count(*) as nb FROM admis_provisoire WHERE id = '$code'";
    $resultat = $bdd->query($requete);
    $data = $resultat->fetch();
    if (!is_bool($data)) {
        return $data['nb'];
    } else {
        return 0;
    }
}


/***
 * @param $id_etablissement
 * @param $id_departement
 * @param $id_parcours
 * @param $min_pt_critere
 * @param $id_annee
 */
function majAdmissionProvisoire($id_etablissement, $id_departement, $id_parcours, $min_pt_critere, $id_annee)
{
    global $bdd;
    $code = $id_annee . $id_etablissement . $id_departement . $id_parcours;
    $requete = "UPDATE admis_provisoire SET min_point_critere = $min_pt_critere,
    id_etablissement = '$id_etablissement', id_departement = $id_departement , id_parcours = $id_parcours, id_annee = '$id_annee' WHERE  id = $code";
    $bdd->query($requete) or die(print_r($bdd->errorInfo()));
}

/***
 * Liste des admis
 * @return array
 */
function ListeProvisoireAdmis($annee, $id_etablissement, $id_departement, $id_parcours)
{
    global $bdd;
    $requete = "select * from etudiant_sdapa  etd 
                JOIN  inscription_sdapa ins ON etd.id = ins.id_etudiant
                JOIN parcours_sdapa p ON p.id_etudiant = etd.id 
                JOIN admis_provisoire ap ON ap.id_parcours = p.id_parcours
                WHERE annee = $annee  AND ins.id_etablissement = $id_etablissement AND ins.id_departement = $id_departement 
                AND p.id_parcours = $id_parcours AND  ins.annee = $annee AND ap.id_annee = $annee AND total_point_critere > ap.min_point_critere  
                ORDER BY total_point_critere DESC";

    $resultat = $bdd->query($requete);
    $data = $resultat->fetchAll();
    if (is_bool($data)) {
        return array();
    } else {
        return $data;
    }
}
