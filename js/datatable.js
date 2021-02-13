var dataTTT

$(document).ready(function () {
    /* clique sur le bouton consulter */
    $("#consulter").click(function (e) {
        e.preventDefault();
        /* parcours */
        var id_departement = $("#id_departement").val();
        var id_parcours = $("#id_parcours").val();
        var id_annee = $("#id_annee").val();
        chargerDatatable(id_departement, id_parcours, id_annee);
    });

    /* fonction pour charger les données du datatable */
    function chargerDatatable(id_departement, id_parcours, id_annee) {
        dataTTT = $('#dataTable').DataTable(
            {
                bDestroy: true,
                ajax: {
                    url: './ajax/fetch_etudiant.php',
                    contentType: "application/json",
                    data: {
                        "id_departement": id_departement,
                        "id_annee": id_annee,
                        "id_parcours": id_parcours
                    }
                },
                columns: [
                    {data: 'nom', title: 'nom'},
                    {data: 'prenoms', title: 'prenoms'},
                    {data: 'moy_ann_l1', title: 'moy l1'},
                    {data: 'moy_ann_l2', title: 'moy l2'},
                    {data: 'moy_ann_l3', title: 'moy l3'},
                    {data: 'total_point_critere', title: 'point critère'},
                    {
                        data: "id", render: function (data, type, row, meta) {
                            return '<button class="btn btn-sm btn-primary btn-determiner"  data-id="' + data + '" >calculer</a>';
                        }
                    }
                ]
            }
        );
    }

    /* clique sur un bouton du datatable */
    $("#dataTable").on("click", ".btn-determiner", function () {
        var eventId = $(this).data('id');

        // AJAX request
        $.ajax({
            url: './ajax/infoEtudiant.php',
            type: 'post',
            data: {etudiantid: eventId},
            success: function (response) {
                var myArray = jQuery.parseJSON(response);
                $("#id_etudiant").val(myArray.id_etudiant)
                $("#numero_carte").val(myArray.numero_carte);
                $("#inputNom").val(myArray.nom);
                $("#inputPrenom").val(myArray.prenoms);
                $("#inputDateNaissance").val(myArray.date_naissance);
                $("#inputNationalite").val(myArray.libelle_nationalite);
                $("#inputNbMention").val(myArray.nombre_de_mentions);
                $("#inputTemps1").val(myArray.temps_mis_en_Licence);
                $("#inputML1").val(myArray.moy_ann_l1);
                $("#inputML2").val(myArray.moy_ann_l2);
                $("#inputML3").val(myArray.moy_ann_l3);
                $("#inputMA").val(myArray.moy_pondere);


                // Display Modal
                $('#empModal').modal('show');
            }
        });

    });

    /* bouton save pour enregister les points */
    $("#btn-save").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("forms");
        var fd = new FormData(myform);
        $.ajax({
            url: './ajax/calcul.php',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                $('#empModal').modal('hide');
                dataTTT.ajax.reload()
            }
        });
    });

    /* pour calculer la moyenne pondere */
    $("#inputML1, #inputML2, #inputML3").change(function () {
        var l1 = parseFloat($("#inputML1").val(), 10);
        var l2 = parseFloat($("#inputML2").val(), 10);
        var l3 = parseFloat($("#inputML3").val(), 10);
        var calcul = ((l1 + l2 + l3) / 3);
        var resultat = isFinite(calcul) ? calcul : 0;
        $("#inputMA").val(parseFloat(resultat).toFixed(2));
    });

});


