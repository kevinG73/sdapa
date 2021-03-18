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
                JOIN parcours_sdapa p ON p.id_etudiant = etd.id 
                WHERE annee = $annee  AND ins.id_etablissement = $id_etablissement AND ins.id_departement = $id_departement 
                AND p.id_parcours IN($id_parcours)  AND  ins.annee = $annee 
                ORDER BY total_point_critere DESC";

    $resultat = $bdd->query($requete);

    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}
