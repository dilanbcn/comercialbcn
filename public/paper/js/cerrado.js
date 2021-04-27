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

    // var table = $('#tablaCerrados').DataTable({
    var $tableSel = $('#tablaCerrados');
    var table = $tableSel.DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
        // dom: '<lif<t>p>',
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right''" + $("#tablaCerrados").data("rolexportar") + ">>" +
            "<'row mb-3'<'col-sm-9'i><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 mt-3'p>}>",
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        order: [
            [1, "desc"]
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
                        $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                    },
                    exportOptions: {
                        format: {
                            body: function(data, row, column, node) {
                                return (column == 4) ? data.split('.').join('') : data;
                            }
                        }
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
                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
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
            let annio = hoy.getFullYear().toString();

            celda.each(function(value) {
                let annioCelda = value[1].substr(0, 4);

                if (annioCelda == annio) {
                    totalAnnio += parseInt(value[4])
                }

            });

            valorFinal = new Intl.NumberFormat(["ban", "id"]).format(totalAnnio);

            $("#customTotal").html('Total (' + hoy.getFullYear() + '): $' + valorFinal);

        },
        rowCallback: function(row, data, index) {
            let mesFacturacion = data[1].substr(0, 4);

            let hoy = new Date();
            let annio = hoy.getFullYear().toString();

            let n = mesFacturacion.search("-" + annio);
            if (mesFacturacion == annio) {
                $(row).css('background-color', '#C6FFC7')
            }

            console.log(data[1]);

        },

        columnDefs: [
            { targets: 4, render: $.fn.dataTable.render.number('.', ',', 0), className: "text-right", },
            { targets: [1, 2, 5], className: "text-center" },
        ]
    });

    table.buttons().container().appendTo('#tablaCerrados_wrapper .col-md-6:eq(0)');

    $("#btn-filtrar").on('click', function(e) {
        e.preventDefault();

        let fecha = $("#filterFecha").val();
        let desde = $("#filterDesde").val();
        let hasta = $("#filterHasta").val();

        if (!fecha) {
            $("#filterFecha").addClass('is-invalid');
            return false;
        }

        if (!desde) {
            $("#filterDesde").addClass('is-invalid');
            return false;
        }

        if (!hasta) {
            $("#filterHasta").addClass('is-invalid');
            return false;
        }

        filterByDate(fecha, desde, hasta, $tableSel);

        $tableSel.dataTable().fnDraw();

    });

    $(".inpt-filter").on('change', function() {
        $(this).removeClass('is-invalid');
    });


    $('#btn-limpiar').on('click', function(e) {
        e.preventDefault();
        limpiarFiltro($tableSel);
    });

});

function limpiarFiltro($tableSel) {
    $.fn.dataTableExt.afnFiltering.length = 0;
    $tableSel.dataTable().fnDraw();
}

var filterByDate = function(column, startDate, endDate, $tableSel) {
    limpiarFiltro($tableSel);
    // Custom filter syntax requires pushing the new filter to the global filter array
    $.fn.dataTableExt.afnFiltering.push(
        function(oSettings, aData, iDataIndex) {
            var rowDate = normalizeDate(aData[column]),
                start = normalizeDate(startDate),
                end = normalizeDate(endDate);
            // If our date from the row is between the start and end
            if (start <= rowDate && rowDate <= end) {
                return true;
            } else if (rowDate >= start && end === '' && start !== '') {
                return true;
            } else if (rowDate <= end && start === '' && end !== '') {
                return true;
            } else {
                return false;
            }
        }
    );
};

var normalizeDate = function(dateString) {
    var date = new Date(dateString);
    var normalized = date.getFullYear() + '' + (("0" + (date.getMonth() + 1)).slice(-2)) + '' + ("0" + date.getDate()).slice(-2);
    return normalized;
}