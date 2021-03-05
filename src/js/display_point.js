var age = 0;
var p_temps1 = 0;
var p_moyenne_annuelle = 0;
var p_nombre_mention = 0;
var p_age = 0;
var total = 0;

$(document).ready(function () {
    /* quand le modal de calcul s'ouvre */
    $('#empModal').on('show.bs.modal', function () {
        determinerAge();
        determinerPointTemps();
        determinerPointMoyenne();
        moyennePondere();
        determinerPointMention();
        total_point_critere();
    });

    /* afficher l'âge de l'étudiant */
    $("#inputDateNaissance").bind('keyup change click blur mouseup', function () {
        determinerAge();
        total_point_critere();
    });

    function determinerAge() {
        var Bday = +new Date($("#inputDateNaissance").val());
        age = parseInt(~~((Date.now() - Bday) / (31557600000))) || 0;
        /* afficher le point de l'âge à côté du champ age*/
        $("#inputAge").val(age)
        if (age < 20) {
            p_age = 0;
        } else if (age >= 20 && age < 24) {
            p_age = 5;
        } else if (age >= 24 && age < 26) {
            p_age = 3;
        } else if (age >= 26) {
            p_age = 1;
        }
        $("#age-point").text(p_age + " points");
    }

    /* temps passé en licence */
    $("#inputTemps1").bind('keyup change click blur mouseup', function (e) {
        if ($(this).val() > 6
            && e.keyCode !== 46
            && e.keyCode !== 8
        ) {
            e.preventDefault();
            $(this).val(3);
        }
        determinerPointTemps();
        total_point_critere();
    });

    function determinerPointTemps() {
        var critere_temps1 = parseInt($("#inputTemps1").val()) || 0;
        p_temps1 = 0;
        /* afficher le point de l'âge à côté du champ age*/
        if (critere_temps1 === 3) {
            p_temps1 = 4;
        } else if (critere_temps1 === 4) {
            p_temps1 = 3;
        } else if (critere_temps1 === 5) {
            p_temps1 = 1;
        } else if (critere_temps1 === 6) {
            p_temps1 = 0;
        }
        $("#temps-point").text(p_temps1 + " point(s)");
    }

    function determinerPointMoyenne() {
        var critere_moyenne_annuelle = parseFloat($("#inputMA").val()) || 0;
        p_moyenne_annuelle = 0;
        if (critere_moyenne_annuelle >= 18 && critere_moyenne_annuelle < 20) {
            p_moyenne_annuelle = 8;
        } else if (critere_moyenne_annuelle >= 16 && critere_moyenne_annuelle < 18) {
            p_moyenne_annuelle = 6;
        } else if (critere_moyenne_annuelle >= 14 && critere_moyenne_annuelle < 16) {
            p_moyenne_annuelle = 5;
        } else if (critere_moyenne_annuelle >= 12 && critere_moyenne_annuelle < 14) {
            p_moyenne_annuelle = 3;
        } else if (critere_moyenne_annuelle >= 11 && critere_moyenne_annuelle < 12) {
            p_moyenne_annuelle = 1;
        } else if (critere_moyenne_annuelle < 11) {
            p_moyenne_annuelle = 0;
        }
        $("#moyenne-point").text(p_moyenne_annuelle + " point(s)");
    }

    /* total mentions */
    $(document).on("change keyup blur mouseup", "#activity_table input", function () {
        determinerPointMention();
    });

    function determinerPointMention() {
        var critere_nombre_mention = parseFloat($("#total_l4_c5").val()) || 0;
        p_nombre_mention = parseInt(critere_nombre_mention) || 0;
    }

    $(document).on("change keyup click blur mouseup", "#empModal input", function () {
        total_point_critere();
    });

    /* pour calculer la moyenne pondéré de la licence */
    $("#inputML1, #inputML2, #inputML3").on("change keyup click blur mouseup", function () {
        if ($("#inputML1").val() > 20 || $("#inputML1").val() < 0) {
            $(this).val(0);
        }

        if ($("#inputML2").val() > 20 || $("#inputML2").val() < 0) {
            $(this).val(0);
        }

        if ($("#inputML3").val() > 20 || $("#inputML3").val() < 0) {
            $(this).val(0);
        }

        var l1 = parseFloat($("#inputML1").val(), 10) || 0;
        var l2 = parseFloat($("#inputML2").val(), 10) || 0;
        var l3 = parseFloat($("#inputML3").val(), 10) || 0;
        var calcul = ((l1 + l2 * 2 + l3 * 4) / 7);

        var resultat = isFinite(calcul) ? calcul : 0;
        $("#inputMA").val(parseFloat(resultat).toFixed(2));

        var critere_moyenne_annuelle = parseFloat($("#inputMA").val()) || 0;
        p_moyenne_annuelle = 0;
        if (critere_moyenne_annuelle >= 18 && critere_moyenne_annuelle < 20) {
            p_moyenne_annuelle = 8;
        } else if (critere_moyenne_annuelle >= 16 && critere_moyenne_annuelle < 18) {
            p_moyenne_annuelle = 6;
        } else if (critere_moyenne_annuelle >= 14 && critere_moyenne_annuelle < 16) {
            p_moyenne_annuelle = 5;
        } else if (critere_moyenne_annuelle >= 12 && critere_moyenne_annuelle < 14) {
            p_moyenne_annuelle = 3;
        } else if (critere_moyenne_annuelle >= 11 && critere_moyenne_annuelle < 12) {
            p_moyenne_annuelle = 1;
        } else if (critere_moyenne_annuelle < 11) {
            p_moyenne_annuelle = 0;
        }
        $("#moyenne-point").text(p_moyenne_annuelle + " point(s)");
    });

});

function total_point_critere() {
    total = p_moyenne_annuelle + p_nombre_mention + p_temps1 + p_age
    $("#point_critere").val(total);
}