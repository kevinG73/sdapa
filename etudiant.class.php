<?php

/**
 *
 */
class etudiant
{
    private $id;
    private $numero_carte;
    private $mesrs;
    private $nom;
    private $prenoms;
    private $date_naissance;
    private $lieu_naissance;
    private $sexe;
    private $nationalite;
    private $email;
    private $telephone;
    private $ufhb;

    private $bdd;


    public function __construct($id,$numero_carte,$mesrs,$nom,$prenoms,$date_naissance
        ,$lieu_naissance,$sexe,$nationalite,$email,$telephone,$ufhb,$bdd)
    {
        $this->id=$id;
        $this->numero_carte=$numero_carte;
        $this->mesrs=$mesrs;
        $this->nom=trim($nom);
        $this->prenoms=trim($prenoms);
        $this->date_naissance=$date_naissance;
        $this->lieu_naissance=$lieu_naissance;
        $this->sexe=trim($sexe);
        $this->nationalite=trim($nationalite);
        $this->email=$email;
        $this->telephone=$telephone;
        $this->ufhb=$ufhb;

        $this->bdd = $bdd;
    }


    public function verification()
    {

        if (strlen($this->nom)==0 || strlen($this->prenoms)==0 || strlen($this->date_naissance)==0 || strlen($this->lieu_naissance)==0 || strlen($this->email)==0 || strlen($this->telephone)==0  ) {
            $erreur='Veuillez remplir le(s) champ(s) vide(s)';
            return $erreur;
        }

        else
        {
            $syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
            if(preg_match($syntaxe,$this->email))
            { /*email bon*/
                if (strlen($this->telephone)!=10)
                {
                    $erreur='Le numero de téléphone doit contenir 10 chiffres';
                    return $erreur;

                }
                return 1;
            }
            else
            {
                $erreur='Le format de l\'email est incorrect';
                return  $erreur;
            }

        }
    }

    public function enregistrement()
    {
        $requete= $this->bdd->prepare('SELECT * FROM etudiant_sdapa WHERE numero_carte=:numero_carte AND ufhb=:ufhb ');
        $requete->execute(array('numero_carte'=>  $this->numero_carte,'ufhb'=>1
        ));
        $reponse=$requete->fetch();
        if ($reponse)
        {
            $erreur='ATTENTION ! Ce numero de carte d\'étudiant est déja utilisé';
            return $erreur;
        }
        else
        {
            $requete= $this->bdd->query('INSERT INTO  etudiant_sdapa (id,numero_carte,mesrs,nom,prenoms,date_naissance,lieu_naissance,sexe,nationalite,email,telephone,ufhb) VALUES ("'.$this->id.'","'.$this->numero_carte.'","'.$this->mesrs.'","'.$this->nom.'","'.$this->prenoms.'","'.$this->date_naissance.'","'.$this->lieu_naissance.'","'.$this->sexe.'","'.$this->nationalite.'","'.$this->email.'","'.$this->telephone.'","'.$this->ufhb.'")') or die(print_r($this->bdd->errorInfo()));

            return 1;
        }

    }





    public function modification()
    {
        $requete= $this->bdd->prepare('SELECT * FROM etudiant_sdapa WHERE numero_carte=:numero_carte AND ufhb=:ufhb ');
        $requete->execute(array('numero_carte'=>  $this->numero_carte,'ufhb'=>1
        ));
        $reponse=$requete->fetch();
        if ($reponse && $reponse['numero_carte']!=$this->numero_carte)
        {
            $erreur='Existant';
            return $erreur;
        }

        else
        {
            $requete = $this->bdd->prepare('UPDATE etudiant_sdapa SET  nom=:nom,
           
            numero_carte=:numero_carte,        
          prenoms=:prenoms,
          date_naissance=:date_naissance,
          lieu_naissance=:lieu_naissance,
          sexe=:sexe,
          nationalite=:nationalite,
          email=:email,
          telephone=:telephone
          WHERE id=:id ');
            $requete->execute(array(

                'numero_carte'=>  $this->numero_carte,
                'nom'=>  $this->nom,
                'id'=>  $this->id,
                'prenoms'=>  $this->prenoms,
                'date_naissance'=> $this->date_naissance,
                'lieu_naissance'=>  $this->lieu_naissance,
                'sexe'=>  $this->sexe,
                'nationalite'=>  $this->nationalite,
                'email'=>  $this->email,
                'telephone'=>  $this->telephone
            ));

            return 1;

        }


    }





    public function suppression()
    {


        $requete = $this->bdd->prepare('DELETE FROM etudiant_sdapa WHERE id=:id');

        $requete->execute(array(
            'id'=>  $this->id));

        $requete = $this->bdd->prepare('DELETE FROM inscriptions WHERE id_etudiant=:id');

        $requete->execute(array(
            'id'=>  $this->id));

        return 1;



    }


}
