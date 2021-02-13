$(document).ready(function () {
    var age = 0;
    /* afficher l'âge de l'étudiant */
    $("#inputDateNaissance").bind('load keyup change click blur mouseup', function () {
        var Bday = +new Date($(this).val());
        var age = parseInt(~~((Date.now() - Bday) / (31557600000)));
        $("#inputAge").val(age);

        /* afficher le point de l'âge à côté du champ age*/
        if (age >= 20 && age < 24) {
            $("#age-point").text(4 + " points");
        } else if (age >= 24 && age < 26) {
            $("#age-point").text(2 + " points");
        } else if (age >= 26) {
            $("#age-point").text(0 + " point");
        }
    });

});