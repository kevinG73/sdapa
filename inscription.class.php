<?php

/**
 *
 */
class inscription
{
    private $id;
    private $annee;

    private $id_etudiant;
    private $temps_mis_en_licence;
    private $moy_ann_l1;
    private $moy_ann_l2;
    private $moy_ann_l3;
    private $total_point_critere;
    private $niveau_etude;

    private $id_parcours;
    private $id_departement;
    private $id_etablissement;

    private $bdd;


    public function __construct($annee, $id_etudiant, $temps_mis_en_licence,
                                $moy_ann_l1, $moy_ann_l2, $moy_ann_l3, $total_point_critere,
                                $niveau_etude, $id_parcours, $id_departement, $id_etablissement, $bdd)
    {
        $this->annee = $annee;
        $this->id_etudiant = trim($id_etudiant);
        $this->temps_mis_en_licence = trim($temps_mis_en_licence);
        $this->moy_ann_l1 = $moy_ann_l1;
        $this->moy_ann_l2 = $moy_ann_l2;
        $this->moy_ann_l3 = trim($moy_ann_l3);
        $this->total_point_critere = $total_point_critere;
        $this->niveau_etude = $niveau_etude;
        $this->id_parcours = $id_parcours;
        $this->id_departement = $id_departement;
        $this->id_etablissement = $id_etablissement;



        $this->bdd = $bdd;
    }


    public function verification()
    {


        return 1;

    }

    public function enregistrement()
    {


        $requete = $this->bdd->query('INSERT INTO  inscription_sdapa (annee,id_etudiant,temps_mis_en_Licence,moy_ann_l1,moy_ann_l2,moy_ann_l3,total_point_critere, niveau_etude,id_parcours,id_departement,id_etablissement) VALUES ("'.$this->annee .'","'.$this->id_etudiant.'","'.$this->temps_mis_en_licence.'","'.$this->moy_ann_l1.'","'.$this->moy_ann_l2.'","'.$this->moy_ann_l3.'","'.$this->total_point_critere.'","'.$this->niveau_etude.'","'.$this->id_parcours.'","'.$this->id_departement.'","'.$this->id_etablissement.'")')or die(print_r($this->bdd->errorInfo()));

        return 1;


    }


    public function modification()
    {
        $requete = $this->bdd->prepare('UPDATE inscription_sdapa SET  annee=:annee,
           
            id_parcours=:id_parcours,        
            id_etablissement=:id_etablissement,
            id_departement=:id_departement WHERE id_etudiant=:id_etudiant');
        $requete->execute(array(

            'id_parcours'=>  $this->id_parcours,
            'annee'=>  $this->annee,
            'id_etudiant'=>  $this->id_etudiant,
            'id_departement'=> $this->id_departement,
            'id_etablissement'=>  $this->id_etablissement
        ));


    }


    public function suppression()
    {


        return 1;


    }


}
