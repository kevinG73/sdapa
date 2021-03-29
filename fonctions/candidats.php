<?php

/***
 * Liste des candidats
 * @return array
 */
function ListeCandidats($annee, $id_etablissement, $id_departement)
{
    global $bdd;
    $requete = "select 
                 etd.nom , etd.prenoms , etd.date_naissance , etd.lieu_naissance , etd.telephone , ins.moy_pondere, ins.temps_mis_en_Licence ,
                 ins.total_mention , ins.total_point_critere,
                 GROUP_CONCAT(sp.libelle_specialite) as specialites
                from etudiant_sdapa  etd 
                JOIN  inscription_sdapa ins ON etd.id = ins.id_etudiant
                JOIN parcours_sdapa p ON p.id_etudiant = etd.id
                JOIN specialite_sdapa sp ON sp.id_specialite = p.id_parcours
                WHERE annee = $annee  AND ins.id_etablissement = $id_etablissement AND ins.id_departement = $id_departement 
                GROUP BY etd.id , etd.nom , etd.prenoms , etd.date_naissance , etd.lieu_naissance , etd.telephone , ins.moy_pondere, ins.temps_mis_en_Licence ,
                 ins.total_mention , ins.total_point_critere
                ";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}
