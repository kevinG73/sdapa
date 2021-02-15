<?php
session_start();
include "../../fonctions/index.php";
include('../../vendor/tcpdf/tcpdf.php');

class MYTCPDF extends TCPDF
{
    public function legende()
    {
        $this->SetFont('Helvetica', '', 7);

        $gn = "Légende : ";
        $this->WriteHTMLCell(275, 10, 15, 50, $gn, 0);
        /* FIP */
        $gn =  "<b>moy</b>  moyenne";
        $this->WriteHTMLCell(275, 10, 35, 50, $gn, 0);
        $grs =   ", <b>TPL</b> Le temps passé en Licence ,";
        $this->WriteHTMLCell(275, 10, 55, 50, $grs, 0);
        $gru = "<b>N.M</b> Le nombre de mention obtenue ,";
        $this->WriteHTMLCell(275, 10, 95, 50, $gru, 0);
        $gru = "<b>P.C</b>  point critère";
        $this->WriteHTMLCell(275, 10, 145, 50, $gru, 0);
    }

    public function title()
    {
        $this->legende();

        $this->SetFont('Helvetica', 'B', 11);
        $pv = "Liste des étudiants admissibles en Master 1";
        $this->WriteHTMLCell('', 10, 105, 15, $pv, 0);
        $this->SetFont('Helvetica', '', 9);
        $this->SetTextColor(0, 0, 0);
    }

    public function Header()
    {
        $this->SetFont('Helvetica', '', 9);
        // Logo de gauche

        $this->Image('../../src/img/logo-ufhb.png', 15, 10, 35, 10, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

        //First Line
        $left = "UFR <br>Unité de Formation ";
        $this->WriteHTMLCell('', 10, 15, 31, $left, 0);

        $left = ": " . DeterminerEtablissement($_SESSION['impression']['id_etablissement']);
        $this->WriteHTMLCell('', 10, 45, 31, $left, 0);

        $left = ": " . DeterminerDepartement($_SESSION['impression']['id_etablissement']);
        $this->WriteHTMLCell('', 10, 45, 35, $left, 0);

        $this->title();


        $annee = DeterminerAnnee($_SESSION['impression']['id_annee']);
        $center = "Année académique : <b>$annee</b>";
        $this->WriteHTMLCell(275, 10, 238, 10, $center, 0);

        $right = "Date d'édition " . date("d/m/Y");
        $this->WriteHTMLCell(275, 10, 238, 15, $right);


        // on trunc le texte si c'est trop long
        $right = "Parcours : " . DeterminerParcours($_SESSION['impression']['id_parcours']);;
        $this->WriteHTMLCell(275, 10, 230, 31, $right, 0);

        $mention = "Mention : " . DeterminerMention($_SESSION['impression']['id_departement']);
        $this->WriteHTMLCell(275, 10, 230, 36, $mention, 0);

    }

    public function Footer()
    {


        $this->SetFont('Helvetica', '', 8);
        // pagination
        $pagingtext = "Page N ° " . $this->PageNo() . "/" . $this->getAliasNbPages();
        //WriteHTMLCell
        $this->WriteHTMLCell(275, 10, 270, 195, $pagingtext, 0);
    }

    /**
     * @param bool $destroyall
     * @param bool $preserve_objcopy
     */
    public function _destroy($destroyall = false, $preserve_objcopy = false)
    {
        if ($destroyall) {
            unset($this->imagekeys);
        }
        parent::_destroy($destroyall, $preserve_objcopy);
    }


}

