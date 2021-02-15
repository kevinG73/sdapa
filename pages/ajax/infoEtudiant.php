<?php

require "../../config/connexion.php";
require "../../fonctions/index.php";
require "../../fonctions/fonction.php";


$etudiantID = $_POST['etudiantid'];

$ab = 0;
$mb = 0;
$tb = 0;
$tm = 0;
$moyp = 0;

if (isset($etudiantID) && !empty($_POST['etudiantid'])) {
    $info = infoEtudiant($etudiantID);
    $totalMention = fetchTotalMention($info["id_etudiant"]);


    $tableau = "<tr> <th>Niveau</th> <th>AB</th> <th>B</th> <th>TB</th><th>Nombre total de mention</th><th>Moyenne pondérée</th> </tr>";
    for ($i = 0; $i <= 2; $i++):

        $ab += $totalMention[$i]['ab'];
        $mb += $totalMention[$i]['mb'];
        $tb += $totalMention[$i]['tb'];
        $tm += $totalMention[$i]['total_mention'];
        $moyp += $totalMention[$i]['moy_pondere'];

        $a = $i + 1;
        $tableau .= <<<EOT
                    <tr class="w-100">
                    <td class="text-uppercase align-middle">L{$a}</td>
                    <td class="align-middle">
                        <input type="number" min="0" max="14" value="{$totalMention[$i]['ab']}"
                          id="mention_l{$a}_c1" name="mention_l{$a}_c1" class="form-control saisie">
                    </td>
                    <td class="align-middle">
                         <input type="number" min="0" max="14" value="{$totalMention[$i]['mb']}"
                         id="mention_l{$a}_c2" name="mention_l{$a}_c2" class="form-control saisie">
                    </td>
                    <td class="align-middle">
                         <input type="number" min="0" max="14" value="{$totalMention[$i]['tb']}"
                         id="mention_l{$a}_c3" name="mention_l{$a}_c3" class="form-control saisie">
                    </td>
                    <td class="align-middle">
                         <input type="text" min="0" max="14" value="{$totalMention[$i]['total_mention']}"
                         id="total_l{$a}_c4" name="total_l{$a}" class="form-control" readonly>
                    </td>
                    <td class="align-middle">
                         <input type="number" min="0" max="14" value="{$totalMention[$i]['moy_pondere']}"
                         id="total_l{$a}_c5" readonly name="moypond_l{$a}" class="form-control">
                    </td>
                   </tr>        
EOT;

    endfor;

    $tableau .= <<<EOT
                    <tr class="w-100">
                    <td class="text-uppercase align-middle">TOTAL</td>
                    <td class="align-middle">
                        <input type="number" min="0" max="14" value="{$ab}" readonly
                          id="mention_l4_c1" name="mention_l4_c1" class="form-control saisie">
                    </td>
                    <td class="align-middle">
                         <input type="number" min="0" max="14" value="{$mb}"  readonly
                         id="mention_l4_c2" name="mention_l4_c2" class="form-control saisie">
                    </td>
                    <td class="align-middle">
                         <input type="number" min="0" max="14"  value="{$tb}"  readonly
                         id="mention_l4_c3" name="mention_l4_c3" class="form-control saisie">
                    </td>
                    <td class="align-middle">
                         <input type="text" min="0" max="14"  value="{$tm}" 
                         id="total_l4_c4" name="total_l4" class="form-control" readonly>
                    </td>
                    <td class="align-middle">
                         <input type="number" min="0" max="14" value="{$moyp}"
                         id="total_l4_c5" readonly name="moypond_l4" class="form-control text-danger">
                    </td>
                   </tr>        
EOT;


    echo json_encode(array(
        'info' => $info,
        'total_mention' => $tableau
    ));
}
exit;