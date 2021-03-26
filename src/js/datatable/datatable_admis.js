$(document).ready(function () {
    $('#dataTable-etd').DataTable(
        {
            order: [[5, "desc"]],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.22/i18n/French.json"
            }
        }
    );
});


