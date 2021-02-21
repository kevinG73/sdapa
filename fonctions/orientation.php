<?php

/***
 * Liste des parcours selectionnés par un étudiant
 * @return array
 */
function ListeParcoursSelectionne($id_etudiant)
{
    global $bdd;
    $requete = "select * from parcours_sdapa p JOIN  specialite s 
                ON p.id_parcours = s.id_specialite
                WHERE id_etudiant = '$id_etudiant'";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return array();
    } else {
        return $resultat->fetchAll();
    }
}
