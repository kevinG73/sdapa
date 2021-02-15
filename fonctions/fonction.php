<?php
function fetchNationalite(){
    global $bdd;
    $requete = "SELECT *
    FROM nationalite";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}

function fetchSexe(){
    global $bdd;
    $requete = "SELECT *
    FROM sexe";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}

function fetchAnne()
{
    global $bdd;
    $requete = "SELECT *
    FROM annee_academique where id_annee_academique = 4";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }


}
function fetchTypeIns()
{
    global $bdd;
    $requete = "SELECT *
    FROM type_inscription where id_type_inscription = 2";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }


}


function fetchTotalMention($id)
{
    global $bdd;
    $requete = "SELECT *
    FROM total_mentions where id_etudiant = '".$id."' ORDER BY id_niveau asc";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }


}

function fetchFil()
{
    global $bdd;
    $requete = "select * from filiere where id_filiere = 1";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }


}

function fetchEt(){
    global $bdd;
    $requete = "select * from etablissement where afficher = 'OUI' and id_type_etablissement = 1 and id_etablissement <> 8 and id_etablissement <> 48 and id_etablissement <> 5 and id_etablissement <> 6 and id_etablissement <> 47 and id_etablissement <> 46 and id_etablissement <> 14 and id_etablissement <> 15 and id_etablissement <> 49 and id_etablissement <> 7 and id_etablissement <> 16  order by id_etablissement asc ";

    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}
function fetchNiv(){
    global $bdd;
    $requete = "select * from niveau where id_niveau = 1 or id_niveau = 2 or id_niveau = 3 ";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}
function fetchTypeDemande(){
    global $bdd;
    $requete = "select * from type_formulaire where id_type_formulaire = 17 or id_type_formulaire = 49 or id_type_formulaire = 50";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}
function fetchStatutDemande(){
    global $bdd;
    $requete = "select * from statut_demande";
    $resultat = $bdd->query($requete);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }
}

function fetchDemandes(
    $id_annee_academique
    ,$id_type_inscription
    ,$id_etablissement
    ,$id_departement
    ,$id_specialite
    ,$id_filiere
    ,$id_niveau
    ,$id_tpye_formulaire
    ,$id_statut_demande
    )
{
    if ($id_annee_academique == ""){
        $id_annee_academique = null;
    }
    if ($id_type_inscription == ""){
        $id_type_inscription = null;
    }
    if ($id_etablissement == ""){
        $id_etablissement = null;
    }

    if ($id_departement == ""){
        $id_departement = null;
    }

    if ($id_specialite == ""){
        $id_specialite = null;
    }

    if ($id_filiere == ""){
        $id_filiere = null;
    }

    if ($id_niveau == ""){
        $id_niveau = null;
    }

    if ($id_tpye_formulaire == ""){
        $id_tpye_formulaire = null;
    }

    if ($id_statut_demande == ""){
        $id_statut_demande = null;
    }

    global $bdd;
    /*
    $requete1 = "select * from demandes
            ,statut_demande,type_formulaire,departement,etablissement,annee_academique,type_inscription,specialite,filiere,niveau
where demandes.id_annee_academique = '".$id_annee_academique."'
and demandes.id_type_formulaire = '".$id_tpye_formulaire."'
and demandes.id_etablissement = '".$id_etablissement."'
and demandes.id_departement = '".$id_departement."'
and demandes.id_niveau= '".$id_niveau."'
and demandes.id_type_inscription = '".$id_type_inscription."'
and demandes.id_statut_demande = '".$id_statut_demande."' 
and demandes.id_filiere ='".$id_filiere."'
and demandes.id_specialite = '".$id_specialite."' 
and demandes.id_specialite = specialite.id_specialite
and demandes.id_statut_demande = statut_demande.id_statut_demande
and demandes.id_type_formulaire = type_formulaire.id_type_formulaire
and demandes.id_departement = departement.id_departement
and demandes.id_etablissement = etablissement.id_etablissement
and demandes.id_annee_academique = annee_academique.id_annee_academique
and demandes.id_type_inscription = type_inscription.id_type_inscription
and demandes.id_filiere = filiere.id_filiere
and demandes.id_niveau = niveau.id_niveau
group by id_demande";
    */


    $requete1 = " 
    select * from demandes
left join statut_demande sd on demandes.id_statut_demande = sd.id_statut_demande
left join type_formulaire tf on demandes.id_type_formulaire = tf.id_type_formulaire
left join departement d on demandes.id_departement = d.id_departement
left join etablissement e on demandes.id_etablissement = e.id_etablissement
left join annee_academique aa on demandes.id_annee_academique = aa.id_annee_academique
left join type_inscription ti on demandes.id_type_inscription = ti.id_type_inscription
left join specialite s on demandes.id_specialite = s.id_specialite
left join filiere f on demandes.id_filiere = f.id_filiere
left join niveau n on demandes.id_niveau = n.id_niveau
where demandes.id_annee_academique = '".$id_annee_academique."'
and demandes.id_type_formulaire = '".$id_tpye_formulaire."'
and demandes.id_etablissement = '".$id_etablissement."'
and demandes.id_departement = '".$id_departement."'
and demandes.id_niveau= '".$id_niveau."'
and demandes.id_type_inscription = '".$id_type_inscription."'
and demandes.id_statut_demande = '".$id_statut_demande."' 
and demandes.id_filiere ='".$id_filiere."'
and demandes.id_specialite = '".$id_specialite."' 
group by id_demande    
";

    $resultat = $bdd->query($requete1);
    if (is_bool($resultat)) {
        return [];
    } else {
        return $resultat->fetchAll();
    }

}


?>
