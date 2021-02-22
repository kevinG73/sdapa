function updateTotals() {
    /* ligne total */
    $('td:not(:first-child):not(:last-child)',
        '#activity_table tr:eq(1)').each(function () {
        var ci = this.cellIndex;
        var total = 0;
        $('td',
            '#activity_table tr:gt(0)')
            .filter(function () {
                return this.cellIndex === ci;
            })
            .each(function () {
                var inp = $('input', this);
                if (inp.length) {
                    if (!$(this).closest('tr').is(':last-child')) {
                        if ($('input', this).val() > 14
                        ) {
                            total += $('input', this).val(0) * 1;
                        } else {
                            total += $('input', this).val() * 1;
                        }
                    } else {
                        $('input', this).val(total)
                        moyennePondere();
                    }
                }
            });
    });
    /* colonne totale */
    $('#activity_table tr:gt(0)').each(function () {
        var total = 0;
        $('td:not(:first-child):not(:last-child):not(:nth-last-child(2))',
            this).each(function () {
            total += $('input', this).val() * 1;
        });
        $('input', this).eq(3).val(total)

    });
}


function moyennePondere() {

    var l1c1 = parseInt($("#mention_l1_c1").val()) || 0;
    var l1c2 = parseInt($("#mention_l1_c2").val()) || 0;
    var l1c3 = parseInt($("#mention_l1_c3").val()) || 0;

    var l2c1 = parseInt($("#mention_l2_c1").val()) || 0;
    var l2c2 = parseInt($("#mention_l2_c2").val()) || 0;
    var l2c3 = parseInt($("#mention_l2_c3").val()) || 0;

    var l3c1 = parseInt($("#mention_l3_c1").val()) || 0;
    var l3c2 = parseInt($("#mention_l3_c2").val()) || 0;
    var l3c3 = parseInt($("#mention_l3_c3").val()) || 0;

    var moyp1 = parseFloat((l1c1 + (l1c2 * 2) + (l1c3 * 3)) / 6);
    var moyp2 = parseFloat((l2c1 + (l2c2 * 2) + (l2c3 * 3)) / 6);
    var moyp3 = parseFloat((l3c1 + (l3c2 * 2) + (l3c3 * 3)) / 6);
    var total = (moyp1 + moyp2 * 2 + moyp3 * 4) / 7;

    $("#total_l1_c5").val(moyp1.toFixed(2));
    $("#total_l2_c5").val(moyp2.toFixed(2));
    $("#total_l3_c5").val(moyp3.toFixed(2));
    $("#total_l4_c5").val(total.toFixed(2));
}


/* mentions */


updateTotals();
moyennePondere();

$(document).on("change keyup blur mouseup", "#activity_table input", function () {
    updateTotals();
    total_point_critere();
});