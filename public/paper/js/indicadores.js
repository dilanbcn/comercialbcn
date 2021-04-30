$(function() {

    $('.tablaIndicadores').DataTable({
        language: {
            url: "/paper/js/spanish.json",
        },
        order: [
            [0, 'asc']
        ],
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right'B>>" +
            "<'row mb-3'<'col-sm-9'i><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 mt-3'p>}>",
        rowGroup: {
            dataSrc: 0
        },
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        buttons: [{
            extend: 'collection',
            text: 'Exportar',
            className: 'btn-sm btn-round dropdown-toggle',
            disable: true,
            buttons: [{
                    extend: 'excelHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    autoFilter: true,
                    sheetName: 'Clientes General',
                    title: 'Clientes General',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-excel"></i> Excel</a>'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    title: 'Clientes General',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-pdf"></i> Pdf</a>'
                },
            ]
        }],
    });


});