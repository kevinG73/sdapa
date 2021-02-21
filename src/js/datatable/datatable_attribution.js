var dataTTT

$(document).ready(function () {
    chargerDatatable(24, 1, 4);

    /* fonction pour charger les données du datatable */
    function chargerDatatable(id_departement, id_parcours, id_annee) {
        dataTTT = $('#dataTable-attribution').DataTable(
            {
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.22/i18n/French.json"
                },
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
                    {data: 'moy_pondere', title: 'moyenne licence'},
                    {data: 'total_mention', title: 'nbre total mentions'},
                    {data: 'total_point_critere', title: 'point critère'},
                    {
                        data: "id", render: function (data, type, row, meta) {
                            return '<button class="btn btn-sm btn-primary btn-determiner"  data-id="' + data + '" >affecter</a>';
                        }
                    }
                ]
            }
        );
    }

    /* clique sur un bouton du datatable */
    $("#dataTable-attribution").on("click", ".btn-determiner", function (e) {
        e.preventDefault();
        var eventId = $(this).data('id');

        // AJAX request
        $.ajax({
            url: './ajax/orientation.php',
            type: 'post',
            data: {etudiantid: eventId},
            success: function (response) {
                var myArray = jQuery.parseJSON(response);
                $("#id_etudiant").val(myArray.info.id_etudiant)
                $("#numero_carte").val(myArray.info.numero_carte);
                $("#inputNom").val(myArray.info.nom);
                $("#inputPrenom").val(myArray.info.prenoms);
                $("#selectParcours").html(myArray.parcours);
                // Display Modal
                $('#orientationModal').modal('show');
            }
        });

    });

    /* bouton save pour enregister les points */
    $("#btn-save").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("forms");
        var fd = new FormData(myform);
        $.ajax({
            url: 'ajax/enregistrer_orientation.php',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                $("#orientationModal").modal('hide');
                dataTTT.ajax.reload()
            }
        });
    });
});


