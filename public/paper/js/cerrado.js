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

    var $tableSel = $('#tablaCerrados');
    var table = $tableSel.DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
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

                                return (column == 3) ? data.split('.').join('') : data;
                            }
                        },
                        columns: [1, 2, 3, 4, 5, 6, 7, 8]
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
                    },
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8]
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

        },
        initComplete: complete,
        columnDefs: [
            { targets: 4, render: $.fn.dataTable.render.number('.', ',', 0), className: "text-right", },
            { targets: [5], className: "text-center" },
            {
                targets: [1, 2],
                render: $.fn.dataTable.render.moment('DD/MM/YYYY'),
                className: "text-center"
            },
            {
                targets: 6,
                className: "text-left",
                width: '150px',
                render: function(data, type, row) {

                    return row[11];
                }
            }, {
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let user = $("#tablaCerrados").data('user');
                    let admin = $("#tablaCerrados").data('admin');
                    let rolId = $("#tablaCerrados").data('rol');
                    let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';

                    if (admin || rolId == 6) {

                        celda += '<button title="Editar" class="btn btn-xs btn-outline-secondary" data-cliente="' + row[12] + '" data-accion="btnEdi"><i class="fa fa-edit"></i></button>';

                        celda += '<select class="form-control inptStatus" name="status" data-cliente="' + row[10] + '">';
                        $.each(row[9], function(key, status) {
                            let selected = (row[6] == status.id) ? 'selected' : '';
                            celda += '<option ' + selected + ' value="' + status.id + '" >' + status.nombre + '</option>';
                        });
                        celda += '</select>';

                    } else {

                        if (user == row[13]) {
                            celda += '<select class="form-control inptStatus" name="status" data-cliente="' + row[10] + '">';
                            $.each(row[9], function(key, status) {
                                let selected = (row[6] == status.id) ? 'selected' : '';
                                celda += '<option ' + selected + ' value="' + status.id + '" >' + status.nombre + '</option>';
                            });
                            celda += '</select>';
                        }


                    }
                    celda += '</div>';

                    return celda;
                }
            }
        ]
    });

    table.buttons().container().appendTo('#tablaCerrados_wrapper .col-md-6:eq(0)');

    // table.columns([-1]).visible($("#tablaCerrados").data('rol') == 6 ? false : true);

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

    $(".inputNumber").on('keypress', function(e) {
        var key = window.Event ? e.which : e.keyCode;
        return (key >= 48 && key <= 57 || key == 44)
    }).on('keyup', function(e) {
        $(this).val(format_moneda($(this).val()));
    });

    $("#tablaCerrados tbody").on("click", 'button', function(e) {
        e.preventDefault();

        let accion = $(this).data('accion');
        let cliente = $(this).data('cliente');

        switch (accion) {
            case "btnEdi":

                $("#proymethod").val('put');
                let rutaEdit = $("#tablaCerrados").data('proyeditar');
                let rutaUpdate = $("#tablaCerrados").data('proyactualizar');
                $("#proyruta").val(rutaUpdate.replace("@@", cliente));
                limpiarModalProyecto(true);

                $.ajax({
                    url: rutaEdit.replace("@@", cliente),
                    success: function(data) {
                        if (data.success == 'ok') {
                            $('#frm_update_proyectos').attr('action', rutaUpdate.replace("@@", cliente));
                            $("#nombre").val(data.nombre);
                            $("#fechaCierre").val(data.fecha_cierre);
                            $("#fechaFacturacion").val(data.proyecto_facturas.fecha_factura);
                            $("#inscripcionSence").val(data.proyecto_facturas.inscripcion_sence);
                            $("#montoVenta").val(data.proyecto_facturas.monto_venta);
                            $("#estado").val(data.proyecto_facturas.estado_factura_id);
                            $("#tituloModal").html('Editar Ticket ' + data.cliente.razon_social);
                            $("#update_proyecto_cliente").modal('show');
                        } else {
                            limpiarModalProyecto();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $("#update_proyecto_cliente").modal('hide');
                        $.confirm({
                            title: 'Error',
                            content: 'Error al intentar obtener los datos del proyecto, intente de nuevo mas tarde',
                            type: 'red',
                            theme: 'modern',
                            animation: 'scala',
                            icon: 'fa fa-exclamation-triangle',
                            typeAnimated: true,
                            buttons: {
                                cancel: {
                                    text: 'Aceptar',
                                },
                            }
                        });
                    }
                });

                break;
        }


    });

});

function complete() {
    $(".inptStatus").on('change', function() {
        let valStatus = $(this).val();
        let cliente = $(this).data('cliente');
        let strRuta = $("#tablaCerrados").data('rutastatus');

        let ruta = strRuta.replace("@@", cliente);

        $.ajax({
            url: ruta,
            type: 'POST',
            data: {
                "status": valStatus
            },
            success: function(data) {
                if (data.success == 'ok') {
                    toastr['success'](data.msg, data.title);
                }
                $('#tablaCerrados').DataTable().ajax.reload(complete);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                toastr['danger']('Error al intentar desechar un cliente', 'Error');
            }
        });


    });
}

function limpiarFiltro($tableSel) {
    $.fn.dataTableExt.afnFiltering.length = 0;
    $tableSel.dataTable().fnDraw();
}

var filterByDate = function(column, startDate, endDate, $tableSel) {
    limpiarFiltro($tableSel);
    $.fn.dataTableExt.afnFiltering.push(
        function(oSettings, aData, iDataIndex) {
            var rowDate = normalizeDate(aData[column]),
                start = normalizeDate(startDate),
                end = normalizeDate(endDate);
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

function limpiarModalProyecto(upd = false) {

    if (upd) {
        $(".nombre").removeClass('is-invalid');
        $(".fechaCierre").removeClass('is-invalid');
        $(".fechaFacturacion").removeClass('is-invalid');
        $(".inscripcionSence").removeClass('is-invalid');
        $(".montoVenta").removeClass('is-invalid');
        $(".estado").removeClass('is-invalid');
    } else {
        $(".nombre").val('').removeClass('is-invalid');
        $(".fechaCierre").val('').removeClass('is-invalid');
        $(".fechaFacturacion").val('').removeClass('is-invalid');
        $(".inscripcionSence").val('').removeClass('is-invalid');
        $(".montoVenta").val('').removeClass('is-invalid');
        $(".estado").val('').removeClass('is-invalid');
    }

    $(".invalid-feedback").hide();
}