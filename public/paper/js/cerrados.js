$(function() {

    $('#tablaCerrados thead tr').clone(true).appendTo('#tablaCerrados thead');
    $('#tablaCerrados thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title != 'Acciones' && title != 'Seleccionar') {
            $(this).html('<input type="text" placeholder="Filtrar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        } else {
            $(this).html('');
        }
    });

    var table = $('#tablaCerrados').DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
        // dom: '<lif<t>p>',
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right'B>>" +
            "<'row mb-3'<'col-sm-9'i><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 mt-3'p>}>",
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        buttons: [{
            extend: 'collection',
            text: 'Exportar',
            className: 'btn-sm btn-round dropdown-toggle',
            buttons: [{
                    extend: 'excelHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    autoFilter: true,
                    sheetName: 'Cerrados',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-excel"></i> Excel</a>',
                    action: function(e, dt, button, config) {
                        config.title = 'Cerrados ' + $('#customTotal').text();
                        // $.fn.dataTable.ext.buttons.excelHtml5.action(e, dt, button, config);
                        $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'letter',
                    className: 'dropdown-item',
                    text: '<i class="fas fa-file-pdf"></i> Pdf</a>',
                    action: function(e, dt, button, config) {
                        config.title = 'Cerrados ' + $('#customTotal').text();
                        $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                    }
                },
            ]
        }],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/clientes-cerrados-json",
        drawCallback: function(data) {

            let api = this.api();
            let celda = api.rows({ page: 'current' }).data();
            let totalAnnio = 0;
            let hoy = new Date();
            let annio = hoy.getFullYear().toString().substr(-2);

            celda.each(function(value) {

                let n = value[2].search("-" + annio);

                if (n > 0) {
                    totalAnnio += parseInt(value[4])
                }

            });

            valorFinal = new Intl.NumberFormat(["ban", "id"]).format(totalAnnio);

            $("#customTotal").html('Total (' + hoy.getFullYear() + '): $' + valorFinal);

        },
        rowCallback: function(row, data, index) {
            let mesFacturacion = data[2];

            let hoy = new Date();
            let annio = hoy.getFullYear().toString().substr(-2);

            let n = mesFacturacion.search("-" + annio);
            if (n >= 0) {
                $(row).css('background-color', '#C6FFC7')
            }

        },

        columnDefs: [
            { targets: 4, render: $.fn.dataTable.render.number('.', ',', 0), className: "text-right", },
            { targets: [1, 2], className: "text-center" },
        ]
    });

    table.buttons().container().appendTo('#tablaCerrados_wrapper .col-md-6:eq(0)');

});