<?php
require_once "../config/connexion.php";
require_once('./entete.php');

/* Liste des etudiants en fonctions des critères ci-dessous : */
$filtre = [
    'annee_academique' => $_SESSION['impression']['annee'],
    'id_etablissement' => $_SESSION['impression']['id_etablissement'],
    'id_departement' => $_SESSION['impression']['id_departement'],
    'id_parcours' => $_SESSION['impression']['id_parcours'],
    'niveau_etude' => $_SESSION['impression']['niveau']
];

/* liste des étudiants */
extract($filtre);

global $bdd;
$requete = "select * from inscriptions ins 
    JOIN etudiants etd ON etd.numero_carte = ins.numero_carte
    JOIN sexe ON etd.sexe = sexe.id_sexe
    JOIN nationalite nat ON nat.id_nationalite = etd.nationalite
    where annee = $annee_academique AND
    niveau_etude = $niveau_etude AND id_parcours = $id_parcours AND id_departement = $id_departement";


$resultat = $bdd->query($requete);

if (is_bool($resultat)) {
    $etudiants = array();
} else {
    $etudiants = $resultat->fetchAll();
}


$liste_decouper = array_chunk($etudiants, 12);


/* make TCPDF object */
$pdf = new MYTCPDF('L', 'mm', 'A4');
$pdf->SetMargins(15, 50, 10);
$pdf->setFontSubsetting(false);

$tbl = '';

$tbl_header = '
    <style>
	table{
		font-size:7px;
	}
	td , th{
	    text-align:left;
	}
</style>
<table nobr="true" width="100%" border="1"  cellspacing="0" cellpadding="3">
  <tr>
    <th width="10%"><b>Nom</b></th>
    <th style="text-align:left;" width="20%"><b>Prénom</b></th>
    <th width="5%"><b>Genre</b></th>
    <th width="12%">Date de naissance</th>
    <th width="12%">Lieu de naissance</th>
    <th width="12%">Nationalité</th>
    <th width="5%">moy L1</th>
    <th width="5%">moy L2</th>
    <th width="5%">moy L3</th>
    <th width="5%">TPL</th>
    <th width="5%">N.M</th>
    <th width="5%">P.C</th>
  </tr>';
$tbl_footer = '</table>';

foreach ($liste_decouper as $index => $etd) {
    foreach ($etd as $et) {
        $tbl .= '
<tr>
    <td> ' . $et['nom'] . '</td>
    <td> ' . $et['prenoms'] . '</td>
	<td>' . $et['libelle_sexe_court'] . '</td>
    <td>' . $et['date_naissance'] . '</td>
    <td>' . $et['lieu_naissance'] . '</td>
    <td>' . $et['libelle_nationalite'] . '</td>
    <td> ' . $et['moy_ann_l1'] . '</td>
    <td> ' . $et['moy_ann_l2'] . '</td>
    <td> ' . $et['moy_ann_l3'] . '</td>
    <td> ' . $et['temps_mis_en_Licence'] . '</td>
    <td> ' . $et['nombre_de_mentions'] . '</td>
    <td> ' . $et['total_point_critere'] . '</td>
</tr>
';
    }
    $html = $tbl_header . $tbl . $tbl_footer;
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, false, false, '');
    $tbl = '';
}


//output
$pdf->SetFooterMargin(250);
$pdf->Output('liste-' . rand(),'I');












