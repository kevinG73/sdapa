$(document).ready(function () {
    var nbre1 = parseFloat($("#inputML1").val()) || 0;
    var nbre2 = parseFloat($("#inputML2").val()) || 0;
    var nbre3 = parseFloat($("#inputML3").val()) || 0;

    $(".moyenne").each(function () {
        $(this).bind('keyup change click blur mouseup', function () {
            var total = parseFloat((nbre1 + nbre2 + nbre3) / 3) || 0;
            $("#inputMA").val(total.toFixed(2))
        });
    });
});

