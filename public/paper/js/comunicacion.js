$(function() {

    $('#tablaComunicacion thead tr').clone(true).appendTo('#tablaComunicacion thead');
    $('#tablaComunicacion thead tr:eq(1) th').each(function(i) {
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
    var table = $('#tablaComunicacion').DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
        dom: '<lif<t>p>',
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/cliente-comunicacion-json",

        columnDefs: [{
                targets: -1,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let celda = '<div class="btn-group" role="group" aria-label="Grupo Acciones">';
                    let rutaEdit = $("#tablaComunicacion").data('rutaedit');
                    let rutaComunicacion = $("#tablaComunicacion").data('rutacomunicacion');

                    celda += '<button data-accion="btnVer" id="' + row[4] + '" data-rutaedit="' + rutaEdit.replace("@@", row[4]) + '" title="Ver" class="btn btn-xs btn-outline-secondary"><i class="fas fa-eye"></i></button>';
                    celda += '<button data-accion="btnAdd" id="' + row[4] + '" title="Agregar" class="btn btn-xs btn-outline-secondary"><i class="fas fa-comment-medical"></i></button>';
                    celda += '<button class="btn btn-xs btn-outline-info" data-accion="btnNotif"><i class="far fa-bell"></i></button>';

                    if (row[5] > 0) {
                        celda += '<a href="' + rutaComunicacion.replace("@@", row[4]) + '" title="Ver Conversación" class="btn btn-xs btn-outline-secondary"><i class="far fa-comments"></i></a>';
                    }

                    celda += '</di>';

                    return celda;

                },
            },
            {
                targets: 3,
                data: null,
                className: "text-center",
                render: function(data, type, row) {

                    let badged = (row[3] == "Activos") ? "badge-activos" : "badge-inactivos";

                    return '<span class="badge p-2 ' + badged + '">' + row[3] + '</span>';

                },
            }
        ],

    });

    // table.columns([-1]).visible($("#tablaComunicacion").data('rol'));

    $("#tablaComunicacion tbody").on("click", 'button', function(e) {
        e.preventDefault();

        let accion = $(this).data('accion');
        let clienteId = $(this).attr("id");
        let urlForm = $(this).data('rutaedit');

        switch (accion) {
            case "btnVer":
                let ruta = './cliente/' + clienteId;
                $.ajax({
                    url: ruta,
                    success: function(data) {
                        if (data.success == 'ok') {

                            let strFechaInicio = '';
                            if (data.inicio_relacion) {
                                let fechaIni = new Date(data.inicio_relacion.split('-'));
                                strFechaInicio = fechaIni.getDay() + '/' + fechaIni.getMonth() + '/' + fechaIni.getFullYear();
                            }

                            $("#holding").html((data.holding) ? data.holding : '&nbsp;');
                            $("#comercial").html((data.user) ? data.user.name : '&nbsp;');
                            $("#tipo_cliente").html((data.tipo_cliente) ? data.tipo_cliente.nombre : '&nbsp;');
                            $("#inicio_relacion").html(strFechaInicio);
                            $("#estado").html((data.activo == 1) ? 'Activo' : 'Inactivo');
                            $('#nombre_cliente').html(data.razon_social);
                            $('#razon_social').val(data.razon_social);
                            $('#activo').val(data.activo);
                            $('#rut').html((data.rut_cliente) ? data.rut_cliente : '&nbsp;');
                            $('#rubro').html(data.rubro);
                            $("#telefono").html(data.telefono);
                            $('#correo').html(data.email);
                            $('#cantidadEmpleados').val((data.cantidad_empleados) ? data.cantidad_empleados : 0);
                            $('#direccion').html(data.direccion);
                            $("#modal_cliente").modal('show');
                            $("#frm_cliente_prosp").attr('action', urlForm);

                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $("#modal_cliente").modal('hide');
                        $.confirm({
                            title: 'Error',
                            content: 'Error al intentar obtener los datos del cliente, intente de nuevo mas tarde',
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
            case "btnAdd":
                $("#opt_cliente").val(clienteId);
                $("#opt_cliente option[value='" + clienteId + "']").prop("selected", true);
                $('.selectpicker').selectpicker('refresh');
                $("#add_cliente_comunicacion").modal('show');

                $.ajax({
                    url: './cliente-contacto-json/' + clienteId,
                    success: function(contactos) {
                        let optSel = '<option value="" selected>[Seleccione]</option>';
                        if (contactos.length > 0) {
                            $.each(contactos, function(key, contacto) {
                                optSel += '<option value="' + contacto.id + '" >' + contacto.nombre + ' ' + contacto.apellido + '</option>';
                            });
                        }
                        $("#contactoId").html('').append(optSel);
                    }
                });
                break;
        }
    });

    var tbLlamados = $('#tablaLlamados').DataTable({
        language: {
            url: "/paper/js/spanish.json"
        },
        dom: "<'row mb-3' <'col-sm-6'l><'col-sm-6 text-right'B>>" +
            "<'row mb-3'<'col-sm-9'i><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 mt-3'p>}>",
        pageLength: -1,
        lengthMenu: [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: "/cliente-comunicacionresumen-json",
        columns: [
            { "width": "10px" },
            { "width": "50px" },
            { "width": "50px" },
            { "width": "90px" },
            { "width": "20px" },
            { "width": "190px" },
            { "width": "190px" },
        ],
        columnDefs: [{
                targets: 0,
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            { targets: [4], className: "text-center" },
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

    $('#tablaLlamados tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = tbLlamados.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });


});


function format(row) {

    let celdas = '';

    celdas += (row[7]) ? '<p class="p-3 m-0"><span>Rubro: ' + (row[7]) + '</span></p>' : '';
    celdas += (row[8]) ? '<p class="p-3 m-0" style="background-color: rgba(0,0,0,.05)"><span>Dirección: ' + (row[8]) + '</span></p>' : '';
    celdas += (row[9]) ? '<p class="p-3 m-0"><span>Correo: ' + (row[9]) + '</span></p>' : '';
    celdas += (row[10]) ? '<p class="p-3 m-0" style="background-color: rgba(0,0,0,.05)"><span>N° Trabajadores: ' + (row[10]) + '</span></p>' : '';

    return celdas;
}