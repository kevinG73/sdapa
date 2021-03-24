<?php

include '../fonctions/email/mail_function.php';

class utilisateur{

    //Definition des attributs de la classe

    private $id_utilisateur;
    private $tel_utilisateur;
    private $login_utilisateur;
    private $mot_passe_utilisateur;
    private $id_groupe_utilisateur;
    private $email_utilisateur;
    private $id_etablissement;
    private $id_departement;
    private $nom_utilisateur;
    private $prenom_utilisateur;



    // definition de la base de donnée
    private $bdd;

    // constructeur de la classe
    public function __construct($id_utilisateur, $tel_utilisateur,$login_utilisateur,$mot_passe_utilisateur,$id_groupe_utilisateur,$email_utilisateur,$id_departement, $id_etablissement, $nom_utilisateur, $prenom_utilisateur,$bdd)
    {



        //asignation des valeurs aux pointeurs des attributs ded la classe

        $this->login_utilisateur = trim($login_utilisateur);
        $this->mot_passe_utilisateur = trim($mot_passe_utilisateur);
        $this->id_departement = trim($id_departement);
        $this->id_utilisateur = trim($id_utilisateur);
        $this->id_groupe_utilisateur = trim($id_groupe_utilisateur);
        $this->email_utilisateur = trim($email_utilisateur);
        $this->id_etablissement = $id_etablissement;
        $this->nom_utilisateur = trim($nom_utilisateur);
        $this->prenom_utilisateur = trim($prenom_utilisateur);
        $this->tel_utilisateur = trim($tel_utilisateur);



        $this->bdd = $bdd;


    }



//Creation des methodes de la classe

    public function verification(){

        return 1;

    }


    public function enregistrement()
    {

           $sqlQuery = 'SELECT * FROM utilisateur_sdapa  ORDER BY id_utilisateur DESC';
        $stmt = $this->bdd->query($sqlQuery);
        $stmt=$stmt->fetch();
        $id=$stmt[0]+1;


            $requete = $this->bdd->query('INSERT INTO utilisateur_sdapa (id_utilisateur,matricule_utilisateur,nom_utilisateur,prenom_utilisateur,tel_utilisateur,adresse_utilisateur,email_utilisateur,login_utilisateur,mot_passe_utilisateur,id_type_utilisateur,id_etablissement ,id_departement,id_groupe_utilisateur ,id_qualite_utilisateur ,parametres_envoye,date_envoie,heure_envoie,connexion_reussie,date_derniere_connexion,heure_derniere_connexion) VALUES("'.$id.'",
        "","'.$this->nom_utilisateur.'","'.$this->prenom_utilisateur.'","'.$this->tel_utilisateur.'","","'.$this->email_utilisateur.'","'.$this->login_utilisateur.'","'.$this->mot_passe_utilisateur.'",NULL,"'.$this->id_etablissement .'","'.$this->id_departement.'","'.$this->id_groupe_utilisateur .'",NULL,"OUI","'.date('Y-m-d').'"," "," ","'.date('Y-m-d').'"," ")')or die(print_r($this->bdd->errorInfo()));

            return 1;





    }



    public function modification()
    {
        $requete = $this->bdd->prepare('UPDATE utilisateur_sdapa SET  nom_utilisateur=:nom_utilisateur , prenom_utilisateur=:prenom_utilisateur ,  login_utilisateur=:login_utilisateur ,  mot_passe_utilisateur=:mot_passe_utilisateur,email_utilisateur=:email_utilisateur ,id_departement=:id_departement ,id_etablissement=:id_etablissement ,id_groupe_utilisateur=:id_groupe_utilisateur,tel_utilisateur=:tel_utilisateur   WHERE id_utilisateur=:id_utilisateur');
        $requete->execute(array(
            'nom_utilisateur'=>  $this->nom_utilisateur,
            'id_utilisateur'=>  $this->id_utilisateur,
            'prenom_utilisateur'=>  $this->prenom_utilisateur,
            'login_utilisateur'=>  $this->login_utilisateur,
            'mot_passe_utilisateur'=>  $this->mot_passe_utilisateur,
            'email_utilisateur'=>  $this->email_utilisateur,
            'id_departement'=>  $this->id_departement,
            'id_etablissement'=>  $this->id_etablissement,
            'id_groupe_utilisateur'=>  $this->id_groupe_utilisateur,
            'tel_utilisateur'=>  $this->tel_utilisateur

           
        )) or die(print_r($this->bdd->errorInfo()));

        

    }

    public function modif_pass(){

        $requete = $this->bdd->prepare('UPDATE utilisateur_sdapa SET login_utilisateur=:login_utilisateur ,  mot_passe_utilisateur=:mot_passe_utilisateur WHERE id_utilisateur=:id_utilisateur');
        $requete->execute(array(
            'id_utilisateur'=>  $this->id_utilisateur,
            'login_utilisateur'=>  $this->login_utilisateur,
            'mot_passe_utilisateur'=>  $this->mot_passe_utilisateur


        )) or die(print_r($this->bdd->errorInfo()));
    }

    public function envoyer_email(){
        $requete = $this->bdd->prepare('SELECT * FROM utilisateur_sdapa WHERE id_utilisateur=:id_utilisateur ');
        $requete->execute(array('id_utilisateur' => $this->id_utilisateur
        ));
        $reponse = $requete->fetch();
        $message='Vos accès à SDAP sont : Login: '.$reponse['login_utilisateur'].'  /  Mot de passe: '.$reponse['mot_passe_utilisateur'];
        if ($reponse) {
            send_mail($reponse['email_utilisateur'],'ACCES SDAPA',$message);
            return 1;
        }
    }


    public function suppression()
    {


        $requete = $this->bdd->prepare('DELETE FROM utilisateur_sdapa WHERE id_utilisateur=:id_utilisateur ');
        $requete->execute(array(
            'id_utilisateur' => $this->id_utilisateur));



        return 1;



    }









}

