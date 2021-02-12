<?php

/**
 *
 */
class inscription
{
    private $id;
    private $annee;

    private $numero_carte;
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


    public function __construct($id, $annee, $numero_carte, $temps_mis_en_licence, $moy_ann_l1, $moy_ann_l2, $moy_ann_l3, $total_point_critere, $niveau_etude, $id_parcours, $id_departement, $id_etablissement, $bdd)
    {
        $this->id = $id;
        $this->annee = $annee;
        $this->numero_carte = trim($numero_carte);
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

        $requete = $this->bdd->query('INSERT INTO  inscriptions (annee,numero_carte,temps_mis_en_licence,moy_ann_l1,moy_ann_l2,moy_ann_l3,total_point_critere, niveau_etude,id_parcours,id_departement,id_etablissement) VALUES ("' . $this->annee . '","' . $this->numero_carte . '","' . $this->temps_mis_en_licence . '","' . $this->moy_ann_l1 . '","' . $this->moy_ann_l2 . '","' . $this->moy_ann_l3 . '","' . $this->total_point_critere . '","' . $this->niveau_etude . '","' . $this->id_parcours . '","' . $this->id_departement . '","' . $this->id_etablissement . '")') or die(print_r($this->bdd->errorInfo()));


        return 1;


    }


    public function modification()
    {


    }


    public function suppression()
    {


        return 1;


    }


}