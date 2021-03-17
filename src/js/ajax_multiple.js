$(document).ready(function () {
    /* évènement sur la selection d'un établissement */
    $("#id_etablissement").on("change", function () {
        var id_etablissement = $(this).val();
        $.ajax({
            url: "./ajax/fetch_departement.php",
            method: 'GET',
            data: {id_etablissement: id_etablissement},
            success: function (data) {
                $("#id_departement").html(data);

                /* departements */
                var id_departement = $("#id_departement").val();
                var id_niveau = $("#id_niveau").val();

                $.ajax({
                    url: "./ajax/fetch_parcours_multiple.php",
                    method: 'GET',
                    data: {
                        id_departement: id_departement,
                        id_niveau: id_niveau
                    },
                    success: function (data) {
                        $("#id_parcours").html(data);
                    }
                });
            }
        });
    }).trigger("change");


    /* évènement sur la selection d'un département */
    $("#id_departement").on("change", function () {
        /* parcours */
        var id_niveau = $("#id_niveau").val();
        var id_departement = $("#id_departement").val();
        $.ajax({
            url: "./ajax/fetch_parcours_multiple.php",
            method: 'GET',
            data: {id_niveau: id_niveau, id_departement: id_departement},
            success: function (data) {
                $("#id_parcours").html(data);
            }
        });
    });

});


